<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.resources.event.pages.list-events';

    protected static ?string $title = 'Mis eventos';

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    public function getBreadcrumbs(): array
    {
        if (auth()->user()->hasRole('super_admin')) {
            return parent::getBreadcrumbs();
        }

        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
