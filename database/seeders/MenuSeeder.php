<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Service Menu
        Menu::create([
            'name' => 'service_menu',
            'links' => [],
        ]);

        // Useful Links Menu
        Menu::create([
            'name' => 'useful_links',
            'links' => [],
        ]);
    }
}
