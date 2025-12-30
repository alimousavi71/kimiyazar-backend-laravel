<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'mosaviali701@gmail.com'],
            [
                'first_name' => 'علی',
                'last_name' => 'موسوی',
                'email' => 'mosaviali701@gmail.com',
                'phone_number' => null,
                'country_code' => '+98',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
                'is_active' => true,
                'last_login' => null,
            ]
        );
    }
}
