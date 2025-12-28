<?php

namespace Database\Seeders;

use App\Enums\Database\SettingKey;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => SettingKey::TEL->value,
                'value' => '02191311234',
            ],
            [
                'key' => SettingKey::MOBILE->value,
                'value' => null,
            ],
            [
                'key' => SettingKey::ADDRESS->value,
                'value' => null,
            ],
            [
                'key' => SettingKey::TELEGRAM->value,
                'value' => 'https://t.me/KimiyaTrading',
            ],
            [
                'key' => SettingKey::INSTAGRAM->value,
                'value' => 'https://www.instagram.com/KimiyaTrading',
            ],
            [
                'key' => SettingKey::EMAIL->value,
                'value' => 'info@kimiyazar.com',
            ],
            [
                'key' => SettingKey::TITLE->value,
                'value' => 'کیمیا تجارت زر K.T.Z،واردات،صادرات،ترخیص کالا،جو،ذرت،سویا،کلزا',
            ],
            [
                'key' => SettingKey::DESCRIPTION->value,
                'value' => 'گروه کیمیا تجارت زرK.T.Z',
            ],
            [
                'key' => SettingKey::KEYWORDS->value,
                'value' => 'کیمیا تجارت زر K.T.Zواردات جو واردات ذرت واردات سویا واردات غلات واردات نهاده فروش جو فروش ذرت فروش سویا فروش ذرت برزیل قیمت ذرت قیمت جو قیمت سویا قیمت کلزا قیمت گندم شکسته قیمت ذرت شکسته',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }

        $this->command->info('Successfully updated settings!');
    }
}
