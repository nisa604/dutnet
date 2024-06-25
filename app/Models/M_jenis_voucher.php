<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_jenis_voucher extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'jenis_voucher'; 

    protected $fillable = [
        'nama_jenis_voucher',
        'harga',
    ];
}
