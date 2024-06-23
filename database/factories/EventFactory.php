<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $name = fake()->sentence(3);

        return [
            'user_id' => User::factory(),
            'code' => str()->random(6),
            'title' => $name,
            'uuid' => str()->uuid()->toString(),
            'password' => Hash::make('12345'),
            'template_id' => Template::factory(),
            'event_type' => fake()->randomElement(['wedding', 'xv']),
            'slug' => Str::slug($name),
            'date' => fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'time' => fake()->time('H:i'),
            'content' => createEmptyEvent(),
        ];
    }
}
