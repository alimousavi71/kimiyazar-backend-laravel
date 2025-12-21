<?php

namespace Database\Seeders;

use App\Enums\Database\ProductStatus;
use App\Enums\Database\ProductUnit;
use App\Enums\Database\CurrencyCode;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Generate a simple slug from Persian text
     */
    private function generateSlug(string $text): string
    {
        // Normalize Persian characters
        $text = str_replace(['ي', 'ك'], ['ی', 'ک'], $text);

        // Convert to lowercase and replace spaces with hyphens
        $text = mb_strtolower(trim($text), 'UTF-8');
        $text = preg_replace('/[\s_]+/u', '-', $text);

        // Keep only Persian letters, English letters, digits, and hyphens
        $text = preg_replace('/[^0-9a-zA-Zآ-یءئإأؤۀکگپچژ-]+/u', '', $text);

        // Collapse multiple hyphens
        $text = preg_replace('/-+/', '-', $text);
        $text = trim($text, '-');

        return $text ?: Str::random(8);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get available categories
        $categories = Category::all();

        // Realistic product data
        $products = [
            [
                'name' => 'لپ تاپ اپل مک‌بوک پرو 16 اینچ',
                'sale_description' => 'لپ تاپ حرفه‌ای با پردازنده M2 Pro، حافظه 16 گیگابایت و صفحه نمایش Retina',
                'unit' => ProductUnit::PIECE,
                'body' => 'لپ تاپ اپل مک‌بوک پرو 16 اینچ با پردازنده قدرتمند M2 Pro و حافظه 16 گیگابایت، مناسب برای کارهای حرفه‌ای و طراحی است. صفحه نمایش Retina با وضوح بالا و باتری با عمر طولانی از ویژگی‌های برجسته این محصول است.',
                'price_label' => 'قیمت ویژه',
                'current_price' => 85000000,
                'currency_code' => CurrencyCode::IRR,
                'status' => ProductStatus::ACTIVE,
                'is_published' => true,
                'sort_order' => 1,
                'meta_title' => 'لپ تاپ اپل مک‌بوک پرو 16 اینچ - خرید با بهترین قیمت',
                'meta_description' => 'خرید لپ تاپ اپل مک‌بوک پرو 16 اینچ با پردازنده M2 Pro، حافظه 16 گیگابایت و صفحه نمایش Retina',
                'meta_keywords' => 'لپ تاپ, اپل, مک‌بوک, M2 Pro, لپ تاپ حرفه‌ای',
            ],
            [
                'name' => 'گوشی موبایل سامسونگ گلکسی S24 اولترا',
                'sale_description' => 'گوشی هوشمند پرچمدار با دوربین 200 مگاپیکسلی و پردازنده اسنپدراگون 8 Gen 3',
                'unit' => ProductUnit::PIECE,
                'body' => 'گوشی موبایل سامسونگ گلکسی S24 اولترا با دوربین 200 مگاپیکسلی، پردازنده قدرتمند اسنپدراگون 8 Gen 3 و صفحه نمایش Dynamic AMOLED 2X با نرخ نوسازی 120 هرتز. این گوشی با باتری 5000 میلی‌آمپر ساعت و شارژ سریع 45 وات عرضه می‌شود.',
                'price_label' => 'پیشنهاد ویژه',
                'current_price' => 45000000,
                'currency_code' => CurrencyCode::IRR,
                'status' => ProductStatus::ACTIVE,
                'is_published' => true,
                'sort_order' => 2,
                'meta_title' => 'گوشی سامسونگ گلکسی S24 اولترا - خرید با گارانتی',
                'meta_description' => 'خرید گوشی موبایل سامسونگ گلکسی S24 اولترا با دوربین 200 مگاپیکسلی و پردازنده اسنپدراگون 8 Gen 3',
                'meta_keywords' => 'گوشی موبایل, سامسونگ, گلکسی S24, اسنپدراگون',
            ],
            [
                'name' => 'تلویزیون ال‌جی 65 اینچ 4K UHD',
                'sale_description' => 'تلویزیون هوشمند با صفحه نمایش OLED و پشتیبانی از HDR10 و Dolby Vision',
                'unit' => ProductUnit::PIECE,
                'body' => 'تلویزیون ال‌جی 65 اینچ با صفحه نمایش OLED و وضوح 4K UHD. این تلویزیون از تکنولوژی HDR10 و Dolby Vision پشتیبانی می‌کند و دارای سیستم صوتی Dolby Atmos است. سیستم عامل webOS امکان دسترسی به اپلیکیشن‌های مختلف را فراهم می‌کند.',
                'price_label' => 'تخفیف ویژه',
                'current_price' => 120000000,
                'currency_code' => CurrencyCode::IRR,
                'status' => ProductStatus::ACTIVE,
                'is_published' => true,
                'sort_order' => 3,
                'meta_title' => 'تلویزیون ال‌جی 65 اینچ 4K UHD - خرید آنلاین',
                'meta_description' => 'خرید تلویزیون ال‌جی 65 اینچ با صفحه نمایش OLED و پشتیبانی از HDR10 و Dolby Vision',
                'meta_keywords' => 'تلویزیون, ال‌جی, OLED, 4K, HDR',
            ],
            [
                'name' => 'یخچال ساید بای ساید سامسونگ 28 فوت',
                'sale_description' => 'یخچال بزرگ با قابلیت ساید بای ساید، سیستم خنک‌کننده Twin Cooling Plus',
                'unit' => ProductUnit::PIECE,
                'body' => 'یخچال سامسونگ 28 فوت با قابلیت ساید بای ساید و سیستم خنک‌کننده Twin Cooling Plus. این یخچال دارای فیلتر آب داخلی، صفحه نمایش دیجیتال و قابلیت اتصال به اینترنت است. مصرف انرژی A+++ و گارانتی 10 ساله کمپرسور.',
                'price_label' => 'قیمت استثنایی',
                'current_price' => 95000000,
                'currency_code' => CurrencyCode::IRR,
                'status' => ProductStatus::ACTIVE,
                'is_published' => true,
                'sort_order' => 4,
                'meta_title' => 'یخچال سامسونگ 28 فوت ساید بای ساید - خرید',
                'meta_description' => 'خرید یخچال سامسونگ 28 فوت با سیستم خنک‌کننده Twin Cooling Plus و مصرف انرژی A+++',
                'meta_keywords' => 'یخچال, سامسونگ, ساید بای ساید, Twin Cooling',
            ],
            [
                'name' => 'ماشین لباسشویی ال‌جی 10 کیلوگرم',
                'sale_description' => 'ماشین لباسشویی با قابلیت شستشوی بخار و تکنولوژی TurboWash',
                'unit' => ProductUnit::PIECE,
                'body' => 'ماشین لباسشویی ال‌جی با ظرفیت 10 کیلوگرم و قابلیت شستشوی بخار. این ماشین لباسشویی از تکنولوژی TurboWash برای شستشوی سریع‌تر استفاده می‌کند و مصرف انرژی A+++ دارد. دارای 6 حرکت شستشو و قابلیت کنترل از طریق اپلیکیشن.',
                'price_label' => 'پیشنهاد ویژه',
                'current_price' => 35000000,
                'currency_code' => CurrencyCode::IRR,
                'status' => ProductStatus::ACTIVE,
                'is_published' => true,
                'sort_order' => 5,
                'meta_title' => 'ماشین لباسشویی ال‌جی 10 کیلوگرم - خرید',
                'meta_description' => 'خرید ماشین لباسشویی ال‌جی 10 کیلوگرم با قابلیت شستشوی بخار و تکنولوژی TurboWash',
                'meta_keywords' => 'ماشین لباسشویی, ال‌جی, TurboWash, شستشوی بخار',
            ],
            [
                'name' => 'قهوه ترک اصل 500 گرم',
                'sale_description' => 'قهوه ترک با کیفیت عالی، بسته‌بندی 500 گرمی',
                'unit' => ProductUnit::GRAM,
                'body' => 'قهوه ترک اصل با کیفیت عالی و طعم منحصر به فرد. این قهوه از دانه‌های انتخاب شده تهیه شده و بسته‌بندی شده در بسته 500 گرمی. مناسب برای استفاده در قهوه‌جوش و فرنچ پرس.',
                'price_label' => 'محصول پرفروش',
                'current_price' => 450000,
                'currency_code' => CurrencyCode::IRR,
                'status' => ProductStatus::ACTIVE,
                'is_published' => true,
                'sort_order' => 6,
                'meta_title' => 'قهوه ترک اصل 500 گرم - خرید آنلاین',
                'meta_description' => 'خرید قهوه ترک اصل با کیفیت عالی در بسته‌بندی 500 گرمی',
                'meta_keywords' => 'قهوه, قهوه ترک, قهوه اصل, دانه قهوه',
            ],
            [
                'name' => 'روغن زیتون فرابکر 1 لیتر',
                'sale_description' => 'روغن زیتون فرابکر با کیفیت ممتاز، بسته‌بندی 1 لیتری',
                'unit' => ProductUnit::LITER,
                'body' => 'روغن زیتون فرابکر با کیفیت ممتاز و طعم طبیعی. این روغن از زیتون‌های تازه و با کیفیت تهیه شده و در بسته‌بندی 1 لیتری عرضه می‌شود. مناسب برای استفاده در سالاد و پخت و پز.',
                'price_label' => 'محصول محلی',
                'current_price' => 850000,
                'currency_code' => CurrencyCode::IRR,
                'status' => ProductStatus::ACTIVE,
                'is_published' => true,
                'sort_order' => 7,
                'meta_title' => 'روغن زیتون فرابکر 1 لیتر - خرید',
                'meta_description' => 'خرید روغن زیتون فرابکر با کیفیت ممتاز در بسته‌بندی 1 لیتری',
                'meta_keywords' => 'روغن زیتون, فرابکر, روغن طبیعی, زیتون',
            ],
            [
                'name' => 'کتاب برنامه‌نویسی PHP پیشرفته',
                'sale_description' => 'کتاب جامع آموزش PHP پیشرفته با مثال‌های کاربردی',
                'unit' => ProductUnit::PIECE,
                'body' => 'کتاب برنامه‌نویسی PHP پیشرفته با محتوای جامع و مثال‌های کاربردی. این کتاب شامل آموزش مفاهیم پیشرفته PHP، کار با دیتابیس، API و فریمورک Laravel است. مناسب برای برنامه‌نویسان با سطح متوسط و پیشرفته.',
                'price_label' => 'کتاب پرفروش',
                'current_price' => 1200000,
                'currency_code' => CurrencyCode::IRR,
                'status' => ProductStatus::ACTIVE,
                'is_published' => true,
                'sort_order' => 8,
                'meta_title' => 'کتاب برنامه‌نویسی PHP پیشرفته - خرید',
                'meta_description' => 'خرید کتاب جامع آموزش PHP پیشرفته با مثال‌های کاربردی',
                'meta_keywords' => 'کتاب, PHP, برنامه‌نویسی, Laravel, آموزش',
            ],
            [
                'name' => 'هدفون بی‌سیم سونی WH-1000XM5',
                'sale_description' => 'هدفون نویز کنسلینگ با کیفیت صدای عالی و باتری 30 ساعته',
                'unit' => ProductUnit::PIECE,
                'body' => 'هدفون بی‌سیم سونی WH-1000XM5 با تکنولوژی نویز کنسلینگ پیشرفته و کیفیت صدای Hi-Res Audio. این هدفون دارای باتری با عمر 30 ساعت و شارژ سریع است. قابلیت اتصال به چند دستگاه و کنترل لمسی از ویژگی‌های این محصول است.',
                'price_label' => 'محصول جدید',
                'current_price' => 18000000,
                'currency_code' => CurrencyCode::IRR,
                'status' => ProductStatus::ACTIVE,
                'is_published' => true,
                'sort_order' => 9,
                'meta_title' => 'هدفون سونی WH-1000XM5 - خرید آنلاین',
                'meta_description' => 'خرید هدفون بی‌سیم سونی WH-1000XM5 با نویز کنسلینگ و کیفیت صدای Hi-Res',
                'meta_keywords' => 'هدفون, سونی, نویز کنسلینگ, بی‌سیم, WH-1000XM5',
            ],
            [
                'name' => 'موس گیمینگ رزر DeathAdder V3',
                'sale_description' => 'موس گیمینگ حرفه‌ای با سنسور Focus Pro 30K و سرعت 750 IPS',
                'unit' => ProductUnit::PIECE,
                'body' => 'موس گیمینگ رزر DeathAdder V3 با سنسور Focus Pro 30K و سرعت 750 IPS. این موس دارای 5 دکمه قابل برنامه‌ریزی، عمر باتری 90 ساعت و وزن 59 گرم است. مناسب برای گیمرهای حرفه‌ای و رقابتی.',
                'price_label' => 'محصول گیمینگ',
                'current_price' => 4500000,
                'currency_code' => CurrencyCode::IRR,
                'status' => ProductStatus::ACTIVE,
                'is_published' => true,
                'sort_order' => 10,
                'meta_title' => 'موس گیمینگ رزر DeathAdder V3 - خرید',
                'meta_description' => 'خرید موس گیمینگ رزر DeathAdder V3 با سنسور Focus Pro 30K و سرعت 750 IPS',
                'meta_keywords' => 'موس, گیمینگ, رزر, DeathAdder, Focus Pro',
            ],
        ];

        // Create products
        foreach ($products as $productData) {
            // Assign random category if available
            $categoryId = $categories->isNotEmpty() ? $categories->random()->id : null;

            // Set price update date
            $priceUpdatedAt = Carbon::now()->subDays(rand(1, 30));
            $priceEffectiveDate = Carbon::now()->addDays(rand(1, 60));

            // Generate slug from name
            $slug = $this->generateSlug($productData['name']);

            // Create product using create() method - simple and clean
            Product::create([
                'name' => $productData['name'],
                'slug' => $slug,
                'sale_description' => $productData['sale_description'],
                'unit' => $productData['unit'],
                'category_id' => $categoryId,
                'body' => $productData['body'],
                'price_label' => $productData['price_label'],
                'meta_title' => $productData['meta_title'],
                'meta_description' => $productData['meta_description'],
                'meta_keywords' => $productData['meta_keywords'],
                'status' => $productData['status'],
                'is_published' => $productData['is_published'],
                'sort_order' => $productData['sort_order'],
                'current_price' => $productData['current_price'],
                'currency_code' => $productData['currency_code'],
                'price_updated_at' => $priceUpdatedAt,
                'price_effective_date' => $priceEffectiveDate,
            ]);
        }
    }
}
