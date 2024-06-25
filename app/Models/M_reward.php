<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_reward extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'rewards';

    protected $fillable = [
        'id_pelanggan',
        'recency',
        'frequency',
        'monetary',
        'engagement',
        'total_score',
        'created',
        'segmentasi',
        'reward',
        'tgl_expired',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function setTglExpiredAttribute($value)
    {
        // Konversi nilai ke objek Carbon untuk memanipulasi tanggal
        $this->attributes['tgl_expired'] = Carbon::parse($value)->addDay(1);
    }
}
