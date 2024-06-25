<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['id_pelanggan'=>'3120624','name' => 'Asep', 'email' => 'asep@example.com'],
            ['id_pelanggan'=>'4120624','name' => 'Lisna', 'email' => 'lisna@example.com'],
            ['id_pelanggan'=>'5120624','name' => 'Raisa', 'email' => 'raisa@example.com'],
            ['id_pelanggan'=>'6120624','name' => 'Yoga', 'email' => 'yoga@example.com'],
            ['id_pelanggan'=>'7120624','name' => 'Rendra', 'email' => 'rendra@example.com'],
            ['id_pelanggan'=>'8120624','name' => 'Mia', 'email' => 'mia@example.com'],
            ['id_pelanggan'=>'9120624','name' => 'Rizky', 'email' => 'rizky@example.com'],
            ['id_pelanggan'=>'10120624','name' => 'Farah', 'email' => 'farah@example.com'],
            ['id_pelanggan'=>'11120624','name' => 'Dian', 'email' => 'dian@example.com'],
            ['id_pelanggan'=>'12120624','name' => 'Wati', 'email' => 'wati@example.com'],
            ['id_pelanggan'=>'13120624','name' => 'Rani', 'email' => 'rani@example.com'],
            ['id_pelanggan'=>'14120624','name' => 'Dedi', 'email' => 'dedi@example.com'],
            ['id_pelanggan'=>'15120624','name' => 'Agus', 'email' => 'agus@example.com'],
            ['id_pelanggan'=>'16120624','name' => 'Indra', 'email' => 'indra@example.com'],
            ['id_pelanggan'=>'17120624','name' => 'Bayu', 'email' => 'bayu@example.com'],
            ['id_pelanggan'=>'18120624','name' => 'Rina', 'email' => 'rina@example.com'],
            ['id_pelanggan'=>'19120624','name' => 'Lia', 'email' => 'lia@example.com'],
            ['id_pelanggan'=>'20120624','name' => 'Sari', 'email' => 'sari@example.com'],
            ['id_pelanggan'=>'21120624','name' => 'Dewi', 'email' => 'dewi@example.com'],
            ['id_pelanggan'=>'22120624','name' => 'Tina', 'email' => 'tina@example.com'],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'id_pelanggan' => $user['id_pelanggan'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => 'User',
                'last_login' => now(),
                'last_logout' => now(),
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Replace with a secure password
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
