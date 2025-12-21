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
                'value' => '021-12345678',
            ],
            [
                'key' => SettingKey::MOBILE->value,
                'value' => '09123456789',
            ],
            [
                'key' => SettingKey::ADDRESS->value,
                'value' => 'تهران، خیابان ولیعصر، پلاک 123',
            ],
            [
                'key' => SettingKey::TELEGRAM->value,
                'value' => 'https://t.me/company_channel',
            ],
            [
                'key' => SettingKey::INSTAGRAM->value,
                'value' => 'https://instagram.com/company_page',
            ],
            [
                'key' => SettingKey::EMAIL->value,
                'value' => 'info@company.com',
            ],
            [
                'key' => SettingKey::TITLE->value,
                'value' => 'فروشگاه آنلاین محصولات',
            ],
            [
                'key' => SettingKey::DESCRIPTION->value,
                'value' => 'فروشگاه آنلاین معتبر با بیش از 10 سال سابقه در زمینه فروش محصولات با کیفیت',
            ],
            [
                'key' => SettingKey::KEYWORDS->value,
                'value' => 'فروشگاه آنلاین، محصولات، خرید اینترنتی، کیفیت',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
