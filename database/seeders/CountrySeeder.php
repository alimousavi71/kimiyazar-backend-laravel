<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only Iran with Persian name
        Country::firstOrCreate(
            ['code' => 'IR'],
            ['name' => 'ایران']
        );
    }
}
