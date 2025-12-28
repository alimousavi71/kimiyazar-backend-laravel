<?php

namespace Database\Seeders;

use App\Enums\Database\ContentType;
use App\Models\Content;
use Illuminate\Database\Seeder;

class ServicePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'type' => ContentType::PAGE->value,
                'title' => 'صادرات',
                'slug' => 'صادرات',
                'body' => 'خدمات صادرات ما شامل مشاوره، آماده‌سازی اسناد، ترخیص کالا و حمل و نقل می‌باشد. ما با سال‌ها تجربه در زمینه صادرات مواد شیمیایی و صنعتی، آماده ارائه بهترین خدمات به شما هستیم.',
                'seo_description' => 'خدمات صادرات مواد شیمیایی و صنعتی با بالاترین کیفیت',
                'seo_keywords' => 'صادرات، مواد شیمیایی، صنعتی، ترخیص کالا',
                'is_active' => true,
                'visit_count' => 0,
                'is_undeletable' => false,
            ],
            [
                'type' => ContentType::PAGE->value,
                'title' => 'واردات',
                'slug' => 'واردات',
                'body' => 'خدمات واردات ما شامل مشاوره، اخذ مجوزها، ترخیص کالا از گمرک و حمل و نقل داخلی می‌باشد. ما با شبکه گسترده ارتباطات بین‌المللی، آماده ارائه خدمات واردات به شما هستیم.',
                'seo_description' => 'خدمات واردات مواد شیمیایی و صنعتی با بهترین قیمت',
                'seo_keywords' => 'واردات، مواد شیمیایی، صنعتی، گمرک',
                'is_active' => true,
                'visit_count' => 0,
                'is_undeletable' => false,
            ],
            [
                'type' => ContentType::PAGE->value,
                'title' => 'ترخیص کالا',
                'slug' => 'ترخیص-کالا',
                'body' => 'خدمات ترخیص کالا ما شامل آماده‌سازی اسناد، اخذ مجوزها، پرداخت عوارض و ترخیص از گمرک می‌باشد. ما با تیم مجرب و تجربه بالا، آماده ارائه سریع‌ترین و بهترین خدمات ترخیص کالا به شما هستیم.',
                'seo_description' => 'خدمات ترخیص کالا از گمرک با بالاترین سرعت و دقت',
                'seo_keywords' => 'ترخیص کالا، گمرک، اسناد، مجوز',
                'is_active' => true,
                'visit_count' => 0,
                'is_undeletable' => false,
            ],
            [
                'type' => ContentType::PAGE->value,
                'title' => 'قوانین',
                'slug' => 'قوانین',
                'body' => 'در این بخش قوانین و مقررات مربوط به صادرات، واردات و ترخیص کالا را می‌توانید مشاهده کنید. ما همواره سعی می‌کنیم تا آخرین تغییرات قوانین را به شما اطلاع دهیم.',
                'seo_description' => 'قوانین و مقررات صادرات، واردات و ترخیص کالا',
                'seo_keywords' => 'قوانین، مقررات، صادرات، واردات، ترخیص کالا',
                'is_active' => true,
                'visit_count' => 0,
                'is_undeletable' => false,
            ],
        ];

        foreach ($pages as $pageData) {
            // Check if page already exists by slug
            $existingPage = Content::where('slug', $pageData['slug'])
                ->where('type', ContentType::PAGE->value)
                ->first();

            if (!$existingPage) {
                Content::create($pageData);
            }
        }
    }
}

