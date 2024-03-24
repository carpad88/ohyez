<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvitationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invitation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'code' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'declined']),
            'checkedIn' => $this->faker->dateTime(),
            'family' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'table' => $this->faker->numberBetween(-10000, 10000),
            'guests' => '{}',
        ];
    }
}
