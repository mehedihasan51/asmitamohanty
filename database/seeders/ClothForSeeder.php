<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClothForSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cloth_fors')->insert([
            [
                'name' => 'man',
                'status' => 'active',
            ],
            [
                'name' => 'woman',
                'status' => 'active'
            ],
            [
                'name' => 'other',
                'status' => 'active'
            ]
        ]);
    }
}
