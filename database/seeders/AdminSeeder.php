<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'first_name' => 'مدیر',
                'last_name' => 'سیستم',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now()->subMonths(6),
                'is_block' => false,
                'last_login' => Carbon::now()->subMinutes(30),
                'avatar' => null,
            ],
            [
                'first_name' => 'علی',
                'last_name' => 'احمدی',
                'email' => 'ali.ahmadi@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now()->subMonths(3),
                'is_block' => false,
                'last_login' => Carbon::now()->subHours(2),
                'avatar' => null,
            ],
            [
                'first_name' => 'سارا',
                'last_name' => 'محمدی',
                'email' => 'sara.mohammadi@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now()->subMonths(2),
                'is_block' => false,
                'last_login' => Carbon::now()->subDays(1),
                'avatar' => null,
            ],
            [
                'first_name' => 'محمد',
                'last_name' => 'رضایی',
                'email' => 'mohammad.rezaei@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now()->subMonths(4),
                'is_block' => false,
                'last_login' => Carbon::now()->subHours(5),
                'avatar' => null,
            ],
            [
                'first_name' => 'فاطمه',
                'last_name' => 'کریمی',
                'email' => 'fateme.karimi@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now()->subMonths(1),
                'is_block' => false,
                'last_login' => Carbon::now()->subDays(2),
                'avatar' => null,
            ],
            [
                'first_name' => 'حسین',
                'last_name' => 'نوری',
                'email' => 'hossein.nouri@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now()->subMonths(5),
                'is_block' => true,
                'last_login' => Carbon::now()->subDays(60),
                'avatar' => null,
            ],
            [
                'first_name' => 'زهرا',
                'last_name' => 'صادقی',
                'email' => 'zahra.sadeghi@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now()->subMonths(2),
                'is_block' => false,
                'last_login' => Carbon::now()->subHours(12),
                'avatar' => null,
            ],
            [
                'first_name' => 'رضا',
                'last_name' => 'حسینی',
                'email' => 'reza.hosseini@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now()->subMonths(3),
                'is_block' => false,
                'last_login' => Carbon::now()->subMinutes(15),
                'avatar' => null,
            ],
            [
                'first_name' => 'مریم',
                'last_name' => 'جعفری',
                'email' => 'maryam.jafari@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now()->subMonths(1),
                'is_block' => false,
                'last_login' => Carbon::now()->subDays(5),
                'avatar' => null,
            ],
            [
                'first_name' => 'امیر',
                'last_name' => 'موسوی',
                'email' => 'amir.mousavi@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now()->subMonths(4),
                'is_block' => true,
                'last_login' => Carbon::now()->subDays(90),
                'avatar' => null,
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}

