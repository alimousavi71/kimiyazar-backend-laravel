<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
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
        $membersData = json_decode(File::get(database_path('import/member.json')), true);

        if (!$membersData || !is_array($membersData)) {
            $this->command->error('Failed to read or parse member.json file');
            return;
        }

        // Apply record limit if set
        if ($this->recordLimit !== null) {
            $membersData = array_slice($membersData, 0, $this->recordLimit);
        }

        $totalRecords = count($membersData);
        $this->command->info("Importing {$totalRecords} users...");

        $imported = 0;
        $skipped = 0;
        $errors = 0;

        User::unguard();

        foreach ($membersData as $member) {
            try {
                // Normalize email (trim and convert empty to null)
                $email = !empty($member['email']) ? trim($member['email']) : null;
                $email = !empty($email) ? $email : null; // Ensure empty strings become null
                $phone = !empty($member['mobile']) ? trim($member['mobile']) : null;

                // Check if user already exists by email or phone
                $query = User::query();

                if ($email) {
                    $query->where('email', $email);
                }

                if ($phone) {
                    if ($email) {
                        $query->orWhere('phone_number', $phone);
                    } else {
                        $query->where('phone_number', $phone);
                    }
                }

                // If both email and phone are empty, skip (can't identify user)
                if (!$email && !$phone) {
                    $skipped++;
                    continue;
                }

                $existingUser = $query->first();

                if ($existingUser) {
                    $skipped++;
                    continue;
                }

                // Map JSON fields to database fields
                // Use DB::table()->insert() to bypass Laravel's automatic password hashing
                // so we can preserve the SHA1 hash from the old system
                $userData = [
                    'first_name' => $member['fname'] ?? null,
                    'last_name' => $member['lname'] ?? null,
                    'email' => $email, // Already normalized above (NULL for empty)
                    'phone_number' => $phone,
                    'country_code' => $phone ? '+98' : null, // All users are from Iran
                    'password' => $member['password'] ?? '', // SHA1 hash from old system
                    'is_active' => isset($member['active']) ? (int) $member['active'] === 1 : true,
                    'email_verified_at' => !empty($member['active']) && (int) $member['active'] === 1 ? Carbon::now() : null,
                ];

                // Handle timestamps
                if (!empty($member['cdate']) && $member['cdate'] !== '0') {
                    $timestamp = (int) ($member['cdate'] ?? 0);
                    if ($timestamp > 0) {
                        $userData['created_at'] = Carbon::createFromTimestamp($timestamp);
                        $userData['updated_at'] = Carbon::createFromTimestamp($timestamp);
                    } else {
                        $userData['created_at'] = Carbon::now();
                        $userData['updated_at'] = Carbon::now();
                    }
                } else {
                    $userData['created_at'] = Carbon::now();
                    $userData['updated_at'] = Carbon::now();
                }

                if (!empty($member['last_login']) && $member['last_login'] !== '0') {
                    $lastLoginTimestamp = (int) ($member['last_login'] ?? 0);
                    if ($lastLoginTimestamp > 0) {
                        $userData['last_login'] = Carbon::createFromTimestamp($lastLoginTimestamp);
                    }
                }

                // Insert directly using DB to bypass model's password hashing
                // This preserves the SHA1 hash from the old system
                $userId = DB::table('users')->insertGetId($userData);

                $imported++;
            } catch (\Exception $e) {
                $errors++;
                $email = $member['email'] ?? 'N/A';
                $this->command->warn("Failed to import user (email: {$email}): " . $e->getMessage());
                continue;
            }
        }

        User::reguard();

        $this->command->info("Successfully imported {$imported} users!");
        if ($skipped > 0) {
            $this->command->info("Skipped {$skipped} users (already exist or missing data).");
        }
        if ($errors > 0) {
            $this->command->warn("Encountered {$errors} errors during import.");
        }
    }

}
