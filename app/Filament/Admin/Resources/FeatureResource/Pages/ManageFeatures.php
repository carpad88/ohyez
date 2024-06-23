<?php

namespace App\Filament\Admin\Resources\FeatureResource\Pages;

use App\Filament\Admin\Resources\FeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFeatures extends ManageRecords
{
    protected static string $resource = FeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('lg'),
        ];
    }
}
