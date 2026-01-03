<?php

namespace Database\Seeders;

use App\Models\Tagable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Content;
use App\Models\Tag;
class TagableSeeder extends Seeder
{
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

        $this->command->info("Importing " . count($tagablesData) . " tagables (only those with existing tags)...");

        $tagablesData = array_slice($tagablesData, 0, 8);

        $imported = 0;
        $skipped = 0;
        $duplicates = 0;

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
                    $duplicates++;
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
                // Skip on any error (duplicate, constraint violation, etc.) and continue
                $skipped++;
                $this->command->warn("Skipped tagable (tag_id: {$item['tag_id']}, tagable_type: {$item['tagable_type']}, tagable_id: {$item['tagable_id']}): " . $e->getMessage());
                continue;
            }
        }

        Tagable::reguard();

        $this->command->info("Successfully imported {$imported} tagables!");
        if ($skipped > 0) {
            $this->command->info("Skipped {$skipped} tagables (tag not found or errors).");
        }
        if ($duplicates > 0) {
            $this->command->info("Skipped {$duplicates} duplicates (already exist).");
        }
    }
}

