<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class InvitationFactory extends Factory
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
            'uuid' => str()->uuid()->toString(),
            'password' => Hash::make('12345'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'declined']),
            'family' => $this->faker->lastName(),
            'phone' => $this->faker->numberBetween(1000000000, 9999999999), // generate a phone number with 10 digits
            'email' => $this->faker->email(),
        ];
    }
}
