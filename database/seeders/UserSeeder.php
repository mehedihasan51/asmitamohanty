<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('permissions')->insert([
            ['name' => 'web_insert', 'guard_name' => 'web'],
            ['name' => 'web_update', 'guard_name' => 'web'],
            ['name' => 'web_delete', 'guard_name' => 'web'],
            ['name' => 'web_view', 'guard_name' => 'web'],
            ['name' => 'api_insert', 'guard_name' => 'api'],
            ['name' => 'api_update', 'guard_name' => 'api'],
            ['name' => 'api_delete', 'guard_name' => 'api'],
            ['name' => 'api_view', 'guard_name' => 'api'],
        ]);

        DB::table('roles')->insert([
            ['name' => 'developer', 'guard_name' => 'web'],
            ['name' => 'admin', 'guard_name' => 'web'],
            ['name' => 'owner', 'guard_name' => 'api'],
            ['name' => 'renter', 'guard_name' => 'api'],
        ]);

        DB::table('users')->insert([
           [
            'name' => 'developer',
            'email' => 'developer@developer.com',
            'password' => Hash::make('12345678'),
            'otp_verified_at' => now(),
            'country_id' => null,
            'referral_code' => Str::random(6),
            'stripe_account_id' => null
           ],
           [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'otp_verified_at' => now(),
            'country_id' => null,
            'referral_code' => 'gk5hE7',
            'stripe_account_id' => null
           ],
           [
            'name' => 'Owner',
            'email' => 'owner@owner.com',
            'password' => Hash::make('12345678'),
            'otp_verified_at' => now(),
            'country_id' => null,
            'referral_code' => Str::random(6),
            'stripe_account_id' => 'acct_1RHGjbQPESrwz7hv'
           ],
           [
            'name' => 'Renter',
            'email' => 'renter@renter.com',
            'password' => Hash::make('12345678'),
            'otp_verified_at' => now(),
            'country_id' => null,
            'referral_code' => Str::random(6),
            'stripe_account_id' => null
           ]
        ]);

        DB::table('role_has_permissions')->insert([
            ['permission_id' => 1, 'role_id' => 1],
            ['permission_id' => 2, 'role_id' => 1],
            ['permission_id' => 3, 'role_id' => 1],
            ['permission_id' => 4, 'role_id' => 1],
            ['permission_id' => 1, 'role_id' => 2],
            ['permission_id' => 2, 'role_id' => 2],
            ['permission_id' => 3, 'role_id' => 2],
            ['permission_id' => 4, 'role_id' => 2],
            ['permission_id' => 5, 'role_id' => 3],
            ['permission_id' => 6, 'role_id' => 3],
            ['permission_id' => 7, 'role_id' => 3],
            ['permission_id' => 8, 'role_id' => 3],
            ['permission_id' => 5, 'role_id' => 4],
            ['permission_id' => 6, 'role_id' => 4],
            ['permission_id' => 7, 'role_id' => 4],
            ['permission_id' => 8, 'role_id' => 4],
        ]);

        DB::table('model_has_roles')->insert([
            ['role_id' => 1, 'model_id' => 1, 'model_type' => 'App\Models\User'],
            ['role_id' => 2, 'model_id' => 2, 'model_type' => 'App\Models\User'],
            ['role_id' => 3, 'model_id' => 3, 'model_type' => 'App\Models\User'],
            ['role_id' => 4, 'model_id' => 4, 'model_type' => 'App\Models\User']
        ]);

        DB::table('model_has_permissions')->insert([
            ['permission_id' => 1, 'model_id' => 1, 'model_type' => 'App\Models\User'],
            ['permission_id' => 2, 'model_id' => 1, 'model_type' => 'App\Models\User'],
            ['permission_id' => 3, 'model_id' => 1, 'model_type' => 'App\Models\User'],
            ['permission_id' => 4, 'model_id' => 1, 'model_type' => 'App\Models\User'],
            ['permission_id' => 1, 'model_id' => 2, 'model_type' => 'App\Models\User'],
            ['permission_id' => 2, 'model_id' => 2, 'model_type' => 'App\Models\User'],
            ['permission_id' => 3, 'model_id' => 2, 'model_type' => 'App\Models\User'],
            ['permission_id' => 4, 'model_id' => 2, 'model_type' => 'App\Models\User'],
            ['permission_id' => 5, 'model_id' => 3, 'model_type' => 'App\Models\User'],
            ['permission_id' => 6, 'model_id' => 3, 'model_type' => 'App\Models\User'],
            ['permission_id' => 7, 'model_id' => 3, 'model_type' => 'App\Models\User'],
            ['permission_id' => 8, 'model_id' => 3, 'model_type' => 'App\Models\User'],
            ['permission_id' => 5, 'model_id' => 4, 'model_type' => 'App\Models\User'],
            ['permission_id' => 6, 'model_id' => 4, 'model_type' => 'App\Models\User'],
            ['permission_id' => 7, 'model_id' => 4, 'model_type' => 'App\Models\User'],
            ['permission_id' => 8, 'model_id' => 4, 'model_type' => 'App\Models\User'],
        ]);

    }
}