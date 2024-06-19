<?php

namespace App\Filament\Admin\Resources\TemplateResource\Pages;

use App\Filament\Admin\Resources\TemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTemplates extends ManageRecords
{
    protected static string $resource = TemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('md'),
        ];
    }
}
