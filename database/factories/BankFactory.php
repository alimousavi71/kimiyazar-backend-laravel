<?php

namespace Database\Factories;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bank>
 */
class BankFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bank::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'logo' => fake()->optional(60)->url(),
        ];
    }

    /**
     * Indicate that the bank is a real Iranian bank.
     *
     * @return static
     */
    public function iranianBank(): static
    {
        $banks = [
            'Melli Bank',
            'Pasargad Bank',
            'Sepah Bank',
            'Mellat Bank',
            'Tejarat Bank',
            'Refah Bank',
            'Saderat Bank',
            'Keshavarzi Bank',
        ];

        return $this->state(fn(array $attributes) => [
            'name' => fake()->randomElement($banks),
        ]);
    }

    /**
     * Indicate that the bank has a logo.
     *
     * @return static
     */
    public function withLogo(): static
    {
        return $this->state(fn(array $attributes) => [
            'logo' => fake()->imageUrl(200, 100),
        ]);
    }

    /**
     * Indicate that the bank has no logo.
     *
     * @return static
     */
    public function withoutLogo(): static
    {
        return $this->state(fn(array $attributes) => [
            'logo' => null,
        ]);
    }
}
