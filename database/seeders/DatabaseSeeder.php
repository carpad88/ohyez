<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\Event::factory()
            ->has(
                \App\Models\Invitation::factory(5)
                    ->hasGuests(2, ['confirmed' => false])
                    ->state(function (array $attributes) {
                        return ['status' => 'pending'];
                    })
            )
            ->create(['user_id' => 2]);

        \App\Models\Template::factory(5)->create();

        \App\Models\Message::factory(5)->create();
    }
}
