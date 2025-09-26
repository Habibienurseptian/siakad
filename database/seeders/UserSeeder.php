<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Utama',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Staf Sekolah',
                'email' => 'staf@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'staf',
            ],
            [
                'name' => 'Guru Matematika',
                'email' => 'guru@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
            ],
            [
                'name' => 'Siswa A',
                'email' => 'siswa@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'murid',
            ],
        ]);
    }
}
