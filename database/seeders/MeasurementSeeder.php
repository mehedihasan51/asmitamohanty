<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('measurements')->insert([
            [
                'name' => 'Required length',
                'status' => 'active',
            ],
            [
                'name' => 'Sleeve length',
                'status' => 'active'
            ],
            [
                'name' => 'Shoulders',
                'status' => 'active'
            ],
            [
                'name' => 'Upper chest',
                'status' => 'active'
            ],
            [
                'name' => 'Full bust',
                'status' => 'active'
            ],
            [
                'name' => 'Waist',
                'status' => 'active'
            ],
            [
                'name' => 'Hip',
                'status' => 'active'
            ],
            [
                'name' => 'Thigh',
                'status' => 'active'
            ],
            [
                'name' => 'Knee',
                'status' => 'active'
            ],
            [
                'name' => 'Calf',
                'status' => 'active'
            ]
        ]);
    }
}
