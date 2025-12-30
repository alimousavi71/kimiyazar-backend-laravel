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
            ['name' => 'بانک ملی ایران', 'logo' => null],
            ['name' => 'بانک پاسارگاد', 'logo' => null],
            ['name' => 'بانک سپه', 'logo' => null],
            ['name' => 'بانک ملت', 'logo' => null],
            ['name' => 'بانک تجارت', 'logo' => null],
            ['name' => 'بانک رفاه', 'logo' => null],
            ['name' => 'بانک صادرات', 'logo' => null],
            ['name' => 'بانک کشاورزی', 'logo' => null],
            ['name' => 'بانک صنعت و معدن', 'logo' => null],
            ['name' => 'بانک مسکن', 'logo' => null],
            ['name' => 'بانک کارآفرین', 'logo' => null],
            ['name' => 'بانک شهر', 'logo' => null],
            ['name' => 'بانک کوثر', 'logo' => null],
            ['name' => 'بانک سرمایه', 'logo' => null],
            ['name' => 'بانک پارسیان', 'logo' => null],
            ['name' => 'بانک سامان', 'logo' => null],
            ['name' => 'بانک اقتصاد نوین', 'logo' => null],
            ['name' => 'بانک پست بانک', 'logo' => null],
            ['name' => 'بانک قرض‌الحسنه مهر ایران', 'logo' => null],
            ['name' => 'بانک قرض‌الحسنه رسالت', 'logo' => null],
        ];

        foreach ($banks as $bank) {
            Bank::firstOrCreate(
                ['name' => $bank['name']],
                ['name' => $bank['name'], 'logo' => $bank['logo']]
            );
        }
    }
}
