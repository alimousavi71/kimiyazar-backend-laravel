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
        Admin::firstOrCreate(
            ['email' => 'info@kimiyazar.com'],
            [
                'first_name' => 'مدیر',
                'last_name' => 'سیستم',
                'email' => 'info@kimiyazar.com',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
                'is_block' => false,
                'last_login' => null,
                'avatar' => null,
            ]
        );
    }
}

