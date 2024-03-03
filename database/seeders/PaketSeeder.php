<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pakets')->insert([
            [
                'name' => 'Home 1',
                'price' => 10000,
            ],
            [
                'name' => 'Home 2',
                'price' => 150000,
            ], [
                'name' => 'Home 3',
                'price' => 200000,
            ]
        ]);
    }
}
