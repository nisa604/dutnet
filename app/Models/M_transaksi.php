<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class M_transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    public $timestamps = false;

    protected $fillable = [
        'id_pelanggan',
        'id_checkout',
        'reference',
        'waktu_transaksi',
        'total_bayar',
        'status_bayar',
        'jenis_pembayaran',
    ];

    // public function pelanggan()
    // {
    //     return $this->belongsTo(C_pelanggan::class, 'id_pelanggan');
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pelanggan');
    }
}
