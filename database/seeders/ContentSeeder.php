<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create news content
        Content::factory()
            ->count(20)
            ->news()
            ->active()
            ->create();

        // Create article content
        Content::factory()
            ->count(25)
            ->article()
            ->active()
            ->create();

        // Create page content
        Content::factory()
            ->count(10)
            ->page()
            ->active()
            ->create();

        // Create some undeletable pages
        Content::factory()
            ->count(3)
            ->undeletable()
            ->active()
            ->create();

        // Create some inactive content
        Content::factory()
            ->count(15)
            ->inactive()
            ->create();
    }
}
