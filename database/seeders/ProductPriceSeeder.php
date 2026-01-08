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
     * Record limit for import (null = no limit, number = limit to that many records).
     */
    private ?int $recordLimit = null;

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

        if (!$pricesData || !is_array($pricesData)) {
            $this->command->error('Failed to read or parse product_prices.json file');
            return;
        }

        // Apply record limit if set
        if ($this->recordLimit !== null) {
            $pricesData = array_slice($pricesData, 0, $this->recordLimit);
        }

        $totalRecords = count($pricesData);
        $this->command->info("Importing {$totalRecords} product prices...");

        $imported = 0;
        $skipped = 0;
        $errors = 0;

        ProductPrice::unguard();

        // Map currency: "تومان" = "IRR"
        $currencyMap = ['تومان' => CurrencyCode::IRR->value];

        $batchSize = 500;
        $batches = array_chunk($pricesData, $batchSize);
        unset($pricesData); // Free memory

        foreach ($batches as $batch) {
            $insertData = [];

            foreach ($batch as $item) {
                try {
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
                } catch (\Exception $e) {
                    $errors++;
                    $this->command->warn("Failed to prepare product price (id: {$item['id']}): " . $e->getMessage());
                    continue;
                }
            }

            try {
                if (!empty($insertData)) {
                    DB::table('product_prices')->insert($insertData);
                    $imported += count($insertData);
                }
            } catch (\Exception $e) {
                $errors += count($insertData);
                $this->command->warn("Failed to insert batch: " . $e->getMessage());
            }

            unset($insertData); // Free memory

            if ($imported % 5000 === 0) {
                $this->command->info("Processed {$imported}/{$totalRecords} prices...");
            }
        }

        ProductPrice::reguard();

        $this->command->info("Successfully imported {$imported} product prices!");
        if ($skipped > 0) {
            $this->command->info("Skipped {$skipped} product prices (already exist or missing data).");
        }
        if ($errors > 0) {
            $this->command->warn("Encountered {$errors} errors during import.");
        }
    }
}
