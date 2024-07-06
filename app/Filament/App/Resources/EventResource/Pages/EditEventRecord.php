<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Filament\App\Resources\EventResource;
use Filament\Actions;
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

        $newContent = $data['content'];
        unset($data['content']);

        return [
            ...$data,
            'content' => [
                ...$this->getRecord()->content,
                ...$newContent,
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->outlined()
                ->label('Previsualizar')
                ->url(fn ($record) => route('event.preview', $record->id))
                ->openUrlInNewTab(),
            Actions\Action::make('save')
                ->label('Guardar cambios')
                ->action('save'),
        ];
    }
}
