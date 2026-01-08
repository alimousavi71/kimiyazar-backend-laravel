<?php

namespace Database\Seeders;

use App\Enums\Database\ContentType;
use App\Models\Content;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class ArticleSeeder extends Seeder
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
        $articlesData = json_decode(File::get(database_path('import/article.json')), true);

        if (!$articlesData || !is_array($articlesData)) {
            $this->command->error('Failed to read or parse article.json file');
            return;
        }

        // Apply record limit if set
        if ($this->recordLimit !== null) {
            $articlesData = array_slice($articlesData, 0, $this->recordLimit);
        }

        $totalRecords = count($articlesData);
        $this->command->info("Importing {$totalRecords} articles...");

        $imported = 0;
        $skipped = 0;
        $errors = 0;

        Content::unguard();

        foreach ($articlesData as $item) {
            try {
                // Normalize slug
                $slug = !empty($item['slug']) ? trim($item['slug']) : null;

                // Check for existing content by slug
                if ($slug && Content::where('slug', $slug)->where('type', ContentType::ARTICLE)->exists()) {
                    $skipped++;
                    continue;
                }

                // Map JSON fields to database fields
                $contentData = [
                    'type' => ContentType::ARTICLE,
                    'title' => $item['title'] ?? null,
                    'slug' => $slug,
                    'body' => $item['text'] ?? null,
                    'seo_description' => !empty($item['seo_desc']) ? trim($item['seo_desc']) : null,
                    'seo_keywords' => !empty($item['seo_keywords']) ? trim($item['seo_keywords']) : null,
                    'is_active' => isset($item['active']) ? (int) $item['active'] === 1 : true,
                    'visit_count' => isset($item['visit']) ? (int) $item['visit'] : 0,
                ];

                // Validate required fields
                if (empty($contentData['title']) || empty($contentData['slug'])) {
                    $skipped++;
                    $this->command->warn("Skipped article (missing title or slug): " . json_encode($item));
                    continue;
                }

                // Handle timestamps
                $cdateTimestamp = (int) ($item['cdate'] ?? 0);
                if ($cdateTimestamp > 0) {
                    $contentData['created_at'] = Carbon::createFromTimestamp($cdateTimestamp);
                    $contentData['updated_at'] = Carbon::createFromTimestamp($cdateTimestamp);
                } else {
                    $contentData['created_at'] = Carbon::now();
                    $contentData['updated_at'] = Carbon::now();
                }

                Content::create($contentData);
                $imported++;
            } catch (\Exception $e) {
                $errors++;
                $articleId = $item['id'] ?? 'N/A';
                $this->command->warn("Failed to import article (id: {$articleId}): " . $e->getMessage());
                continue;
            }
        }

        Content::reguard();

        $this->command->info("Successfully imported {$imported} articles!");
        if ($skipped > 0) {
            $this->command->info("Skipped {$skipped} articles (already exist or missing data).");
        }
        if ($errors > 0) {
            $this->command->warn("Encountered {$errors} errors during import.");
        }
    }
}
