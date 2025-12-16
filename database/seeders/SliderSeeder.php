<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create active sliders
        Slider::factory()
            ->count(10)
            ->active()
            ->create();

        // Create inactive sliders
        Slider::factory()
            ->count(3)
            ->inactive()
            ->create();
    }
}
