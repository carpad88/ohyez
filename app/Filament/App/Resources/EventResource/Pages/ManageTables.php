<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Enums\InvitationStatus;
use App\Filament\App\Resources\EventResource;
use App\Models\Guest;
use App\Models\Invitation;
use Filament\Actions;
use Filament\Notifications\Notification;

class ManageTables extends EditEventRecord
{
    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.app.resources.event.pages.manage-tables';

    protected static ?string $title = 'Administrar mesas';

    protected static ?string $navigationIcon = 'phosphor-list-numbers-duotone';

    protected static ?string $navigationGroup = 'Administrar invitaciones';

    public array $tables = [];

    public static function canAccess(array $parameters = []): bool
    {
        return $parameters['record']->hasFeaturesWithCode('TAB');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('download')
                ->visible(fn () => $this->record->hasFeaturesWithCode('LIS'))
                ->label('Descargar lista')
                ->icon('heroicon-o-document-arrow-down')
                ->url(fn () => route('event.invitations-list-pdf', [
                    'event' => $this->record->id,
                ]))
                ->outlined()
                ->openUrlInNewTab(),
        ];
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->groupGuestsByTable($record);
    }

    public function saveTables($data): void
    {
        collect($data)
            ->filter(fn ($table) => count($table) > 0)
            ->mapWithKeys(fn ($table, $tableNumber) => [$tableNumber => collect($table)->pluck('id')])
            ->each(fn ($table, $key) => Guest::whereIn('id', $table->toArray())->update(['table' => $key]));

        $this->groupGuestsByTable($this->record->id);
        $this->dispatch('tables-updated');

        Notification::make()
            ->title('Guardado')
            ->body('El acomodo de las mesas ha sido guardado exitosamente.')
            ->success()
            ->send();
    }

    protected function groupGuestsByTable($record): void
    {
        $tables = Invitation::query()
            ->with(['guests' => fn ($query) => $query->whereConfirmed(true)
                ->select('id', 'invitation_id', 'name', 'table'),
            ])
            ->where([
                'event_id' => $record,
                'status' => InvitationStatus::Confirmed,
            ])
            ->get(['family', 'id'])
            ->flatMap(function ($item) {
                return $item['guests']->map(function ($guest) use ($item) {
                    return array_merge(['family' => $item['family']], $guest->toArray());
                });
            })
            ->sortBy('table')
            ->groupBy('table')
            ->toArray();

        $this->tables = ! isset($tables[0]) ? [[], ...$tables] : [...$tables];
    }
}
