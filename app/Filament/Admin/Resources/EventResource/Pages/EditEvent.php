<?php

namespace App\Filament\Admin\Resources\EventResource\Pages;

use App\Filament\Admin\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected static ?string $title = 'Editar evento';

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    protected static ?string $activeNavigationIcon = 'heroicon-m-pencil';

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
            Actions\Action::make('header_save')
                ->label('Guardar cambios')
                ->button()
                ->action('save'),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
