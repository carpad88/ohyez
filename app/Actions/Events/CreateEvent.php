<?php

namespace App\Actions\Events;

use App\Models\Event;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateEvent
{
    public function handle($params = []): Event
    {
        do {
            $code = createUUID();
        } while (Event::where('code', $code)->exists());

        $uuid = Str::uuid();

        $event = Event::create([
            'user_id' => $params['user_id'] ?? auth()->id(),
            'title' => $params['title'] ?? 'Mi evento',
            'event_type' => $params['event_type'] ?? null,
            'date' => $params['date'] ?? null,
            'time' => $params['time'] ?? null,
            'code' => $code,
            'uuid' => $uuid,
            'password' => Hash::make(passwordFromUUID($uuid)),
            'content' => createEmptyEvent(),
        ]);

        $product = Product::where('stripe_id', $params['product'])
            ->with('features:id')
            ->first();

        $event->features()->attach($product->features);

        return $event;
    }
}
