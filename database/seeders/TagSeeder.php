<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Services\SlugService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TagSeeder extends Seeder
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
        $tagsData = json_decode(File::get(database_path('import/tags.json')), true);

        if (!$tagsData || !is_array($tagsData)) {
            $this->command->error('Failed to read or parse tags.json file');
            return;
        }

        // Apply record limit if set
        if ($this->recordLimit !== null) {
            $tagsData = array_slice($tagsData, 0, $this->recordLimit);
        }

        $totalRecords = count($tagsData);
        $this->command->info("Importing {$totalRecords} tags...");

        $imported = 0;
        $skipped = 0;
        $errors = 0;

        $usedSlugs = [];

        Tag::unguard();

        foreach ($tagsData as $item) {
            try {
                // Generate unique slug
                $slug = SlugService::makeUnique(
                    SlugService::makeSlug($item['title']),
                    fn(string $s) => isset($usedSlugs[$s])
                );
                $usedSlugs[$slug] = true;

                // Insert exactly as provided
                Tag::create([
                    'id' => (int) $item['id'],
                    'title' => $item['title'],
                    'slug' => $slug,
                ]);

                $imported++;
            } catch (\Exception $e) {
                $errors++;
                $this->command->warn("Failed to import tag (id: {$item['id']}): " . $e->getMessage());
                continue;
            }
        }

        Tag::reguard();

        $this->command->info("Successfully imported {$imported} tags!");
        if ($skipped > 0) {
            $this->command->info("Skipped {$skipped} tags (already exist or missing data).");
        }
        if ($errors > 0) {
            $this->command->warn("Encountered {$errors} errors during import.");
        }
    }
}
