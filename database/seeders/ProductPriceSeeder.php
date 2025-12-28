<?php

namespace Database\Seeders;

use App\Enums\Database\CurrencyCode;
use App\Models\ProductPrice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductPriceSeeder extends Seeder
{
    /**
     * Limit seeding to only 100 records for testing
     */
    private bool $only100Records = true;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Increase memory limit for large JSON file processing
        ini_set('memory_limit', '2048M');

        $jsonContent = File::get(database_path('import/product_prices.json'));
        $pricesData = json_decode($jsonContent, true);
        unset($jsonContent); // Free memory

        if (empty($pricesData)) {
            return;
        }

        // Limit to 100 records if flag is set
        if ($this->only100Records) {
            $pricesData = array_slice($pricesData, 0, 100);
        }

        $totalCount = count($pricesData);
        $this->command->info("Importing {$totalCount} product prices...");

        ProductPrice::unguard();

        // Map currency: "تومان" = "IRR"
        $currencyMap = ['تومان' => CurrencyCode::IRR->value];

        $batchSize = 500;
        $batches = array_chunk($pricesData, $batchSize);
        unset($pricesData); // Free memory

        $processed = 0;

        foreach ($batches as $batch) {
            $insertData = [];

            foreach ($batch as $item) {
                $createdAt = isset($item['price_date']) && $item['price_date']
                    ? date('Y-m-d H:i:s', (int) $item['price_date'])
                    : now();

                $currencyCode = isset($item['money_sign']) && isset($currencyMap[$item['money_sign']])
                    ? $currencyMap[$item['money_sign']]
                    : CurrencyCode::IRR->value;

                $insertData[] = [
                    'id' => (int) $item['id'],
                    'product_id' => (int) $item['product_id'],
                    'price' => $item['price'],
                    'currency_code' => $currencyCode,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }

            DB::table('product_prices')->insert($insertData);
            $processed += count($insertData);
            unset($insertData); // Free memory

            if ($processed % 5000 === 0) {
                $this->command->info("Processed {$processed}/{$totalCount} prices...");
            }
        }

        ProductPrice::reguard();

        $this->command->info("Successfully imported {$processed} product prices!");
    }
}
