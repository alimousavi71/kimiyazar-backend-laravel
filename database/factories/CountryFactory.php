<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->country(),
            'code' => fake()->countryCode(),
        ];
    }

    /**
     * Indicate that the country is Iran.
     *
     * @return static
     */
    public function iran(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Iran',
            'code' => 'IR',
        ]);
    }

    /**
     * Indicate that the country is Germany.
     *
     * @return static
     */
    public function germany(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Germany',
            'code' => 'DE',
        ]);
    }

    /**
     * Indicate that the country is United States.
     *
     * @return static
     */
    public function usa(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'United States',
            'code' => 'US',
        ]);
    }
}
