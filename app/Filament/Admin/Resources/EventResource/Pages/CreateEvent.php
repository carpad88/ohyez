<?php

namespace App\Filament\Admin\Resources\EventResource\Pages;

use App\Actions\Events\CreateEvent as CreateEventAction;
use App\Filament\Admin\Resources\EventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $data['slug'] = str()->slug($data['title']);

        return (new CreateEventAction())->handle($data);
    }
}
