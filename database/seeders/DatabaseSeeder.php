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

        collect(['wedding', 'xv', 'birthday'])
            ->each(function ($name) {
                \App\Models\EventType::factory()->create([
                    'name' => $name,
                    'code' => $name,
                    'sections' => ['ceremony' => true],
                ]);
            });

        \App\Models\Message::factory(10)->create([
            'event_type_id' => rand(1, 3),
        ]);
    }
}
