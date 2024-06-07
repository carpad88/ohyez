<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Filament\App\Resources\EventResource;
use App\Settings\GeneralSettings;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.admin.resources.event.pages.list-events';

    protected static ?string $title = 'Mis eventos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Crear evento')
                ->modalHeading('Elige un paquete')
                ->modalContent(view(
                    'filament.app.tiers',
                    ['tiers' => app(GeneralSettings::class)->tiers]
                ))
                ->modalSubmitAction(false)
                ->modalCancelAction(false),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'Bienvenido, '.auth()->user()->name.'!';
    }
}
