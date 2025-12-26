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
        $countries = [
            ['name' => 'Iran', 'code' => 'IR'],
            ['name' => 'Germany', 'code' => 'DE'],
            ['name' => 'United States', 'code' => 'US'],
            ['name' => 'United Kingdom', 'code' => 'GB'],
            ['name' => 'France', 'code' => 'FR'],
            ['name' => 'Italy', 'code' => 'IT'],
            ['name' => 'Spain', 'code' => 'ES'],
            ['name' => 'Netherlands', 'code' => 'NL'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'Australia', 'code' => 'AU'],
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate(
                ['code' => $country['code']],
                ['name' => $country['name']]
            );
        }
    }
}
