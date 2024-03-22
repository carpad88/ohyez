<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'event_type' => fake()->randomElement(['wedding', 'xv', 'birthday']),
            'content' => $this->faker->paragraphs(1, true),
        ];
    }
}
