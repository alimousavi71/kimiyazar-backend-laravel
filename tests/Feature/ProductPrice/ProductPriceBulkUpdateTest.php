<?php

namespace Tests\Feature\ProductPrice;

use App\Enums\Database\CurrencyCode;
use App\Http\Controllers\Admin\ProductPriceController;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Services\ProductPrice\ProductPriceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductPriceBulkUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that bulk update creates price records and updates products.
     */
    public function test_bulk_update_creates_prices_and_updates_products(): void
    {
        // Skip if not using MySQL/MariaDB
        if (!in_array(DB::connection()->getDriverName(), ['mysql', 'mariadb'])) {
            $this->markTestSkipped('Triggers only work on MySQL/MariaDB');
        }

        // Create products
        $product1 = Product::factory()->create([
            'current_price' => '1000.00',
            'currency_code' => CurrencyCode::IRR,
        ]);

        $product2 = Product::factory()->create([
            'current_price' => '2000.00',
            'currency_code' => CurrencyCode::IRR,
        ]);

        // Get the service
        $service = app(ProductPriceService::class);

        // Prepare bulk update data
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

        // Perform bulk update
        $count = $service->bulkUpdate($prices);

        // Assert that prices were created
        $this->assertEquals(2, $count);
        $this->assertEquals(2, ProductPrice::whereIn('product_id', [$product1->id, $product2->id])->count());

        // Refresh products
        $product1->refresh();
        $product2->refresh();

        // Assert that products were updated (by trigger or manual update)
        $this->assertEquals('1500.00', $product1->current_price);
        $this->assertEquals('2500.00', $product2->current_price);
        $this->assertNotNull($product1->price_updated_at);
        $this->assertNotNull($product2->price_updated_at);
    }

    /**
     * Test that bulk update works through the controller endpoint.
     */
    public function test_bulk_update_endpoint_works(): void
    {
        // Skip if not using MySQL/MariaDB
        if (!in_array(DB::connection()->getDriverName(), ['mysql', 'mariadb'])) {
            $this->markTestSkipped('Triggers only work on MySQL/MariaDB');
        }

        // Create an admin user and authenticate
        $admin = \App\Models\Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        // Create products
        $product1 = Product::factory()->create([
            'current_price' => '1000.00',
            'currency_code' => CurrencyCode::IRR,
        ]);

        $product2 = Product::factory()->create([
            'current_price' => '2000.00',
            'currency_code' => CurrencyCode::IRR,
        ]);

        // Prepare request data
        $data = [
            'prices' => [
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
            ],
        ];

        // Make request to bulk update endpoint
        $response = $this->postJson('/admin/product-prices/bulk-update', $data);

        // Assert response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'count' => 2,
            ],
        ]);

        // Refresh products
        $product1->refresh();
        $product2->refresh();

        // Assert that products were updated
        $this->assertEquals('1500.00', $product1->current_price);
        $this->assertEquals('2500.00', $product2->current_price);
    }

    /**
     * Test that bulk update handles empty array gracefully.
     */
    public function test_bulk_update_handles_empty_array(): void
    {
        $service = app(ProductPriceService::class);

        $count = $service->bulkUpdate([]);

        $this->assertEquals(0, $count);
    }

    /**
     * Test that bulk update validates required fields.
     */
    public function test_bulk_update_validates_required_fields(): void
    {
        // Create an admin user and authenticate
        $admin = \App\Models\Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        // Try to bulk update with missing fields
        $data = [
            'prices' => [
                [
                    'product_id' => 1,
                    // Missing price and currency_code
                ],
            ],
        ];

        $response = $this->postJson('/admin/product-prices/bulk-update', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['prices.0.price', 'prices.0.currency_code']);
    }
}
