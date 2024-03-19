<?php

namespace Database\Factories;

use App\Models\EventType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class EventTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventType::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $option = Arr::random(['wedding', 'xv', 'birthday']);

        return [
            'name' => $option,
            'code' => $option,
            'sections' => ['ceremony' => true],
        ];
    }
}
