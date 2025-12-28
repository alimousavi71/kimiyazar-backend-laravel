<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Services\SlugService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesData = json_decode(File::get(database_path('import/category.json')), true);

        $this->command->info("Importing " . count($categoriesData) . " categories...");

        $usedSlugs = [];

        DB::transaction(function () use ($categoriesData, &$usedSlugs) {
            Category::unguard();

            foreach ($categoriesData as $item) {
                // Generate unique slug
                $slug = SlugService::makeUnique(
                    SlugService::makeSlug($item['title']),
                    fn(string $s) => isset($usedSlugs[$s])
                );
                $usedSlugs[$slug] = true;

                // Insert exactly as provided
                Category::create([
                    'id' => (int) $item['id'],
                    'name' => $item['title'],
                    'slug' => $slug,
                    'is_active' => (int) $item['active'],
                    'parent_id' => (int) $item['parent_id'] ?: null,
                    'sort_order' => (int) $item['position'],
                ]);
            }

            Category::reguard();
        });

        $this->command->info("Successfully imported " . count($categoriesData) . " categories!");
    }
}
