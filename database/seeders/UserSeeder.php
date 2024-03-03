<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'nip' => 'nip-001',
            ],
            [
                'name' => 'pegawai',
                'password' => Hash::make('pegawai'),
                'role' => 'pegawai',
                'nip' => 'nip-002',
            ],
        ]);
    }
}