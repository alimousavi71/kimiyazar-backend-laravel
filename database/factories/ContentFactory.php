<?php

namespace Database\Factories;

use App\Enums\Database\ContentType;
use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Content::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(ContentType::cases());

        return [
            'type' => $type,
            'title' => fake()->sentence(4),
            'slug' => fake()->unique()->slug(),
            'body' => fake()->optional(90)->paragraphs(5, true),
            'seo_description' => fake()->optional(70)->sentence(10),
            'seo_keywords' => fake()->optional(60)->words(5, true),
            'is_active' => fake()->boolean(80), // 80% chance of being active
            'visit_count' => fake()->numberBetween(0, 10000),
            'is_undeletable' => $type === ContentType::PAGE ? fake()->boolean(20) : false, // Only pages can be undeletable
        ];
    }

    /**
     * Indicate that the content is news.
     *
     * @return static
     */
    public function news(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => ContentType::NEWS,
            'is_undeletable' => false,
        ]);
    }

    /**
     * Indicate that the content is an article.
     *
     * @return static
     */
    public function article(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => ContentType::ARTICLE,
            'is_undeletable' => false,
        ]);
    }

    /**
     * Indicate that the content is a page.
     *
     * @return static
     */
    public function page(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => ContentType::PAGE,
        ]);
    }

    /**
     * Indicate that the content is active.
     *
     * @return static
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the content is inactive.
     *
     * @return static
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the content is undeletable (only for pages).
     *
     * @return static
     */
    public function undeletable(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => ContentType::PAGE,
            'is_undeletable' => true,
        ]);
    }
}
