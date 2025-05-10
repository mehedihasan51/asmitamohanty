<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colors')->insert([
            [
                'name' => 'red',
                'status' => 'active',
            ],
            [
                'name' => 'green',
                'status' => 'active'
            ],
            [
                'name' => 'blue',
                'status' => 'active'
            ],
            [
                'name' => 'black',
                'status' => 'active'
            ],
            [
                'name' => 'white',
                'status' => 'active'
            ]
        ]);
    }
}
