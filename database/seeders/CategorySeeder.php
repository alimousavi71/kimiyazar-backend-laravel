<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Helper function to generate slug from name
        $generateSlug = function (string $text): string {
            $text = trim($text);
            $text = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $text);
            $text = preg_replace('/[\s-]+/', '-', $text);
            $text = trim($text, '-');
            return mb_strtolower($text, 'UTF-8');
        };

        // Create 10 main categories with real data
        $categories = [
            [
                'name' => 'الکترونیک و دیجیتال',
                'children' => [
                    'موبایل و تبلت',
                    'لپ تاپ و کامپیوتر',
                    'گوشی موبایل',
                    'هدفون و هندزفری',
                ],
            ],
            [
                'name' => 'پوشاک و مد',
                'children' => [
                    'لباس مردانه',
                    'لباس زنانه',
                    'کفش',
                    'اکسسوری',
                ],
            ],
            [
                'name' => 'خانه و آشپزخانه',
                'children' => [
                    'مبلمان',
                    'لوازم آشپزخانه',
                    'دکوراسیون',
                    'فرش و موکت',
                ],
            ],
            [
                'name' => 'ورزش و سفر',
                'children' => [
                    'لباس ورزشی',
                    'کفش ورزشی',
                    'لوازم سفر',
                    'کوله پشتی',
                ],
            ],
            [
                'name' => 'زیبایی و سلامت',
                'children' => [
                    'لوازم آرایشی',
                    'عطر و ادکلن',
                    'محصولات مراقبت پوست',
                    'لوازم بهداشتی',
                ],
            ],
            [
                'name' => 'کتاب و لوازم تحریر',
                'children' => [
                    'کتاب',
                    'لوازم تحریر',
                    'کتاب کودک',
                    'مجلات',
                ],
            ],
            [
                'name' => 'اسباب بازی و سرگرمی',
                'children' => [
                    'اسباب بازی کودک',
                    'بازی فکری',
                    'پازل',
                    'عروسک',
                ],
            ],
            [
                'name' => 'خودرو و موتورسیکلت',
                'children' => [
                    'قطعات خودرو',
                    'لوازم یدکی',
                    'لوازم موتورسیکلت',
                    'لوازم جانبی',
                ],
            ],
            [
                'name' => 'غذا و نوشیدنی',
                'children' => [
                    'مواد غذایی',
                    'نوشیدنی',
                    'میوه و سبزیجات',
                    'خشکبار',
                ],
            ],
            [
                'name' => 'ابزار و تجهیزات',
                'children' => [
                    'ابزار دستی',
                    'ابزار برقی',
                    'تجهیزات ساختمانی',
                    'لوازم باغبانی',
                ],
            ],
        ];

        $sortOrder = 1;
        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => $generateSlug($categoryData['name']),
                'is_active' => true,
                'parent_id' => null,
                'sort_order' => $sortOrder++,
            ]);

            // Create children for this category
            $childSortOrder = 1;
            foreach ($categoryData['children'] as $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => $generateSlug($childName),
                    'is_active' => true,
                    'parent_id' => $category->id,
                    'sort_order' => $childSortOrder++,
                ]);
            }
        }
    }
}
