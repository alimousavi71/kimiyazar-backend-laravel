<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ProductPriceSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            BankSeeder::class,
            OrderSeeder::class,
            ContactSeeder::class,
            ContentSeeder::class,
            TagSeeder::class,
            TagableSeeder::class,
            SliderSeeder::class,
            FaqSeeder::class,
            BannerSeeder::class,
            ModalSeeder::class,
            SettingSeeder::class,
            ServicePageSeeder::class,
            MenuSeeder::class,
            PriceInquirySeeder::class,
        ]);
    }
}
