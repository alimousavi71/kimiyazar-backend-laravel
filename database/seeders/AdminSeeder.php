<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin
        Admin::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_block' => false,
        ]);

        // Create additional admins using factory
        Admin::factory()->count(10)->create();

        // Create some blocked admins
        Admin::factory()->count(2)->blocked()->create();

        // Create some admins with last login
        Admin::factory()->count(5)->withLastLogin()->create();
    }
}

