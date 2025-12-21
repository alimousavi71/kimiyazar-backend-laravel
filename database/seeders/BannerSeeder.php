<?php

namespace Database\Seeders;

use App\Enums\Database\BannerPosition;
use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'name' => 'بنر تبلیغاتی اصلی',
                'banner_file' => null,
                'link' => '/products',
                'position' => BannerPosition::A1->value,
                'target_type' => null,
                'target_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'بنر پیشنهاد ویژه',
                'banner_file' => null,
                'link' => '/offers',
                'position' => BannerPosition::A2->value,
                'target_type' => null,
                'target_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'بنر محصولات جدید',
                'banner_file' => null,
                'link' => '/new-products',
                'position' => BannerPosition::B1->value,
                'target_type' => null,
                'target_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'بنر تخفیف‌های آخر هفته',
                'banner_file' => null,
                'link' => '/weekend-sale',
                'position' => BannerPosition::B2->value,
                'target_type' => null,
                'target_id' => null,
                'is_active' => false,
            ],
            [
                'name' => 'بنر همکاری با ما',
                'banner_file' => null,
                'link' => '/partnership',
                'position' => BannerPosition::C1->value,
                'target_type' => null,
                'target_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'بنر خبرنامه',
                'banner_file' => null,
                'link' => '/newsletter',
                'position' => BannerPosition::C2->value,
                'target_type' => null,
                'target_id' => null,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
