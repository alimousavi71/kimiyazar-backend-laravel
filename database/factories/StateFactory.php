<?php

namespace Database\Factories;

use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\State>
 */
class StateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = State::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::factory(),
            'name' => fake()->state(),
        ];
    }

    /**
     * Indicate that the state belongs to Iran.
     *
     * @return static
     */
    public function forIran(): static
    {
        return $this->state(fn(array $attributes) => [
            'country_id' => Country::where('code', 'IR')->first()?->id ?? Country::factory()->iran(),
        ]);
    }

    /**
     * Indicate that the state belongs to Germany.
     *
     * @return static
     */
    public function forGermany(): static
    {
        return $this->state(fn(array $attributes) => [
            'country_id' => Country::where('code', 'DE')->first()?->id ?? Country::factory()->germany(),
        ]);
    }
}
