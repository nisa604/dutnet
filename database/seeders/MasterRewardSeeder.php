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
            'reward' => '90',
        ]);

        M_master_reward::create([
            'segmen'=> 'High',
            'reward' => '0',
        ]);

        M_master_reward::create([
            'segmen'=> 'Medium',
            'reward' => '25',
        ]);

        M_master_reward::create([
            'segmen'=> 'Low',
            'reward' => '20',
        ]);

        M_master_reward::create([
            'segmen'=> 'Very Low',
            'reward' => '15',
        ]);
    }
}
