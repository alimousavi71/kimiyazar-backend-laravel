<?php

namespace Database\Seeders;

use App\Models\Tagable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Tag;
use App\Models\Product;
use App\Models\Content;

class TagableSeeder extends Seeder
{
    /**
     * Record limit for import (null = no limit, number = limit to that many records).
     */
    private ?int $recordLimit = null;

    /**
     * Map tagable_type from JSON to Laravel model class names.
     */
    private function mapTagableType(string $type): string
    {
        return match ($type) {
            'product' => Product::class,
            'content' => Content::class,
            default => $type,
        };
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagablesData = json_decode(File::get(database_path('import/tagable.json')), true);

        if (!$tagablesData || !is_array($tagablesData)) {
            $this->command->error('Failed to read or parse tagable.json file');
            return;
        }

        // Apply record limit if set
        if ($this->recordLimit !== null) {
            $tagablesData = array_slice($tagablesData, 0, $this->recordLimit);
        }

        $totalRecords = count($tagablesData);
        $this->command->info("Importing {$totalRecords} tagables...");

        $imported = 0;
        $skipped = 0;
        $errors = 0;

        Tagable::unguard();

        foreach ($tagablesData as $item) {
            try {
                // Check if tag exists
                $tagId = (int) $item['tag_id'];
                if (!Tag::find($tagId)) {
                    $skipped++;
                    continue;
                }

                $tagableId = (int) $item['tagable_id'];
                $tagableType = $this->mapTagableType($item['tagable_type']);

                // Check if tagable already exists (prevent duplicates)
                $exists = Tagable::where('tag_id', $tagId)
                    ->where('tagable_type', $tagableType)
                    ->where('tagable_id', $tagableId)
                    ->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                // Insert exactly as provided
                Tagable::create([
                    'tag_id' => $tagId,
                    'tagable_type' => $tagableType,
                    'tagable_id' => $tagableId,
                ]);

                $imported++;
            } catch (\Exception $e) {
                $errors++;
                $this->command->warn("Failed to import tagable (tag_id: {$item['tag_id']}, tagable_type: {$item['tagable_type']}, tagable_id: {$item['tagable_id']}): " . $e->getMessage());
                continue;
            }
        }

        Tagable::reguard();

        $this->command->info("Successfully imported {$imported} tagables!");
        if ($skipped > 0) {
            $this->command->info("Skipped {$skipped} tagables (already exist or missing data).");
        }
        if ($errors > 0) {
            $this->command->warn("Encountered {$errors} errors during import.");
        }
    }
}

