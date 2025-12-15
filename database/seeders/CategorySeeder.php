<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create root categories
        $rootCategories = Category::factory()
            ->count(5)
            ->active()
            ->create()
            ->each(function ($category, $index) {
                $category->update(['sort_order' => $index + 1]);
            });

        // Create child categories for each root
        foreach ($rootCategories as $rootCategory) {
            Category::factory()
                ->count(3)
                ->active()
                ->childOf($rootCategory)
                ->create()
                ->each(function ($category, $index) {
                    $category->update(['sort_order' => $index + 1]);
                });
        }

        // Create some inactive categories
        Category::factory()
            ->count(3)
            ->inactive()
            ->create();
    }
}
