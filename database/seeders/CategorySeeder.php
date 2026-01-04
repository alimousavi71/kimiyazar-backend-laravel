<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Services\SlugService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    /**
     * Record limit for import (null = no limit, number = limit to that many records).
     */
    private ?int $recordLimit = 100;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesData = json_decode(File::get(database_path('import/category.json')), true);

        if (!$categoriesData || !is_array($categoriesData)) {
            $this->command->error('Failed to read or parse category.json file');
            return;
        }

        // Apply record limit if set
        if ($this->recordLimit !== null) {
            $categoriesData = array_slice($categoriesData, 0, $this->recordLimit);
        }

        $totalRecords = count($categoriesData);
        $this->command->info("Importing {$totalRecords} categories...");

        $imported = 0;
        $skipped = 0;
        $errors = 0;

        $usedSlugs = [];

        Category::unguard();

        foreach ($categoriesData as $item) {
            try {
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

                $imported++;
            } catch (\Exception $e) {
                $errors++;
                $this->command->warn("Failed to import category (id: {$item['id']}): " . $e->getMessage());
                continue;
            }
        }

        Category::reguard();

        $this->command->info("Successfully imported {$imported} categories!");
        if ($skipped > 0) {
            $this->command->info("Skipped {$skipped} categories (already exist or missing data).");
        }
        if ($errors > 0) {
            $this->command->warn("Encountered {$errors} errors during import.");
        }
    }
}
