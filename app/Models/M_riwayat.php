<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_riwayat extends Model
{
    use HasFactory;

    protected $table = 'riwayat';

    protected $fillable = [
        'id_pelanggan',
        'reference',
        'waktu_transaksi',
        'total_bayar',
        'jenis_pembayaran',
        'nama_jenis_voucher',
        'qty',
    ];

}
