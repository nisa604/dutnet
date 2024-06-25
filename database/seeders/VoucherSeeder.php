<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\M_voucher;

class VoucherSeeder extends Seeder
{
    public function run()
    {
        M_voucher::create([
            'kode_voucher' => 'VOUCHER001',
            'status_voucher' => 'aktif',
            'id_jenis' => '1',
            'harga_voucher' => 10000,
        ]);

        M_voucher::create([
            'kode_voucher' => 'VOUCHER002',
            'status_voucher' => 'aktif',
            'id_jenis' => '2',
            'harga_voucher' => 20000,
        ]);

    }
}
