<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'title' => 'سوال درباره محصولات',
                'text' => 'سلام، می‌خواستم بدانم آیا محصولات شما دارای گواهینامه کیفیت هستند؟',
                'email' => 'ahmad.rezaei@example.com',
                'mobile' => '09123456789',
                'is_read' => true,
            ],
            [
                'title' => 'درخواست همکاری',
                'text' => 'با سلام، شرکت ما علاقه‌مند به همکاری با شما در زمینه توزیع محصولات است.',
                'email' => 'info@company.com',
                'mobile' => '09187654321',
                'is_read' => true,
            ],
            [
                'title' => 'مشکل در سفارش',
                'text' => 'سفارش من با شماره 12345 هنوز ارسال نشده است. لطفا پیگیری کنید.',
                'email' => 'sara.mohammadi@example.com',
                'mobile' => '09351234567',
                'is_read' => false,
            ],
            [
                'title' => 'سوال درباره قیمت',
                'text' => 'آیا امکان دریافت تخفیف برای خرید عمده وجود دارد؟',
                'email' => 'buyer@example.com',
                'mobile' => '09121112233',
                'is_read' => true,
            ],
            [
                'title' => 'نظرسنجی',
                'text' => 'از خدمات شما بسیار راضی هستم. ممنون از کیفیت عالی محصولات.',
                'email' => 'customer@example.com',
                'mobile' => '09234445566',
                'is_read' => true,
            ],
            [
                'title' => 'درخواست کاتالوگ',
                'text' => 'لطفا کاتالوگ کامل محصولات را برای من ارسال کنید.',
                'email' => 'request@example.com',
                'mobile' => '09135556677',
                'is_read' => false,
            ],
            [
                'title' => 'مشکل فنی',
                'text' => 'در هنگام ثبت سفارش آنلاین با خطا مواجه شدم. لطفا بررسی کنید.',
                'email' => 'tech.support@example.com',
                'mobile' => '09367778899',
                'is_read' => false,
            ],
            [
                'title' => 'پیشنهاد بهبود',
                'text' => 'پیشنهاد می‌کنم امکان پرداخت اقساطی را به سایت اضافه کنید.',
                'email' => 'suggestion@example.com',
                'mobile' => '09198889900',
                'is_read' => true,
            ],
            [
                'title' => 'سوال درباره گارانتی',
                'text' => 'مدت زمان گارانتی محصولات شما چقدر است؟',
                'email' => 'warranty@example.com',
                'mobile' => '09211112233',
                'is_read' => true,
            ],
            [
                'title' => 'درخواست بازدید',
                'text' => 'آیا امکان بازدید از کارخانه شما برای تیم ما وجود دارد؟',
                'email' => 'visit@company.com',
                'mobile' => '09124445566',
                'is_read' => false,
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
