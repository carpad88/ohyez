<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Filament\App\Resources\EventResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;

abstract class EditEventRecord extends EditRecord
{
    protected static string $resource = EventResource::class;

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! isset($data['content'])) {
            return $data;
        }

        return [
            'content' => [
                ...$this->getRecord()->content,
                ...$data['content'],
            ],
        ];
    }
}
