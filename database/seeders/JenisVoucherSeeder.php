<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\M_jenis_voucher;

class JenisVoucherSeeder extends Seeder
{
    public function run()
    {
        M_jenis_voucher::create([
            'nama_jenis_voucher' => '1000_2JAM',
            'masa_berlaku' => '2 Jam',
            'kecepatan'=>'1 Mbps',
            'bobot' => 1,
            'harga' => '1000',
            'stok_tersedia' => '0',
            'stok_terjual' => '0',
        ]);

        M_jenis_voucher::create([
            'nama_jenis_voucher' => '3000_10JAM',
            'masa_berlaku' => '10 Jam',
            'kecepatan'=>'2 Mbps',
            'bobot' => 2,
            'harga' => '3000',
            'stok_tersedia' => '0',
            'stok_terjual' => '0',
        ]);

        M_jenis_voucher::create([
            'nama_jenis_voucher' => '5000_24JAM',
            'masa_berlaku' => '24 Jam',
            'kecepatan'=>'3 Mbps',
            'bobot' => 3,
            'harga' => '5000',
            'stok_tersedia' => '0',
            'stok_terjual' => '0',
        ]);
        M_jenis_voucher::create([
            'nama_jenis_voucher' => '10000_50JAM',
            'masa_berlaku' => '50 Jam',
            'kecepatan'=>'4 Mbps',
            'bobot' => 4,
            'harga' => '10000',
            'stok_tersedia' => '0',
            'stok_terjual' => '0',
        ]);
    }
}
