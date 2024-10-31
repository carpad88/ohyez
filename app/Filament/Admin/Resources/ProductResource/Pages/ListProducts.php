<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Actions\Stripe\SyncProducts;
use App\Filament\Admin\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('sync')
                ->label('Sync Products')
                ->outlined()
                ->action(fn () => (new SyncProducts)->handle()),
        ];
    }
}
