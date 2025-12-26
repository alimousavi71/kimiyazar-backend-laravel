<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            // Iranian Banks
            ['name' => 'Melli Bank', 'logo' => null],
            ['name' => 'Pasargad Bank', 'logo' => null],
            ['name' => 'Sepah Bank', 'logo' => null],
            ['name' => 'Mellat Bank', 'logo' => null],
            ['name' => 'Tejarat Bank', 'logo' => null],
            ['name' => 'Refah Bank', 'logo' => null],
            ['name' => 'Saderat Bank', 'logo' => null],
            ['name' => 'Keshavarzi Bank', 'logo' => null],
            ['name' => 'Bank of Industry and Mines', 'logo' => null],
            ['name' => 'Bank of Housing', 'logo' => null],
            ['name' => 'Bank Melli Iran', 'logo' => null],
            ['name' => 'Karaafarin Bank', 'logo' => null],
            ['name' => 'Shahr Bank', 'logo' => null],
            ['name' => 'Kowsar Bank', 'logo' => null],
            ['name' => 'Sarmayeh Bank', 'logo' => null],
            
            // International Banks
            ['name' => 'Deutsche Bank', 'logo' => null],
            ['name' => 'HSBC', 'logo' => null],
            ['name' => 'Bank of America', 'logo' => null],
            ['name' => 'Chase Bank', 'logo' => null],
            ['name' => 'Barclays Bank', 'logo' => null],
        ];

        foreach ($banks as $bank) {
            Bank::firstOrCreate(
                ['name' => $bank['name']],
                ['name' => $bank['name'], 'logo' => $bank['logo']]
            );
        }
    }
}
