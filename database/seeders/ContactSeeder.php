<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create read contacts
        Contact::factory()
            ->count(15)
            ->read()
            ->create();

        // Create unread contacts
        Contact::factory()
            ->count(25)
            ->unread()
            ->create();

        // Create some contacts with mixed states
        Contact::factory()
            ->count(10)
            ->create();
    }
}
