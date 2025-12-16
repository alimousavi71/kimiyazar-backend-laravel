<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default user
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'user@example.com',
            'phone_number' => '09123456789',
            'country_code' => '+98',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
            'last_login' => now(),
        ]);

        // Create additional users
        User::factory()->count(15)->create();

        // Create inactive users
        User::factory()->count(3)->inactive()->create();

        // Create users with phone numbers
        User::factory()->count(5)->withPhone()->create();
    }
}
