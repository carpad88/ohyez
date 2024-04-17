<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Enums\InvitationStatus;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\InvitationResource;
use App\Models\Invitation;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ManageAttendance extends ManageRelatedRecords
{
    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.resources.event.pages.attendance';

    protected static string $relationship = 'invitations';

    protected static ?string $title = 'Asistencia';

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected $listeners = ['checkInCompleted' => '$refresh'];

    public static function canAccess(array $parameters = []): bool
    {
        return true;
    }

    public function getBreadcrumbs(): array
    {
        if (auth()->user()->hasRole('super_admin')) {
            return parent::getBreadcrumbs();
        }

        return [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('family')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvitationStatus::Confirmed))
            ->defaultGroup('table')
            ->groupingSettingsHidden()
            ->groups([
                Group::make('table')
                    ->label('Mesa'),
            ])
            ->defaultSort('family')
            ->columns([
                Tables\Columns\Layout\Grid::make([
                    'sm' => 1,
                ])
                    ->schema([
                        Tables\Columns\TextColumn::make('family')
                            ->weight(FontWeight::Bold)
                            ->color('primary')
                            ->size(Tables\Columns\TextColumn\TextColumnSize::Large)
                            ->searchable(),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('checkedIn')
                                ->grow(false)
                                ->weight(FontWeight::SemiBold)
                                ->color('success')
                                ->dateTime('H:i')
                                ->icon('heroicon-m-clock')
                                ->searchable(),

                            Tables\Columns\TextColumn::make('checkedIn')
                                ->size('xs')
                                ->color('gray')
                                ->prefix('(')
                                ->suffix(')')
                                ->dateTime()
                                ->since()
                                ->searchable(),
                        ])
                            ->visible(fn (Invitation $record) => $record->checkedIn !== null)
                            ->extraAttributes(['class' => 'mb-4']),

                        Tables\Columns\TextColumn::make('guests')
                            ->grow(false)
                            ->state(fn (Invitation $record) => collect($record->guests)
                                ->filter(fn (array $guest) => $guest['confirmed'])
                                ->count().' personas')
                            ->color('warning')
                            ->badge(),
                        Tables\Columns\TextColumn::make('guests')
                            ->state(fn (Invitation $record) => collect($record->guests)
                                ->filter(fn (array $guest) => $guest['confirmed'])
                                ->map(fn (array $guest) => $guest['name'])
                            )
                            ->bulleted()
                            ->expandableLimitedList()
                            ->limitList(),
                    ]),
            ])
            ->paginated([12, 24, 48, 96])
            ->contentGrid([
                'sm' => 2,
                'lg' => 3,
                'xl' => 4,
            ])
            ->actions([
                Tables\Actions\Action::make('checkIn')
                    ->visible(fn (Invitation $record) => $record->checkedIn === null)
                    ->label('Check In')
                    ->icon('heroicon-o-qr-code')
                    ->size(ActionSize::ExtraLarge)
                    ->requiresConfirmation()
                    ->modalHeading('Check-in sin escaneo de QR')
                    ->modalDescription('¿Estás seguro registrar la asistencia de esta invitación sin escanear el QR?')
                    ->action(function (Invitation $record) {
                        $eventDateTime = Carbon::parse($record->event->date->format('Y-m-d').' '.$record->event->time);

                        if (now()->lessThan($eventDateTime)) {
                            Notification::make()
                                ->title('Simulación de check-in exitoso')
                                ->body('El evento aún no inicia, por lo que este check-in es simulado.')
                                ->success()
                                ->send();

                            return;
                        }

                        $record->update(['checkedIn' => now()]);
                        $this->dispatch('checkInCompleted');

                        Notification::make()
                            ->title('Check-in exitoso')
                            ->body('La invitación ya quedo registrada')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('download')
                ->label('Descargar lista')
                ->icon('heroicon-o-document-arrow-down')
                ->size(ActionSize::ExtraLarge)
                ->url(fn () => route('event.invitations', [
                    'event' => $this->record->id,
                ]))
                ->openUrlInNewTab(),
            Actions\Action::make('scan')
                ->label('Check In')
                ->icon('heroicon-o-qr-code')
                ->size(ActionSize::ExtraLarge)
                ->action(fn () => $this->dispatch('open-modal', id: 'qr-scanner')),
        ];
    }

    public function getTabs(): array
    {
        return [
            'pending' => Tab::make('Pendientes')
                ->badge(InvitationResource::getEloquentQuery()
                    ->whereNull('checkedIn')
                    ->where('status', InvitationStatus::Confirmed)
                    ->where('event_id', $this->record->id)
                    ->count()
                )
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('checkedIn')),
            'registered' => Tab::make('Registrados')
                ->badge(InvitationResource::getEloquentQuery()
                    ->whereNotNull('checkedIn')
                    ->where('status', InvitationStatus::Confirmed)
                    ->where('event_id', $this->record->id)
                    ->count()
                )
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('checkedIn')),
        ];
    }
}
