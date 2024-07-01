<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Filament\App\Resources\EventResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.app.resources.event.pages.list-events';

    protected static ?string $title = 'Mis eventos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Crear evento')
                ->modalHeading('Elige un paquete')
                ->modalContent(view(
                    'filament.app.tiers',
                    [
                        'tiers' => Product::where('bundle', true)
                            ->orderBy('default_price_amount')
                            ->get(),
                    ]
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
