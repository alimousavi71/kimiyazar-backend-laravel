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

        // News content
        $news = [
            [
                'type' => ContentType::NEWS->value,
                'title' => 'رونمایی از محصولات جدید در نمایشگاه',
                'slug' => $generateSlug('رونمایی از محصولات جدید در نمایشگاه'),
                'body' => 'در نمایشگاه امسال، ما از مجموعه جدید محصولات خود رونمایی کردیم. این محصولات با آخرین تکنولوژی‌ها و استانداردهای کیفیت تولید شده‌اند.',
                'seo_description' => 'رونمایی از محصولات جدید با تکنولوژی پیشرفته',
                'seo_keywords' => 'محصولات جدید، نمایشگاه، تکنولوژی',
                'is_active' => true,
                'visit_count' => 1250,
                'is_undeletable' => false,
            ],
            [
                'type' => ContentType::NEWS->value,
                'title' => 'افتتاح شعبه جدید در شهرستان',
                'slug' => $generateSlug('افتتاح شعبه جدید در شهرستان'),
                'body' => 'با افتخار اعلام می‌کنیم که شعبه جدید ما در شهرستان افتتاح شد. این شعبه با امکانات کامل و تیم مجرب آماده خدمت‌رسانی به مشتریان عزیز است.',
                'seo_description' => 'افتتاح شعبه جدید با امکانات کامل',
                'seo_keywords' => 'شعبه جدید، افتتاح، شهرستان',
                'is_active' => true,
                'visit_count' => 890,
                'is_undeletable' => false,
            ],
            [
                'type' => ContentType::NEWS->value,
                'title' => 'برگزاری دوره آموزشی برای نمایندگان',
                'slug' => $generateSlug('برگزاری دوره آموزشی برای نمایندگان'),
                'body' => 'دوره آموزشی تخصصی برای نمایندگان فروش برگزار شد. در این دوره، آخرین اطلاعات محصولات و روش‌های فروش به شرکت‌کنندگان آموزش داده شد.',
                'seo_description' => 'دوره آموزشی تخصصی برای نمایندگان فروش',
                'seo_keywords' => 'دوره آموزشی، نمایندگان، فروش',
                'is_active' => true,
                'visit_count' => 650,
                'is_undeletable' => false,
            ],
        ];

        // Article content
        $articles = [
            [
                'type' => ContentType::ARTICLE->value,
                'title' => 'راهنمای انتخاب محصول مناسب',
                'slug' => $generateSlug('راهنمای انتخاب محصول مناسب'),
                'body' => 'انتخاب محصول مناسب یکی از مهم‌ترین تصمیم‌هاست. در این مقاله، نکات مهم برای انتخاب محصول با کیفیت و مناسب نیاز شما را بررسی می‌کنیم.',
                'seo_description' => 'راهنمای جامع برای انتخاب محصول مناسب',
                'seo_keywords' => 'انتخاب محصول، راهنمای خرید، کیفیت',
                'is_active' => true,
                'visit_count' => 2100,
                'is_undeletable' => false,
            ],
            [
                'type' => ContentType::ARTICLE->value,
                'title' => 'نکات نگهداری و مراقبت از محصولات',
                'slug' => $generateSlug('نکات نگهداری و مراقبت از محصولات'),
                'body' => 'نگهداری صحیح از محصولات باعث افزایش طول عمر و حفظ کیفیت آن‌ها می‌شود. در این مقاله، روش‌های صحیح نگهداری را بررسی می‌کنیم.',
                'seo_description' => 'راهنمای نگهداری و مراقبت از محصولات',
                'seo_keywords' => 'نگهداری، مراقبت، طول عمر',
                'is_active' => true,
                'visit_count' => 1750,
                'is_undeletable' => false,
            ],
            [
                'type' => ContentType::ARTICLE->value,
                'title' => 'تاریخچه و پیشینه شرکت',
                'slug' => $generateSlug('تاریخچه و پیشینه شرکت'),
                'body' => 'شرکت ما با بیش از 10 سال سابقه در زمینه تولید و توزیع محصولات با کیفیت، همواره تلاش کرده است تا رضایت مشتریان را جلب کند.',
                'seo_description' => 'تاریخچه و پیشینه شرکت با سابقه 10 ساله',
                'seo_keywords' => 'تاریخچه، پیشینه، شرکت',
                'is_active' => true,
                'visit_count' => 980,
                'is_undeletable' => false,
            ],
        ];

        // Page content (including undeletable pages)
        $pages = [
            [
                'type' => ContentType::PAGE->value,
                'title' => 'درباره ما',
                'slug' => $generateSlug('درباره ما'),
                'body' => 'شرکت ما با هدف ارائه بهترین خدمات و محصولات به مشتریان تاسیس شده است. ما متعهد به کیفیت و رضایت مشتری هستیم.',
                'seo_description' => 'درباره شرکت و خدمات ما',
                'seo_keywords' => 'درباره ما، شرکت، خدمات',
                'is_active' => true,
                'visit_count' => 3500,
                'is_undeletable' => true,
            ],
            [
                'type' => ContentType::PAGE->value,
                'title' => 'تماس با ما',
                'slug' => $generateSlug('تماس با ما'),
                'body' => 'برای ارتباط با ما می‌توانید از طریق شماره تماس، ایمیل یا فرم تماس در وب‌سایت اقدام کنید. تیم پشتیبانی ما آماده پاسخگویی است.',
                'seo_description' => 'راه‌های تماس با ما',
                'seo_keywords' => 'تماس، ارتباط، پشتیبانی',
                'is_active' => true,
                'visit_count' => 2800,
                'is_undeletable' => true,
            ],
            [
                'type' => ContentType::PAGE->value,
                'title' => 'قوانین و مقررات',
                'slug' => $generateSlug('قوانین و مقررات'),
                'body' => 'قوانین و مقررات استفاده از وب‌سایت و خدمات ما در این صفحه درج شده است. لطفا قبل از استفاده، این قوانین را مطالعه کنید.',
                'seo_description' => 'قوانین و مقررات استفاده از خدمات',
                'seo_keywords' => 'قوانین، مقررات، شرایط',
                'is_active' => true,
                'visit_count' => 1200,
                'is_undeletable' => true,
            ],
            [
                'type' => ContentType::PAGE->value,
                'title' => 'حریم خصوصی',
                'slug' => $generateSlug('حریم خصوصی'),
                'body' => 'ما متعهد به حفظ حریم خصوصی کاربران هستیم. اطلاعات شما با امنیت کامل نگهداری می‌شود و در اختیار هیچ شخص ثالثی قرار نمی‌گیرد.',
                'seo_description' => 'سیاست حریم خصوصی و حفاظت از اطلاعات',
                'seo_keywords' => 'حریم خصوصی، امنیت، اطلاعات',
                'is_active' => true,
                'visit_count' => 950,
                'is_undeletable' => false,
            ],
        ];

        // Create all content
        foreach ($news as $item) {
            Content::create($item);
        }

        foreach ($articles as $item) {
            Content::create($item);
        }

        foreach ($pages as $item) {
            Content::create($item);
        }
    }
}

