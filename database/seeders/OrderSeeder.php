<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample orders with different configurations
        
        // 10 pending payment individual orders
        Order::factory()
            ->count(10)
            ->individual()
            ->pendingPayment()
            ->create();

        // 10 paid individual orders
        Order::factory()
            ->count(10)
            ->individual()
            ->paid()
            ->create();

        // 8 pending payment company orders
        Order::factory()
            ->count(8)
            ->company()
            ->pendingPayment()
            ->create();

        // 8 paid company orders
        Order::factory()
            ->count(8)
            ->company()
            ->paid()
            ->create();

        // 5 viewed orders
        Order::factory()
            ->count(5)
            ->viewed()
            ->create();

        // 5 unviewed orders
        Order::factory()
            ->count(5)
            ->unviewed()
            ->create();

        // 4 general orders for variety
        Order::factory()
            ->count(4)
            ->create();
    }
}
