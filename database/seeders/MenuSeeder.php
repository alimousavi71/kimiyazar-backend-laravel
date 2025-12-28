<?php

namespace Database\Seeders;

use App\Enums\Database\ContentType;
use App\Models\Content;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createQuickAccessMenu();
        $this->createServicesMenu();
        $this->createUsefulLinksMenu();
    }

    /**
     * Create Quick Access Menu.
     */
    private function createQuickAccessMenu(): void
    {
        Menu::create([
            'name' => 'Quick Access',
            'type' => 'quick_access',
            'links' => [
                $this->createLink('link_1', 'خانه', '/', 1),
                $this->createLink('link_2', 'محصولات', '/products', 2),
                $this->createLink('link_3', 'سوالات متداول', '/faq', 3),
                $this->createLink('link_4', 'اخبار', '/news', 4),
                $this->createLink('link_5', 'مقالات', '/articles', 5),
            ],
        ]);
    }

    /**
     * Create Services Menu.
     */
    private function createServicesMenu(): void
    {
        // Get service pages in a single query
        $servicePages = Content::where('type', ContentType::PAGE->value)
            ->whereIn('title', ['صادرات', 'واردات', 'ترخیص کالا', 'قوانین'])
            ->get()
            ->keyBy('title');

        Menu::create([
            'name' => 'Our Services',
            'type' => 'services',
            'links' => [
                $this->createServiceLink('link_1', 'صادرات', $servicePages->get('صادرات'), 1),
                $this->createServiceLink('link_2', 'واردات', $servicePages->get('واردات'), 2),
                $this->createServiceLink('link_3', 'ترخیص کالا', $servicePages->get('ترخیص کالا'), 3),
                $this->createServiceLink('link_4', 'قوانین', $servicePages->get('قوانین'), 4),
                $this->createLink('link_5', 'درباره ما', '/about', 5),
            ],
        ]);
    }

    /**
     * Create a menu link.
     */
    private function createLink(string $id, string $title, string $url, int $order): array
    {
        return [
            'id' => $id,
            'title' => $title,
            'url' => $url,
            'type' => 'custom',
            'content_id' => null,
            'order' => $order,
        ];
    }

    /**
     * Create Useful Links Menu.
     */
    private function createUsefulLinksMenu(): void
    {
        $appUrl = config('app.url');

        Menu::create([
            'name' => 'Useful Links',
            'type' => 'useful_links',
            'links' => [
                $this->createExternalLink('link_1', 'لیست قیمت روزانه محصولات کیمیا تجارت زرK.T.Z', $appUrl, 1),
                $this->createExternalLink('link_2', 'سامانه پیامکی غلات', $appUrl . '/price-inquiry', 2),
                $this->createExternalLink('link_3', 'سامانه قیمت بذر محصولات کشاورزی', 'https://kimiyabazr.com/', 3),
                $this->createExternalLink('link_4', 'سامانه قیمت حبوبات', 'https://kimiyabeans.com/product-category/beans/', 4),
                $this->createExternalLink('link_5', 'سامانه قیمت نهاده و غلات', $appUrl . '/products', 5),
            ],
        ]);
    }

    /**
     * Create a service menu link with page reference.
     */
    private function createServiceLink(string $id, string $title, ?Content $page, int $order): array
    {
        $fallbackSlug = match ($title) {
            'صادرات' => 'صادرات',
            'واردات' => 'واردات',
            'ترخیص کالا' => 'ترخیص-کالا',
            'قوانین' => 'قوانین',
            default => $title,
        };

        return [
            'id' => $id,
            'title' => $title,
            'url' => $page ? '/page/' . $page->slug : '/page/' . $fallbackSlug,
            'type' => 'custom',
            'content_id' => $page?->id,
            'order' => $order,
        ];
    }

    /**
     * Create an external link (for useful links menu).
     */
    private function createExternalLink(string $id, string $title, string $url, int $order): array
    {
        return [
            'id' => $id,
            'title' => $title,
            'url' => $url,
            'type' => 'external',
            'content_id' => null,
            'order' => $order,
        ];
    }
}
