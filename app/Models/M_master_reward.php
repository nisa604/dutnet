<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_master_reward extends Model
{
    use HasFactory;
    protected $table = 'master_reward'; 
    protected $fillable = [
        'segmen',
        'min_score',
        'diskon', 
    ];
}
