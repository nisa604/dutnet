<?php

namespace App\Observers;

use App\Models\M_voucher;

class VoucherObserver
{
    public function saving(M_voucher $voucher)
    {
        if ($voucher->id_jenis == '3000_10JAM') {
            $voucher->id_jenis = 2;
            $voucher->harga_voucher = 3000;
        }elseif ($voucher->id_jenis == '5000_24JAM') {
            $voucher->id_jenis = 3;
            $voucher->harga_voucher = 5000;
        }elseif ($voucher->id_jenis == '10000_50JAM') {
            $voucher->id_jenis = 4;
            $voucher->harga_voucher = 10000;
        }elseif ($voucher->id_jenis == '1000_2JAM') {
            $voucher->id_jenis = 1;
            $voucher->harga_voucher = 1000;
        }
    }
}
