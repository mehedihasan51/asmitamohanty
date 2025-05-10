<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sizes')->insert([
            [
                'name' => 's',
                'status' => 'active',
            ],
            [
                'name' => 'm',
                'status' => 'active'
            ],
            [
                'name' => 'l',
                'status' => 'active'
            ],
            [
                'name' => 'xl',
                'status' => 'active'
            ],
            [
                'name' => 'xxl',
                'status' => 'active'
            ]
        ]);
    }
}
