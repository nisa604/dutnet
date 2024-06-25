<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_transaksi;
use App\Models\M_riwayat;
use App\Models\M_detail_pembelian_voucher;
use App\Models\M_voucher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class C_riwayat extends Controller
{
    public function riwayatTransaksi()
{
    // Ambil id pelanggan yang sedang login
    $userId = Auth::user()->id_pelanggan;

    // Ambil data transaksi dari tabel 'transaksi' yang sesuai dengan id pelanggan yang sedang login
    $transactions = M_transaksi::where('id_pelanggan', $userId)->get();

    foreach ($transactions as $transaction) {
        // Cek apakah reference sudah ada dalam tabel riwayat
        $existingRiwayat = M_riwayat::where('reference', $transaction->reference)
            ->where('id_pelanggan', $userId)
            ->exists();

        // Jika reference belum ada, tambahkan ke tabel 'riwayat'
        if (!$existingRiwayat) {
            // Ambil data detail pembelian voucher berdasarkan id_checkout dari transaksi
            $details = M_detail_pembelian_voucher::where('id_checkout', $transaction->id_checkout)
                ->get();

            $totalQty = $details->sum('qty');

            // Simpan data ke tabel 'riwayat'
            M_riwayat::create([
                'id_pelanggan' => $userId, // Menggunakan id pelanggan yang sedang login
                'reference' => $transaction->reference,
                'waktu_transaksi' => $transaction->waktu_transaksi,
                'total_bayar' => $transaction->total_bayar,
                'jenis_pembayaran' => $transaction->jenis_pembayaran,
                'nama_jenis_voucher' => $details->pluck('nama_jenis_voucher')->implode(', '),
                'qty' => $totalQty,
            ]);
        }
    }

    // Ambil data riwayat transaksi setelah disinkronisasi
    $riwayatTransaksi = M_riwayat::where('id_pelanggan', $userId)->get();

    // Kembalikan view dengan data riwayatTransaksi
    return view('pelanggan.page.riwayatpelanggan', [
        'title' => 'Riwayat Transaksi',
        'riwayatTransaksi' => $riwayatTransaksi,
    ]);
}

public function detailRiwayat($id_checkout)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = M_transaksi::findOrFail($id_checkout);

        // Ambil data user berdasarkan ID pelanggan
        $user = User::findOrFail($transaksi->id_pelanggan);

        // Ambil data detail pembelian voucher berdasarkan ID checkout
        $details = M_detail_pembelian_voucher::where('id_checkout', $transaksi->id_checkout)
            ->get();

        // Kirim data ke view detail
        return view('riwayat.detail', [
            'title' => 'Detail Riwayat Transaksi',
            'transaksi' => $transaksi,
            'user' => $user,
            'details' => $details,
        ]);
    }


}

