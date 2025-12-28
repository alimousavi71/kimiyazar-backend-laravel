<?php

namespace Database\Seeders;

use App\Models\Tagable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Content;
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

        // Use only first 8 tagables
        $tagablesData = array_slice($tagablesData, 0, 8);

        $this->command->info("Importing " . count($tagablesData) . " tagables (only those with existing tags)...");

        $imported = 0;
        $skipped = 0;

        DB::transaction(function () use ($tagablesData, &$imported, &$skipped) {
            Tagable::unguard();

            foreach ($tagablesData as $item) {
                // Check if tag exists
                $tagId = (int) $item['tag_id'];
                if (!\App\Models\Tag::find($tagId)) {
                    $skipped++;
                    continue;
                }

                // Map tagable_type to Laravel model class
                $tagableType = $this->mapTagableType($item['tagable_type']);

                // Insert exactly as provided
                Tagable::create([
                    'id' => (int) $item['id'],
                    'tag_id' => $tagId,
                    'tagable_type' => $tagableType,
                    'tagable_id' => (int) $item['tagable_id'],
                ]);
                $imported++;
            }

            Tagable::reguard();
        });

        $this->command->info("Successfully imported {$imported} tagables! ({$skipped} skipped - tag not found)");

        $this->command->info("Successfully imported " . count($tagablesData) . " tagables!");
    }
}

