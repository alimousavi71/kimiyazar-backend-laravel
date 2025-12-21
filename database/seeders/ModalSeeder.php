<?php

namespace Database\Seeders;

use App\Models\Modal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ModalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modal::create([
            'title' => 'خوش آمدید به فروشگاه ما',
            'content' => 'از خرید از فروشگاه ما خوشحالیم. برای اطلاع از آخرین تخفیف‌ها و پیشنهادهای ویژه، در خبرنامه ما عضو شوید.',
            'button_text' => 'عضویت در خبرنامه',
            'button_url' => '/newsletter',
            'close_text' => 'بستن',
            'is_rememberable' => true,
            'modalable_type' => null,
            'modalable_id' => null,
            'is_published' => true,
            'start_at' => Carbon::now()->subDays(1),
            'end_at' => Carbon::now()->addMonths(1),
            'priority' => 10,
        ]);
    }
}
