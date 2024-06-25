<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_voucher;
use App\Models\M_rekap;
use App\Models\M_transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class C_rekap extends Controller
{
    public function rekap()
    {
        // Mengambil data rekap transaksi dari tabel M_detail_pembelian_voucher dan M_transaksi
        $rekapTransaksi = M_transaksi::select(
                'transaksi.waktu_transaksi',
                'jenis_voucher.nama_jenis_voucher',
                'voucher.harga_voucher',
                'voucher.kode_voucher',
                'voucher.status_voucher'
            )
            ->join('detail_pembelian_voucher', 'transaksi.id_checkout', '=', 'detail_pembelian_voucher.id_checkout')
            ->join('jenis_voucher', 'detail_pembelian_voucher.nama_jenis_voucher', '=', 'jenis_voucher.nama_jenis_voucher')
            ->join('voucher', 'voucher.id_jenis', '=', 'jenis_voucher.id')
            ->where('voucher.status_voucher', 'Terjual')
            ->get();
            // dd($rekapTransaksi);

        // Simpan data rekap transaksi ke dalam tabel RekapTransaksi
        DB::transaction(function () use ($rekapTransaksi) {
            foreach ($rekapTransaksi as $rekap) {
                try {
                    // Use firstOrCreate to avoid duplicates based on 'kode_voucher'
                    M_rekap::firstOrCreate(
                        ['kode_voucher' => $rekap->kode_voucher], // Attributes to check for existence
                        [ // Attributes to insert if not found
                            'waktu_transaksi' => $rekap->waktu_transaksi,
                            'nama_jenis_voucher' => $rekap->nama_jenis_voucher,
                            'harga_voucher' => $rekap->harga_voucher,
                            'status_voucher' => $rekap->status_voucher,
                        ]
                    );
                } catch (\Illuminate\Database\QueryException $e) {
                    // Handle duplicate entry exception
                    if ($e->errorInfo[1] === 1062) {
                        // Log or handle the duplicate entry here
                        // For example:
                        Log::error('Duplicate entry detected for kode_voucher: ' . $rekap->kode_voucher);
                        // You can choose to continue with the next iteration or break the loop
                        // continue;
                    } else {
                        // Rethrow the exception if it's not related to duplicate entry
                        throw $e;
                    }
                }
            }
        });

        // DB::transaction(function () use ($rekapTransaksi) {
        //     foreach ($rekapTransaksi as $rekap) {
        //         // Use firstOrCreate to avoid duplicates based on 'kode_voucher'
        //         M_rekap::firstOrCreate(
        //             ['kode_voucher' => $rekap->kode_voucher], // Attributes to check for existence
        //             [ // Attributes to insert if not found
        //                 'waktu_transaksi' => $rekap->waktu_transaksi,
        //                 'nama_jenis_voucher' => $rekap->nama_jenis_voucher,
        //                 'harga_voucher' => $rekap->harga_voucher,
        //                 'status_voucher' => $rekap->status_voucher,
        //             ]
        //         );
        //     }
        // });




        // Hitung pendapatan hari ini
        $today = Carbon::today();
        $pendapatanHariIni = $rekapTransaksi->where('waktu_transaksi', '>=', $today)->sum('harga_voucher');

        // Mengirimkan data ke view rekap.blade.php
        return view('dutanet.rekap', [
            'title' => 'Rekap Transaksi',
            'rekapTransaksi' => $rekapTransaksi,

        ]);
    }
}
