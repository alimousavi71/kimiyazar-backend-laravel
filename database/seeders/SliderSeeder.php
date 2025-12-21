<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'بهترین محصولات با بهترین قیمت',
                'heading' => 'فروش ویژه',
                'description' => 'از مجموعه جدید محصولات ما دیدن کنید و از تخفیف‌های ویژه بهره‌مند شوید.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'ارسال رایگان برای خریدهای بالای 5 میلیون',
                'heading' => 'ارسال رایگان',
                'description' => 'برای خریدهای بالای 5 میلیون تومان، ارسال کاملا رایگان است.',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}

