<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\ActionSize;
use Illuminate\Contracts\Support\Htmlable;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.resources.event.pages.attendance';

    public function getTitle(): string|Htmlable
    {
        return 'Asistencia';
    }

    public function getBreadcrumbs(): array
    {
        return [
            'Eventos' => 'Evento',
            $this->record->name => $this->record->id,
            '#' => 'Asistencia',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('scan')
                ->label('Check In')
                ->icon('heroicon-o-qr-code')
                ->size(ActionSize::ExtraLarge)
                ->action(fn () => $this->dispatch('open-modal', id: 'qr-scanner')),
            //                ->modalWidth('sm')
            //                ->modalHeading('Escanear código QR')
            //                ->modalContent(fn ($action) => view('components.scan-qr'))
            //                ->modalCancelAction(false)
            //                ->modalSubmitAction(false),

        ];
    }
}
