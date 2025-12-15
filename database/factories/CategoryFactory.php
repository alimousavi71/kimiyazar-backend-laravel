<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'slug' => fake()->unique()->slug(),
            'is_active' => fake()->boolean(80), // 80% chance of being active
            'parent_id' => null,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    /**
     * Indicate that the category is active.
     *
     * @return static
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => 1,
        ]);
    }

    /**
     * Indicate that the category is inactive.
     *
     * @return static
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => 0,
        ]);
    }

    /**
     * Set the category as a child of another category.
     *
     * @param int|Category $parentId
     * @return static
     */
    public function childOf(int|Category $parentId): static
    {
        $parentId = $parentId instanceof Category ? $parentId->id : $parentId;

        return $this->state(fn(array $attributes) => [
            'parent_id' => $parentId,
        ]);
    }
}
