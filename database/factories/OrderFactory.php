<?php

namespace Database\Factories;

use App\Enums\Database\OrderStatus;
use App\Enums\Database\PaymentType;
use App\Enums\Database\ProductUnit;
use App\Models\Order;
use App\Models\Country;
use App\Models\State;
use App\Models\Bank;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customerType = fake()->randomElement(['real', 'legal']);
        $status = fake()->randomElement(OrderStatus::cases());
        $paymentType = fake()->randomElement(PaymentType::cases());

        $data = [
            'customer_type' => $customerType,
            'member_id' => null,
            'full_name' => $customerType === 'real' ? fake()->name() : null,
            'national_code' => $customerType === 'real' ? fake()->numerify('##########') : null,
            'national_card_photo' => fake()->optional(30)->url(),
            'phone' => fake()->optional(60)->phoneNumber(),
            'mobile' => fake()->numerify('09########'),
            'is_photo_sent' => fake()->boolean(40),
            'company_name' => $customerType === 'legal' ? fake()->company() : null,
            'economic_code' => $customerType === 'legal' ? fake()->numerify('############') : null,
            'registration_number' => $customerType === 'legal' ? fake()->randomNumber(5) : null,
            'official_gazette_photo' => fake()->optional(30)->url(),
            'country_id' => Country::inRandomOrder()->first()?->id,
            'state_id' => State::inRandomOrder()->first()?->id,
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'receiver_full_name' => fake()->name(),
            'delivery_method' => fake()->randomElement(['international_dhl', 'local_post', 'express']),
            'address' => fake()->address(),
            'product_id' => Product::inRandomOrder()->first()?->id,
            'quantity' => fake()->numberBetween(1, 10),
            'unit' => fake()->randomElement(array_column(ProductUnit::cases(), 'value')),
            'unit_price' => fake()->randomFloat(0, 10000, 5000000),
            'product_description' => fake()->optional(60)->sentence(),
            'payment_bank_id' => Bank::inRandomOrder()->first()?->id,
            'payment_type' => $paymentType->value,
            'total_payment_amount' => fake()->numerify('##########'),
            'payment_date' => fake()->boolean(70) ? fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d') : null,
            'payment_time' => fake()->boolean(70) ? fake()->time('H:i:s') : null,
            'admin_note' => fake()->optional(40)->sentence(),
            'status' => $status->value,
            'is_registered_service' => fake()->boolean(20),
            'is_viewed' => fake()->boolean(50),
            'created_at' => fake()->dateTimeBetween('-90 days', 'now')->getTimestamp(),
        ];

        return $data;
    }

    /**
     * Indicate that the order is from an individual customer.
     *
     * @return static
     */
    public function individual(): static
    {
        return $this->state(fn(array $attributes) => [
            'customer_type' => 'real',
            'full_name' => fake()->name(),
            'national_code' => fake()->numerify('##########'),
            'company_name' => null,
            'economic_code' => null,
            'registration_number' => null,
        ]);
    }

    /**
     * Indicate that the order is from a company customer.
     *
     * @return static
     */
    public function company(): static
    {
        return $this->state(fn(array $attributes) => [
            'customer_type' => 'legal',
            'full_name' => null,
            'national_code' => null,
            'company_name' => fake()->company(),
            'economic_code' => fake()->numerify('############'),
            'registration_number' => fake()->randomNumber(5),
        ]);
    }

    /**
     * Indicate that the order is pending payment.
     *
     * @return static
     */
    public function pendingPayment(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => OrderStatus::PendingPayment->value,
            'payment_date' => null,
            'payment_time' => null,
        ]);
    }

    /**
     * Indicate that the order is paid.
     *
     * @return static
     */
    public function paid(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => OrderStatus::Paid->value,
            'payment_date' => fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'payment_time' => fake()->time('H:i:s'),
        ]);
    }

    /**
     * Indicate that the order is viewed.
     *
     * @return static
     */
    public function viewed(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_viewed' => true,
        ]);
    }

    /**
     * Indicate that the order is unviewed.
     *
     * @return static
     */
    public function unviewed(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_viewed' => false,
        ]);
    }
}
