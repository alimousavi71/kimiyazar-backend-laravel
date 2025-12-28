<?php

namespace Database\Seeders;

use App\Enums\Database\ProductUnit;
use App\Models\Product;
use App\Services\SlugService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsData = json_decode(File::get(database_path('import/products.json')), true);

        if (empty($productsData)) {
            return;
        }

        $this->command->info("Importing " . count($productsData) . " products...");

        $usedSlugs = [];

        DB::transaction(function () use ($productsData, &$usedSlugs) {
            Product::unguard();

            foreach ($productsData as $item) {
                // Ensure slug is unique
                $baseSlug = $item['slug'];
                $slug = SlugService::makeUnique(
                    $baseSlug,
                    fn(string $s) => isset($usedSlugs[$s])
                );
                $usedSlugs[$slug] = true;
                // Convert Unix timestamp to datetime
                $createdAt = isset($item['created_at']) && $item['created_at']
                    ? date('Y-m-d H:i:s', (int) $item['created_at'])
                    : null;

                $priceUpdatedAt = isset($item['price_updated_at']) && $item['price_updated_at']
                    ? date('Y-m-d H:i:s', (int) $item['price_updated_at'])
                    : null;

                // Map unit from Persian to enum value
                $unitMap = [
                    'کیلوگرم' => ProductUnit::KILOGRAM->value,
                    'بسته' => ProductUnit::PACK->value,
                    'تن' => ProductUnit::TON->value,
                    'عدد' => ProductUnit::PIECE->value,
                    'قوطی فلزی و پاکت' => ProductUnit::CAN_AND_PACKET->value,
                    'قوطی' => ProductUnit::CAN->value,
                    'پاکت' => ProductUnit::PACKET->value,
                    'گالن' => ProductUnit::GALLON->value,
                ];
                $unit = isset($item['unit']) && isset($unitMap[$item['unit']])
                    ? $unitMap[$item['unit']]
                    : ($item['unit'] ?? null);

                // Map status: "1" = "active", "0" = "inactive"
                $statusMap = ['1' => 'active', '0' => 'inactive'];
                $status = isset($item['status']) && isset($statusMap[$item['status']])
                    ? $statusMap[$item['status']]
                    : 'inactive';

                // Map currency: "تومان" = "IRR"
                $currencyMap = ['تومان' => 'IRR', 'دلار' => 'USD', 'یورو' => 'EUR'];
                $currencyCode = isset($item['current_money_sign']) && isset($currencyMap[$item['current_money_sign']])
                    ? $currencyMap[$item['current_money_sign']]
                    : null;

                // Insert exactly as provided
                Product::create([
                    'id' => (int) $item['id'],
                    'name' => $item['title'],
                    'slug' => $slug,
                    'sale_description' => $item['text_sale'] ?? null,
                    'unit' => $unit,
                    'category_id' => (int) $item['category_id'] ?: null,
                    'is_published' => (int) $item['active'],
                    'body' => $item['text'] ?? null,
                    'price_label' => $item['note'] ?? null,
                    'meta_description' => $item['seo_desc'] ?? null,
                    'meta_keywords' => $item['seo_keywords'] ?? null,
                    'status' => $status,
                    'sort_order' => (int) $item['position'],
                    'current_price' => $item['current_price'] ?? null,
                    'currency_code' => $currencyCode,
                    'price_updated_at' => $priceUpdatedAt,
                    'price_effective_date' => $item['price_day_date'] ?? null,
                    'created_at' => $createdAt,
                ]);
            }

            Product::reguard();
        });

        $this->command->info("Successfully imported " . count($productsData) . " products!");
    }
}
