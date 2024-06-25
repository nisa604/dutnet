<?php

namespace Database\Seeders;

use App\Models\M_master_reward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterRewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        M_master_reward::create([
            'segmen'=> 'Very High',
            'min_score' => '20',
            'reward' => '90',
        ]);

        M_master_reward::create([
            'segmen'=> 'High',
            'min_score' => '15',
            'reward' => '0',
        ]);

        M_master_reward::create([
            'segmen'=> 'Medium',
            'min_score' => '10',
            'reward' => '25',
        ]);

        M_master_reward::create([
            'segmen'=> 'Low',
            'min_score' => '5',
            'reward' => '20',
        ]);

        M_master_reward::create([
            'segmen'=> 'Very Low',
            'min_score' => '0',
            'reward' => '15',
        ]);
    }
}
