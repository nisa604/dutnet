<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class M_log_durasi extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_page'; 
    protected $fillable = [
        'id_pelanggan',
        'engagement',  // Hanya menyertakan kolom engagement
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pelanggan', 'id_pelanggan');
    }

    public static function logPageVisit()
    {
        $userId = Auth::user()->id_pelanggan;

        // Jumlah halaman yang dikunjungi oleh user ini selama sesi ini
        $pageVisits = self::where('id_pelanggan', $userId)
                          ->whereDate('created_at', now()->toDateString())
                          ->count();

        // Cek apakah entri sudah ada untuk pengguna yang sedang aktif pada hari ini
        $existingLog = self::where('id_pelanggan', $userId)
                           ->whereDate('created_at', now()->toDateString())
                           ->first();

        if ($existingLog) {
            // Jika entri sudah ada, update nilai engagement-nya
            $existingLog->update([
                'engagement' => $existingLog->engagement + $pageVisits,  // Tambahkan engagement baru ke nilai yang ada
            ]);
        } else {
            // Jika entri belum ada, buat entri baru
            self::create([
                'id_pelanggan' => $userId,
                'engagement' => $pageVisits,  // Simpan nilai engagement
            ]);
        }
    }
}
