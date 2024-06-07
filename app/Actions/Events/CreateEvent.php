<?php

namespace App\Actions\Events;

use App\Models\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateEvent
{
    public function handle($tier): Event
    {
        do {
            $code = createUUID();
        } while (Event::where('code', $code)->exists());

        $uuid = Str::uuid();

        return auth()
            ->user()
            ->events()
            ->create([
                'code' => $code,
                'tier' => $tier,
                'title' => 'Mi evento',
                'uuid' => $uuid,
                'password' => Hash::make(passwordFromUUID($uuid)),
            ]);
    }
}
