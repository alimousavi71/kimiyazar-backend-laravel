<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Services\SlugService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagsData = json_decode(File::get(database_path('import/tags.json')), true);

        $this->command->info("Importing " . count($tagsData) . " tags...");

        $usedSlugs = [];

        DB::transaction(function () use ($tagsData, &$usedSlugs) {
            Tag::unguard();

            foreach ($tagsData as $item) {
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
            }

            Tag::reguard();
        });

        $this->command->info("Successfully imported " . count($tagsData) . " tags!");
    }
}
