<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->optional(70)->sentence(3),
            'text' => fake()->optional(90)->paragraph(3),
            'email' => fake()->optional(80)->safeEmail(),
            'mobile' => fake()->optional(75)->phoneNumber(),
            'is_read' => fake()->boolean(30), // 30% chance of being read
        ];
    }

    /**
     * Indicate that the contact is read.
     *
     * @return static
     */
    public function read(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_read' => true,
        ]);
    }

    /**
     * Indicate that the contact is unread.
     *
     * @return static
     */
    public function unread(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_read' => false,
        ]);
    }
}
