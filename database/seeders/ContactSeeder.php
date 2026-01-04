<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class ContactSeeder extends Seeder
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
        $contactsData = json_decode(File::get(database_path('import/contact.json')), true);

        if (!$contactsData || !is_array($contactsData)) {
            $this->command->error('Failed to read or parse contact.json file');
            return;
        }

        // Apply record limit if set
        if ($this->recordLimit !== null) {
            $contactsData = array_slice($contactsData, 0, $this->recordLimit);
        }

        $totalRecords = count($contactsData);
        $this->command->info("Importing {$totalRecords} contacts...");

        $imported = 0;
        $skipped = 0;
        $errors = 0;

        Contact::unguard();

        foreach ($contactsData as $item) {
            try {
                // Map JSON fields to database fields
                $contactData = [
                    'id' => (int) $item['id'],
                    'title' => $item['title'] ?? null,
                    'text' => $item['text'] ?? null,
                    'email' => $item['email'] ?? null,
                    'mobile' => $item['mobile'] ?? null,
                    'is_read' => isset($item['seen']) ? (int) $item['seen'] === 1 : false,
                ];

                // Handle timestamps
                if (!empty($item['cdate']) && $item['cdate'] !== '0') {
                    $timestamp = (int) ($item['cdate'] ?? 0);
                    if ($timestamp > 0) {
                        $contactData['created_at'] = Carbon::createFromTimestamp($timestamp);
                        $contactData['updated_at'] = Carbon::createFromTimestamp($timestamp);
                    } else {
                        $contactData['created_at'] = Carbon::now();
                        $contactData['updated_at'] = Carbon::now();
                    }
                } else {
                    $contactData['created_at'] = Carbon::now();
                    $contactData['updated_at'] = Carbon::now();
                }

                Contact::create($contactData);

                $imported++;
            } catch (\Exception $e) {
                $errors++;
                $this->command->warn("Failed to import contact (id: {$item['id']}): " . $e->getMessage());
                continue;
            }
        }

        Contact::reguard();

        $this->command->info("Successfully imported {$imported} contacts!");
        if ($skipped > 0) {
            $this->command->info("Skipped {$skipped} contacts (already exist or missing data).");
        }
        if ($errors > 0) {
            $this->command->warn("Encountered {$errors} errors during import.");
        }
    }
}
