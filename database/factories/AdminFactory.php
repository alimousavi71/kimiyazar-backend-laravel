<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'is_block' => false,
            'last_login' => null,
            'avatar' => null,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the admin's email address should be unverified.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the admin is blocked.
     *
     * @return static
     */
    public function blocked(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_block' => true,
        ]);
    }

    /**
     * Indicate that the admin has logged in recently.
     *
     * @return static
     */
    public function withLastLogin(): static
    {
        return $this->state(fn(array $attributes) => [
            'last_login' => now()->subDays(rand(1, 30)),
        ]);
    }
}

