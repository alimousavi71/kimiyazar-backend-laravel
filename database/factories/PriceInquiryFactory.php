<?php

namespace Database\Factories;

use App\Models\PriceInquiry;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PriceInquiry>
 */
class PriceInquiryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PriceInquiry::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get published products to use for the products array
        $publishedProducts = Product::where('is_published', true)->pluck('id')->toArray();

        // Select 1-5 random product IDs
        $productIds = [];
        if (!empty($publishedProducts)) {
            $count = fake()->numberBetween(1, min(5, count($publishedProducts)));
            $productIds = fake()->randomElements($publishedProducts, $count);
        }

        // 50% chance of having a user (authenticated), 50% guest
        $hasUser = fake()->boolean(50);
        $user = $hasUser ? User::inRandomOrder()->first() : null;

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => $user?->email ?? fake()->unique()->safeEmail(),
            'phone_number' => $user?->phone_number ?? fake()->numerify('09#########'),
            'products' => $productIds,
            'is_reviewed' => fake()->boolean(30), // 30% chance of being reviewed
            'user_id' => $user?->id,
        ];
    }

    /**
     * Indicate that the price inquiry is reviewed.
     *
     * @return static
     */
    public function reviewed(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_reviewed' => true,
        ]);
    }

    /**
     * Indicate that the price inquiry is not reviewed.
     *
     * @return static
     */
    public function unreviewed(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_reviewed' => false,
        ]);
    }

    /**
     * Indicate that the price inquiry belongs to a user.
     *
     * @param User|null $user
     * @return static
     */
    public function forUser(?User $user = null): static
    {
        $user = $user ?? User::inRandomOrder()->first();

        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone_number' => $user->phone_number ?? fake()->numerify('09#########'),
        ]);
    }

    /**
     * Indicate that the price inquiry is from a guest user.
     *
     * @return static
     */
    public function guest(): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => null,
            'email' => fake()->unique()->safeEmail(),
        ]);
    }
}
