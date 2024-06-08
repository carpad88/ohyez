<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Filament\App\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected static ?string $title = 'Detalles del evento';

    protected static ?string $navigationIcon = 'phosphor-info-duotone';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Guardar cambios')
                ->button()
                ->action('save'),
        ];
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }
}
