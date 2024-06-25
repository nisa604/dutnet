<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LogDurasiSeeder extends Seeder
{
    public function run()
    {
        $log_durasi = [
            // ['id_pelanggan' => 1, 'engagement' => rand(10, 100)],
            // ['id_pelanggan' => 2120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 3120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 4120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 5120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 6120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 7120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 8120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 9120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 10120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 11120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 12120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 13120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 14120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 15120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 16120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 17120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 18120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 19120624, 'engagement' => rand(10, 100)],
            ['id_pelanggan' => 20120624, 'engagement' => rand(10, 100)],
        ];

        foreach ($log_durasi as $log) {
            DB::table('kunjungan_page')->insert([
                'id_pelanggan' => $log['id_pelanggan'],
                'engagement' => $log['engagement'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
