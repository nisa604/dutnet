<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_rekap extends Model
{
    use HasFactory;

    protected $table = 'rekap';

    protected $fillable = [
        'waktu_transaksi',
        'nama_jenis_voucher',
        'harga_voucher',
        'kode_voucher',
        'status_voucher'
    ];
}
