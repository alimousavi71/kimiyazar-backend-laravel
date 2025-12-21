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
        $users = [
            [
                'first_name' => 'علی',
                'last_name' => 'احمدی',
                'email' => 'ali.ahmadi@example.com',
                'phone_number' => '09123456789',
                'country_code' => '+98',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now()->subDays(10),
                'is_active' => true,
                'last_login' => Carbon::now()->subHours(2),
            ],
            [
                'first_name' => 'سارا',
                'last_name' => 'محمدی',
                'email' => 'sara.mohammadi@example.com',
                'phone_number' => '09187654321',
                'country_code' => '+98',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now()->subDays(5),
                'is_active' => true,
                'last_login' => Carbon::now()->subDays(1),
            ],
            [
                'first_name' => 'محمد',
                'last_name' => 'رضایی',
                'email' => 'mohammad.rezaei@example.com',
                'phone_number' => '09351234567',
                'country_code' => '+98',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now()->subDays(20),
                'is_active' => true,
                'last_login' => Carbon::now()->subHours(5),
            ],
            [
                'first_name' => 'فاطمه',
                'last_name' => 'کریمی',
                'email' => 'fateme.karimi@example.com',
                'phone_number' => '09234445566',
                'country_code' => '+98',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now()->subDays(3),
                'is_active' => true,
                'last_login' => Carbon::now()->subDays(2),
            ],
            [
                'first_name' => 'حسین',
                'last_name' => 'نوری',
                'email' => 'hossein.nouri@example.com',
                'phone_number' => '09121112233',
                'country_code' => '+98',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now()->subDays(15),
                'is_active' => true,
                'last_login' => Carbon::now()->subHours(12),
            ],
            [
                'first_name' => 'زهرا',
                'last_name' => 'صادقی',
                'email' => 'zahra.sadeghi@example.com',
                'phone_number' => '09367778899',
                'country_code' => '+98',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now()->subDays(7),
                'is_active' => false,
                'last_login' => Carbon::now()->subDays(30),
            ],
            [
                'first_name' => 'رضا',
                'last_name' => 'حسینی',
                'email' => 'reza.hosseini@example.com',
                'phone_number' => '09198889900',
                'country_code' => '+98',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now()->subDays(12),
                'is_active' => true,
                'last_login' => Carbon::now()->subHours(1),
            ],
            [
                'first_name' => 'مریم',
                'last_name' => 'جعفری',
                'email' => 'maryam.jafari@example.com',
                'phone_number' => '09211112233',
                'country_code' => '+98',
                'password' => Hash::make('password'),
                'email_verified_at' => null,
                'is_active' => true,
                'last_login' => null,
            ],
            [
                'first_name' => 'امیر',
                'last_name' => 'موسوی',
                'email' => 'amir.mousavi@example.com',
                'phone_number' => '09124445566',
                'country_code' => '+98',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now()->subDays(8),
                'is_active' => true,
                'last_login' => Carbon::now()->subDays(3),
            ],
            [
                'first_name' => 'نرگس',
                'last_name' => 'اکبری',
                'email' => 'narges.akbari@example.com',
                'phone_number' => '09351112233',
                'country_code' => '+98',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now()->subDays(25),
                'is_active' => false,
                'last_login' => Carbon::now()->subDays(45),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
