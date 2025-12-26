<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Quick Access Menu
        Menu::create([
            'name' => 'Quick Access',
            'type' => 'quick_access',
            'links' => [
                [
                    'id' => 'link_1',
                    'title' => 'خانه',
                    'url' => '/',
                    'type' => 'custom',
                    'content_id' => null,
                    'order' => 1,
                ],
                [
                    'id' => 'link_2',
                    'title' => 'محصولات',
                    'url' => '/products',
                    'type' => 'custom',
                    'content_id' => null,
                    'order' => 2,
                ],
                [
                    'id' => 'link_3',
                    'title' => 'سوالات متداول',
                    'url' => '/faq',
                    'type' => 'custom',
                    'content_id' => null,
                    'order' => 3,
                ],
                [
                    'id' => 'link_4',
                    'title' => 'اخبار',
                    'url' => '/news',
                    'type' => 'custom',
                    'content_id' => null,
                    'order' => 4,
                ],
                [
                    'id' => 'link_5',
                    'title' => 'مقالات',
                    'url' => '/articles',
                    'type' => 'custom',
                    'content_id' => null,
                    'order' => 5,
                ],
            ],
        ]);

        // Services Menu
        Menu::create([
            'name' => 'Our Services',
            'type' => 'services',
            'links' => [
                [
                    'id' => 'link_1',
                    'title' => 'صادرات',
                    'url' => '#',
                    'type' => 'custom',
                    'content_id' => null,
                    'order' => 1,
                ],
                [
                    'id' => 'link_2',
                    'title' => 'واردات',
                    'url' => '#',
                    'type' => 'custom',
                    'content_id' => null,
                    'order' => 2,
                ],
                [
                    'id' => 'link_3',
                    'title' => 'ترخیص کالا',
                    'url' => '#',
                    'type' => 'custom',
                    'content_id' => null,
                    'order' => 3,
                ],
                [
                    'id' => 'link_4',
                    'title' => 'قوانین',
                    'url' => '#',
                    'type' => 'custom',
                    'content_id' => null,
                    'order' => 4,
                ],
                [
                    'id' => 'link_5',
                    'title' => 'درباره ما',
                    'url' => '/about',
                    'type' => 'custom',
                    'content_id' => null,
                    'order' => 5,
                ],
            ],
        ]);
    }
}
