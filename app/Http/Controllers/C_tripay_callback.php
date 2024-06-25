<?php

namespace App\Http\Controllers;
use App\Models\M_detail_pembelian_voucher;
use App\Models\M_transaksi;
use App\Models\M_voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class C_tripay_callback extends Controller
{
    protected $privateKey = '0Cu1b-AyDd5-vx8o3-jPmMy-VhSFI';

    public function handle(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $this->privateKey);

        if ($signature !== (string) $callbackSignature) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid signature',
            ]);
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return Response::json([
                'success' => false,
                'message' => 'Unrecognized callback event, no action was taken',
            ]);
        }

        $data = json_decode($json);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return Response::json([
                'success' => false,
                'message' => 'Invalid data sent by tripay',
            ]);
        }

        $reference = $data->reference;
        $status = strtoupper((string) $data->status);

        if ($data->is_closed_payment === 1) {
            // Cari transaksi berdasarkan reference
            $transaction = M_detail_pembelian_voucher::where('reference', $reference)->first();

            if (! $transaction) {
                return Response::json([
                    'success' => false,
                    'message' => 'No transaction found: ' . $reference,
                ]);
            }

            // Ambil detail pembelian berdasarkan id_checkout dari transaksi
            $detailPembelian = M_detail_pembelian_voucher::where('id_checkout', $transaction->id_checkout)->get();

            if (! $detailPembelian->isEmpty()) {
                foreach ($detailPembelian as $detail) {
                    // Update status_bayar berdasarkan status dari Tripay callback
                    switch ($status) {
                        case 'PAID':
                            $detail->update(['status_bayar' => 'PAID']);
                            break;

                        case 'EXPIRED':
                            $detail->update(['status_bayar' => 'EXPIRED']);
                            break;

                        case 'FAILED':
                            $detail->update(['status_bayar' => 'FAILED']);
                            break;

                        default:
                            return Response::json([
                                'success' => false,
                                'message' => 'Unrecognized payment status',
                            ]);
                    }
                }

                if ($status === 'PAID') {
                    // Lanjutkan dengan menambahkan data transaksi
                    $id_checkout = $transaction->id_checkout;
                    $waktu_transaksi = date('Y-m-d H:i:s');
                    $jenis_pembayaran = M_detail_pembelian_voucher::where('id_checkout', $id_checkout)->value('jenis_pembayaran');
                    $id_pelanggan = Auth::id(); 
                    
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
                    }

                    $total_bayar = $detailPembelian->sum('subtotal');
                    $dataTransaksi = [
                        'id_pelanggan' => '1', 
                        'id_checkout' => $id_checkout,
                        'reference' => $reference, 
                        'waktu_transaksi' => $waktu_transaksi,
                        'total_bayar' => $total_bayar,
                        'jenis_pembayaran' => $jenis_pembayaran,
                    ];
                    
                    M_transaksi::create($dataTransaksi);

                    $vouchers = M_voucher::where('id_checkout', $id_checkout)
                    ->where('status_voucher', 'Terjual')->get();
                    
                    // Kembalikan response dengan detail transaksi
                    return Response::json([
                        'success' => true,
                        'dataTransaksi' => $dataTransaksi,
                        'detailPembelian' => $detailPembelian,
                        'vouchers' => $vouchers,
                    ]);
                }
            } else {
                return Response::json([
                    'success' => false,
                    'message' => 'No detail purchase found for transaction: ' . $reference,
                ]);
            }
        }
    }
}

