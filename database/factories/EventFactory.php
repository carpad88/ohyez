<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
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
            'event_type' => fake()->randomElement(['wedding', 'xv', 'birthday']),
            'title' => $name,
            'slug' => Str::slug($name),
            'date' => fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'template' => Template::factory(),
            'content' => [
                'welcome' => fake()->sentence(3),
                'description' => fake()->paragraphs(1, true),
            ],
        ];
    }
}
