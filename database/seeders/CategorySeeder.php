<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'kurta',
                'slug' => 'kurta',
                'status' => 'active',
            ],
            [
                'name' => 'lehenga',
                'slug' => 'lehenga',
                'status' => 'active',
            ],
            [
                'name' => 'saree',
                'slug' => 'saree',
                'status' => 'active',
            ],
            [
                'name' => 'wedding',
                'slug' => 'wedding',
                'status' => 'active',
            ]
        ]);
    }
}
