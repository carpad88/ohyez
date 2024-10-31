<?php

namespace App\Filament\Admin\Resources\EventResource\Pages;

use App\Actions\Events\CreateEvent as CreateEventAction;
use App\Actions\Payments\CreatePayment;
use App\Filament\Admin\Resources\EventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $data['slug'] = str()->slug($data['title']);

        $event = (new CreateEventAction)->handle($data);

        $session = [
            'payment_intent' => 'pi_ohyez',
            'payment_status' => 'complete',
            'customer' => $data['user_id'],
        ];

        (new CreatePayment)->handle($session, $event, $data['product']);

        return $event;
    }
}
