<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\M_reward;

class M_voucher extends Model
{
    protected $table = 'voucher'; 

    protected $fillable = [
        'kode_voucher',
        'status_voucher',
        'id_jenis',
        'harga_voucher',
        'diskon',
    ];

    protected $attributes = [
        'status_voucher' => 'Tersedia',
    ];

    public function jenisVoucher(): BelongsTo
    {
        return $this->belongsTo(M_jenis_voucher::class, 'id_jenis', 'id');
    }

    public static function getAvailableVoucher()
    {
        return self::where('status_voucher', 'Tersedia')->first();
    }

    public static function getAvailableVoucherByType($nama_jenis_voucher) {
        return self::where('status_voucher', 'Tersedia')
                    ->whereHas('jenisVoucher', function ($query) use ($nama_jenis_voucher) {
                        $query->where('nama_jenis_voucher', $nama_jenis_voucher);
                    })
                    ->first();
    }

    public static function getSoldVoucherByCode($code)
    {
        return self::where('status_voucher', 'Terjual')->where('kode_voucher', $code)->first();
    }

    public function reward()
    {
        return $this->hasOne(M_reward::class, 'id_pelanggan', 'id_pelanggan');
    }
    public function getPriceForSellingAttribute()
   {
    if($this->HasDiscount) { return ($this->price - ($this->price * $this->discount/100));} ;
    return $this->price;

   }
}
//     public function isBeginningOfMonth()
//     {
//         $now = Carbon::now();
//         return $now->day === 1;
//     }

//     // Metode untuk mendapatkan diskon dari model M_reward
//     private function getDiscountFromReward($id_pelanggan)
//     {
//         $reward = M_reward::where('id_pelanggan', $id_pelanggan)
//                            ->orderByDesc('skor')
//                            ->first();

//         if ($reward) {
//         // Ubah logika ini sesuai dengan cara Anda menghitung diskon dari reward
//         return $reward->discount;
//         }
//     }

//     // Metode untuk menghitung harga diskon dengan memperhitungkan diskon dari reward
//     public function getDiscountedPriceAttribute()
//     {
//         if ($this->isBeginningOfMonth()) {
//             $discountPercentage = $this->getDiscountFromReward($this->id_pelanggan);
//             $discountedPrice = $this->harga_voucher * (1 - $discountPercentage / 100);
//             return max($discountedPrice, 0); // Pastikan harga diskon tidak negatif
//         }
//         return $this->harga_voucher;
//     }
// }

