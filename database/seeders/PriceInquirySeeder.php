<?php

namespace Database\Seeders;

use App\Models\PriceInquiry;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class PriceInquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get published products
        $publishedProducts = Product::where('is_published', true)->pluck('id')->toArray();

        if (empty($publishedProducts)) {
            $this->command->warn('No published products found. Please seed products first.');
            return;
        }

        // Get existing users for authenticated inquiries
        $users = User::all();

        // Helper function to get random product IDs
        $getRandomProducts = function (int $count) use ($publishedProducts): array {
            $count = min($count, count($publishedProducts));
            if ($count <= 0) {
                return [];
            }
            $shuffled = $publishedProducts;
            shuffle($shuffled);
            return array_slice($shuffled, 0, $count);
        };

        // Create 3 real price inquiries
        $priceInquiries = [
            [
                'first_name' => 'علی',
                'last_name' => 'احمدی',
                'email' => 'ali.ahmadi@example.com',
                'phone_number' => '09123456789',
                'products' => $getRandomProducts(3), // 3 products
                'is_reviewed' => true,
                'user_id' => $users->isNotEmpty() ? $users->first()->id : null,
            ],
            [
                'first_name' => 'سارا',
                'last_name' => 'محمدی',
                'email' => 'sara.mohammadi@example.com',
                'phone_number' => '09187654321',
                'products' => $getRandomProducts(2), // 2 products
                'is_reviewed' => false,
                'user_id' => $users->count() > 1 ? $users->skip(1)->first()->id : null,
            ],
            [
                'first_name' => 'محمد',
                'last_name' => 'رضایی',
                'email' => 'mohammad.rezaei@example.com',
                'phone_number' => '09351234567',
                'products' => $getRandomProducts(5), // Up to 5 products
                'is_reviewed' => true,
                'user_id' => null, // Guest user
            ],
        ];

        foreach ($priceInquiries as $inquiry) {
            PriceInquiry::create($inquiry);
        }

        $this->command->info('Created 3 price inquiries with real data.');
    }
}
