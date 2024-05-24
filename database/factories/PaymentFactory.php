<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomElement([1100, 2200, 3300]),
            'payment_intent' => $this->faker->uuid,
            'payment_link' => $this->faker->url,
            'payment_status' => $this->faker->randomElement(['complete', 'failed', 'pending']),
            'currency' => $this->faker->currencyCode,
            'customer' => $this->faker->uuid,
        ];
    }
}
