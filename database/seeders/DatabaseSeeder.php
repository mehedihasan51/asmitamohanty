<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountrySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(PageSeeder::class); 
        $this->call(TransactionSeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(ConditionSeeder::class);
        $this->call(ClothForSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(MeasurementSeeder::class);
    }
}
