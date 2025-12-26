<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Iran provinces
        $iranProvinces = [
            'Alborz', 'Ardabil', 'East Azerbaijan', 'West Azerbaijan', 'Bushehr',
            'Chaharmahal and Bakhtiari', 'North Khorasan', 'Razavi Khorasan', 'South Khorasan',
            'Khuzestan', 'Zanjan', 'Semnan', 'Sistan and Baluchestan', 'Fars',
            'Qom', 'Qazvin', 'Kerman', 'Kermanshahan', 'Kohgiluyeh and Boyer-Ahmad',
            'Golestan', 'Gilan', 'Luristan', 'Mazandaran', 'Markazi',
            'Hormozgan', 'Hamadan', 'Herat', 'Isfahan', 'Ilam',
            'Yazd', 'Tehran'
        ];

        $iranCountry = Country::where('code', 'IR')->first();
        if ($iranCountry) {
            foreach ($iranProvinces as $province) {
                State::firstOrCreate(
                    ['name' => $province, 'country_id' => $iranCountry->id],
                    ['name' => $province, 'country_id' => $iranCountry->id]
                );
            }
        }

        // US states (major ones)
        $usStates = [
            'California', 'Texas', 'Florida', 'New York', 'Pennsylvania',
            'Illinois', 'Ohio', 'Georgia', 'North Carolina', 'Michigan',
        ];

        $usCountry = Country::where('code', 'US')->first();
        if ($usCountry) {
            foreach ($usStates as $state) {
                State::firstOrCreate(
                    ['name' => $state, 'country_id' => $usCountry->id],
                    ['name' => $state, 'country_id' => $usCountry->id]
                );
            }
        }

        // Germany states
        $germanStates = [
            'Baden-Württemberg', 'Bavaria', 'Berlin', 'Brandenburg', 'Bremen',
            'Hamburg', 'Hesse', 'Lower Saxony', 'Mecklenburg-Vorpommern', 'North Rhine-Westphalia',
            'Rhineland-Palatinate', 'Saarland', 'Saxony', 'Saxony-Anhalt', 'Schleswig-Holstein',
            'Thuringia',
        ];

        $deCountry = Country::where('code', 'DE')->first();
        if ($deCountry) {
            foreach ($germanStates as $state) {
                State::firstOrCreate(
                    ['name' => $state, 'country_id' => $deCountry->id],
                    ['name' => $state, 'country_id' => $deCountry->id]
                );
            }
        }
    }
}
