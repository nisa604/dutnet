<?php

namespace App\Http\Controllers;
use App\Models\M_detail_pembelian_voucher;
use App\Models\M_transaksi;
use App\Models\M_voucher;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_transaksi extends Controller
{
    public function keranjang()
    {
        $keranjang = session()->get('keranjang', []);

        $totalBelanja = collect($keranjang)->sum(function ($item) {
            return $item['harga'] * $item['qty'];
        });

        return view('pelanggan.page.keranjang', [
            'title' => 'Keranjang',
            'keranjang' => $keranjang,
            'totalBelanja' => $totalBelanja,
        ]);
    }

    public function tambahKeKeranjang(Request $request)
    {
        $namaVoucher = $request->input('nama_jenis_voucher');
        $hargaVoucher = $request->input('harga');
        $qtyVoucher = $request->input('qty');

        // Memeriksa apakah harga voucher adalah 5000 atau tidak
        if ($hargaVoucher != 5000) {
            $keranjang = session()->get('keranjang', []);

            // Memeriksa apakah sudah ada voucher dengan harga yang sama di keranjang
            $indexHargaSama = array_search($hargaVoucher, array_column($keranjang, 'harga'));
            if ($indexHargaSama !== false) {
                return redirect()->back()->with('error', 'Anda hanya dapat membeli satu voucher dengan harga tersebut.');
            }

            $keranjang[] = [
                'nama_jenis_voucher' => $namaVoucher,
                'harga' => $hargaVoucher,
                'qty' => $qtyVoucher,
            ];
        } else {
            // Jika harga adalah 5000, tambahkan item sesuai dengan qty yang dipilih
            $keranjang = session()->get('keranjang', []);
            $keranjang[] = [
                'nama_jenis_voucher' => $namaVoucher,
                'harga' => $hargaVoucher,
                'qty' => $qtyVoucher,
            ];
        }

        session(['keranjang' => $keranjang]);
        return redirect()->back()->with('success', 'Voucher berhasil ditambahkan ke keranjang!');
    }

    public function updateKeranjang($index, Request $request)
    {
        $keranjang = session()->get('keranjang', []);

        if ($request->has('qty_update')) {
            $qtyUpdate = $request->input('qty_update');
            $keranjang[$index]['qty'] = $qtyUpdate;
        } elseif ($request->has('hapus_item')) {
            unset($keranjang[$index]);
            $keranjang = array_values($keranjang);
        }

        session(['keranjang' => $keranjang]);
        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui!');
    }


    //TRANSAKSI
    public function showcheckout()
    {
        $keranjang = session()->get('keranjang', []);
        $totalBelanja = collect($keranjang)->sum(function ($item) {
            return $item['harga'] * $item['qty'];
        });

        $tripay = new C_tripay();
        $channels = $tripay->getPaymentChannels();
        // dd($channels);
        return view('pelanggan.page.checkout', [
            'title' => 'Checkout',
            'keranjang' => $keranjang,
            'totalBelanja' => $totalBelanja,
            'channels' => $channels
        ]);
    }

    public function pembayaran(Request $request)
    {
        $keranjang = json_decode($request->input('keranjang'), true);
        $totalBelanja = $request->input('total_belanja');
        $jenisPembayaran = $request->input('jenis_pembayaran');
        $lastIdCheckout = M_detail_pembelian_voucher::max('id_checkout');
        $idCheckout = $lastIdCheckout ? $lastIdCheckout + 1 : 1;

        $merchantRef = 'DUTA' . time();
        $apiKey = 'DEV-oDLsXay8uCmkE3D2zGdizjS92igQKV4WzWQpGYQm';
        $privateKey = '0Cu1b-AyDd5-vx8o3-jPmMy-VhSFI';
        $merchantCode = 'T31814';

        $user = Auth::user();
        $namapelanggan = $user->name;
        $emailpelanggan = $user->email;
        $idPelanggan = $user->id_pelanggan;

        $orderItems = [];
        foreach ($keranjang as $key => $item) {
            $orderItems[] = [
                'name' => $item['nama_jenis_voucher'],
                'price' => $item['harga'],
                'quantity' => $item['qty']
            ];
            $checkout = new M_detail_pembelian_voucher();
            $checkout->id_checkout = $idCheckout;
            $checkout->id_pelanggan = $idPelanggan;
            $checkout->nama_jenis_voucher = $item['nama_jenis_voucher'];
            $checkout->qty = $item['qty'];
            $checkout->subtotal = $item['harga'] * $item['qty'];
            $checkout->status_bayar = 'UNPAID';
            $checkout->jenis_pembayaran = $jenisPembayaran;
            $checkout->save();
        }

        $data = [
            'method' => $jenisPembayaran,
            'merchant_ref' => $merchantRef,
            'amount' => $totalBelanja,
            'customer_name' => $namapelanggan,
            'customer_email' => $emailpelanggan,
            'customer_phone' => '081234567890',
            'order_items' => $orderItems,
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature' => hash_hmac('sha256', $merchantCode . $merchantRef . $totalBelanja, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://tripay.co.id/api-sandbox/transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response)->data;

        // Mengisi kolom reference pada tabel M_detail_pembelian_voucher
        M_detail_pembelian_voucher::where('id_checkout', $idCheckout)
        ->update(['reference' => $response->reference]);

        session()->forget('keranjang');

        return redirect()->route('detail_pembelian', [
            'id_checkout' => $idCheckout,
            'reference' => $response->reference,
            ])->with('success', 'Proses pembelian berhasil.');
        }



        public function showDetail($id_checkout, $reference)
        {
            $detailPembelian = M_detail_pembelian_voucher::where('id_checkout', $id_checkout)->get();

            $apiKey = 'DEV-oDLsXay8uCmkE3D2zGdizjS92igQKV4WzWQpGYQm';

            $payload = ['reference' => $reference];

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_FRESH_CONNECT  => true,
                CURLOPT_URL            => 'https://tripay.co.id/api-sandbox/transaction/detail?' . http_build_query($payload),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => false,
                CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
                CURLOPT_FAILONERROR    => false,
                CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
            ]);

            $response = curl_exec($curl);
            $error = curl_error($curl);

            curl_close($curl);

            if (!empty($error)) {
                echo $error;
                return;
            }

            $response = json_decode($response)->data;
            // dd($response);

            $user = Auth::user();

            return view('pelanggan.page.pembayaran', compact('detailPembelian', 'reference', 'response', 'user'));
        }

        public function transaksi(Request $request)
        {
            $id_checkout = $request->input('id_checkout');
            $waktu_transaksi = date('Y-m-d H:i:s');
            $jenis_pembayaran = M_detail_pembelian_voucher::where('id_checkout', $id_checkout)->value('jenis_pembayaran');
            $id_pelanggan = Auth::user();

            $detailPembelian = M_detail_pembelian_voucher::where('id_checkout', $id_checkout)->get();

            $reference = M_detail_pembelian_voucher::where('id_checkout', $id_checkout)->value('reference');

            foreach ($detailPembelian as $detail) {
                $qty = $detail->qty;
                $nama_jenis_voucher = $detail->nama_jenis_voucher;

                for ($i = 0; $i < $qty; $i++) {
                    $voucher = M_voucher::getAvailableVoucherByType($nama_jenis_voucher);

                    if ($voucher) {
                        $voucher->id_checkout = $id_checkout;
                        $voucher->status_voucher = 'Terjual';
                        $voucher->save();
                    }
                }

                $detail->status_bayar = 'PAID';
                $detail->save();
            }

            $total_bayar = $detailPembelian->sum('subtotal');
            $dataTransaksi = [
                'id_pelanggan' => $id_pelanggan->id_pelanggan,
                'id_checkout' => $id_checkout,
                'reference' => $reference,
                'waktu_transaksi' => $waktu_transaksi,
                'total_bayar' => $total_bayar,
                'jenis_pembayaran' => $jenis_pembayaran,
            ];
            // dd($dataTransaksi);
            M_transaksi::create($dataTransaksi);

            $vouchers = M_voucher::where('id_checkout', $id_checkout)
            ->where('status_voucher', 'Terjual')->get();

            return view('pelanggan.page.transaksi', [
                'title' => 'Detail Transaksi',
                'dataTransaksi' => $dataTransaksi,
                'pelanggan' => Auth::user(),
                'detailPembelian' => $detailPembelian,
                'vouchers' => $vouchers,
            ]);
        }


    }
    