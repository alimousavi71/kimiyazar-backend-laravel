<?php

namespace App\Console\Commands;

use App\Enums\Database\CurrencyCode;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Services\ProductPrice\ProductPriceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestProductPriceTrigger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:product-price-trigger {--product-id= : Test with specific product ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test product price trigger functionality';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Check if using MySQL/MariaDB
        $driver = DB::connection()->getDriverName();
        if (!in_array($driver, ['mysql', 'mariadb'])) {
            $this->error('Triggers only work on MySQL/MariaDB. Current driver: ' . $driver);
            return Command::FAILURE;
        }

        // Check if triggers exist
        $triggers = DB::select("SHOW TRIGGERS LIKE 'product_price%'");
        if (empty($triggers)) {
            $this->error('Product price triggers not found in database!');
            $this->info('Run: php artisan migrate');
            return Command::FAILURE;
        }

        $this->info('Found ' . count($triggers) . ' trigger(s)');
        foreach ($triggers as $trigger) {
            $this->line("  - {$trigger->Trigger} ({$trigger->Event})");
        }

        $productId = $this->option('product-id');

        if ($productId) {
            // Test with specific product
            $product = Product::find($productId);
            if (!$product) {
                $this->error("Product with ID {$productId} not found!");
                return Command::FAILURE;
            }
            $this->testWithProduct($product);
        } else {
            // Test with new product
            $this->testWithNewProduct();
            $this->newLine();
            $this->testBulkUpdate();
        }

        return Command::SUCCESS;
    }

    /**
     * Test trigger with a new product.
     */
    private function testWithNewProduct(): void
    {
        $this->newLine();
        $this->info('=== Testing Trigger with New Product ===');

        // Create a test product
        $product = Product::create([
            'name' => 'Test Product for Trigger',
            'slug' => 'test-product-trigger-' . time(),
            'current_price' => '1000.00',
            'currency_code' => CurrencyCode::IRR,
            'status' => \App\Enums\Database\ProductStatus::ACTIVE,
            'unit' => \App\Enums\Database\ProductUnit::KILOGRAM,
            'is_published' => true,
        ]);

        $this->line("Created product ID: {$product->id}");
        $this->line("Initial price: {$product->current_price}");

        // Insert price directly using DB (to test trigger)
        $newPrice = '2500.75';
        DB::table('product_prices')->insert([
            'product_id' => $product->id,
            'price' => $newPrice,
            'currency_code' => CurrencyCode::IRR->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Refresh product
        $product->refresh();

        $this->line("New price inserted: {$newPrice}");
        $this->line("Product current_price after trigger: {$product->current_price}");

        if ($product->current_price === $newPrice) {
            $this->info('✓ Trigger works! Product price was updated automatically.');
        } else {
            $this->error('✗ Trigger failed! Product price was NOT updated.');
            $this->error("Expected: {$newPrice}, Got: {$product->current_price}");
        }

        // Cleanup
        $product->delete();
    }

    /**
     * Test trigger with existing product.
     */
    private function testWithProduct(Product $product): void
    {
        $this->newLine();
        $this->info("=== Testing Trigger with Product ID: {$product->id} ===");

        $initialPrice = $product->current_price;
        $this->line("Initial price: {$initialPrice}");

        // Insert new price
        $newPrice = '5000.50';
        DB::table('product_prices')->insert([
            'product_id' => $product->id,
            'price' => $newPrice,
            'currency_code' => CurrencyCode::IRR->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Refresh product
        $product->refresh();

        $this->line("New price inserted: {$newPrice}");
        $this->line("Product current_price after trigger: {$product->current_price}");

        if ($product->current_price === $newPrice) {
            $this->info('✓ Trigger works! Product price was updated automatically.');
        } else {
            $this->error('✗ Trigger failed! Product price was NOT updated.');
            $this->error("Expected: {$newPrice}, Got: {$product->current_price}");
        }
    }

    /**
     * Test bulk update functionality.
     */
    private function testBulkUpdate(): void
    {
        $this->newLine();
        $this->info('=== Testing Bulk Update ===');

        // Create test products
        $product1 = Product::create([
            'name' => 'Bulk Test Product 1',
            'slug' => 'bulk-test-1-' . time(),
            'current_price' => '1000.00',
            'currency_code' => CurrencyCode::IRR,
            'status' => \App\Enums\Database\ProductStatus::ACTIVE,
            'unit' => \App\Enums\Database\ProductUnit::KILOGRAM,
            'is_published' => true,
        ]);

        $product2 = Product::create([
            'name' => 'Bulk Test Product 2',
            'slug' => 'bulk-test-2-' . time(),
            'current_price' => '2000.00',
            'currency_code' => CurrencyCode::IRR,
            'status' => \App\Enums\Database\ProductStatus::ACTIVE,
            'unit' => \App\Enums\Database\ProductUnit::KILOGRAM,
            'is_published' => true,
        ]);

        $this->line("Created products: {$product1->id}, {$product2->id}");

        // Get service
        $service = app(ProductPriceService::class);

        // Prepare bulk update
        $prices = [
            [
                'product_id' => $product1->id,
                'price' => '1500.00',
                'currency_code' => CurrencyCode::IRR->value,
            ],
            [
                'product_id' => $product2->id,
                'price' => '2500.00',
                'currency_code' => CurrencyCode::IRR->value,
            ],
        ];

        $this->line('Performing bulk update...');
        $count = $service->bulkUpdate($prices);
        $this->line("Bulk update created {$count} price(s)");

        // Refresh products
        $product1->refresh();
        $product2->refresh();

        $this->line("Product 1 current_price: {$product1->current_price}");
        $this->line("Product 2 current_price: {$product2->current_price}");

        $success = true;
        // Compare as floats to handle decimal precision
        if (abs((float) $product1->current_price - 1500.00) >= 0.01) {
            $this->error("Product 1: Expected 1500.00, got {$product1->current_price}");
            $success = false;
        }
        if (abs((float) $product2->current_price - 2500.00) >= 0.01) {
            $this->error("Product 2: Expected 2500.00, got {$product2->current_price}");
            $success = false;
        }

        if ($success) {
            $this->info('✓ Bulk update works! Both products were updated.');
        } else {
            $this->error('✗ Bulk update failed! Products were NOT updated correctly.');
        }

        // Cleanup
        $product1->delete();
        $product2->delete();
    }
}
