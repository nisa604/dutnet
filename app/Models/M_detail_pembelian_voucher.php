<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class M_detail_pembelian_voucher extends Model
{
    
    use HasFactory;
    public $timestamps = false;

    protected $table = 'detail_pembelian_voucher';
    protected $fillable = ['id_checkout','id_pelanggan','reference','status_bayar', 'nama_jenis_voucher', 'qty', 'subtotal','jenis_pembayaran'];

    public function jenisVoucher()
    {
        return $this->belongsTo(M_jenis_voucher::class, 'nama_jenis_voucher');
    }
}