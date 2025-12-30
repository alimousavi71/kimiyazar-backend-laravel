<?php

namespace Database\Seeders;

use App\Enums\Database\ContentType;
use App\Models\Content;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Helper function to generate slug
        $generateSlug = function ($title) {
            return Str::slug($title);
        };

        // Only create pages that are used in menus (صادرات، واردات، ترخیص کالا، قوانین)
        $pages = [
            [
                'type' => ContentType::PAGE->value,
                'title' => 'صادرات',
                'slug' => $generateSlug('صادرات'),
                'body' => 'خدمات صادرات محصولات کشاورزی و دامی با بالاترین کیفیت و استانداردهای بین‌المللی.',
                'seo_description' => 'خدمات صادرات محصولات کشاورزی و دامی',
                'seo_keywords' => 'صادرات، محصولات کشاورزی، دامی',
                'is_active' => true,
                'visit_count' => 0,
                'is_undeletable' => false,
            ],
            [
                'type' => ContentType::PAGE->value,
                'title' => 'واردات',
                'slug' => $generateSlug('واردات'),
                'body' => 'خدمات واردات غلات، نهاده‌های دامی و محصولات کشاورزی با بهترین قیمت و کیفیت.',
                'seo_description' => 'خدمات واردات غلات و نهاده‌های دامی',
                'seo_keywords' => 'واردات، غلات، نهاده دامی',
                'is_active' => true,
                'visit_count' => 0,
                'is_undeletable' => false,
            ],
            [
                'type' => ContentType::PAGE->value,
                'title' => 'ترخیص کالا',
                'slug' => $generateSlug('ترخیص کالا'),
                'body' => 'خدمات ترخیص گمرکی کالا در کمترین زمان ممکن و با بهترین قیمت.',
                'seo_description' => 'خدمات ترخیص گمرکی کالا',
                'seo_keywords' => 'ترخیص کالا، گمرک، ترخیص',
                'is_active' => true,
                'visit_count' => 0,
                'is_undeletable' => false,
            ],
            [
                'type' => ContentType::PAGE->value,
                'title' => 'قوانین',
                'slug' => $generateSlug('قوانین'),
                'body' => 'قوانین و مقررات استفاده از وب‌سایت و خدمات ما.',
                'seo_description' => 'قوانین و مقررات استفاده از خدمات',
                'seo_keywords' => 'قوانین، مقررات، شرایط',
                'is_active' => true,
                'visit_count' => 0,
                'is_undeletable' => false,
            ],
        ];

        // Create only menu-related pages
        foreach ($pages as $item) {
            Content::firstOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}

