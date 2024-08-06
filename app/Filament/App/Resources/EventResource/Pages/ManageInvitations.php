<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Enums\InvitationStatus;
use App\Filament\App\Resources\EventResource;
use App\Filament\App\Resources\InvitationResource;
use App\Models\Invitation;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class ManageInvitations extends ManageRelatedRecords
{
    protected static string $resource = EventResource::class;

    protected static string $relationship = 'invitations';

    protected static ?string $title = 'Invitaciones';

    protected static ?string $navigationIcon = 'phosphor-envelope-open-duotone';

    protected static ?string $navigationGroup = 'Administrar invitaciones';

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->model(Invitation::class)
                ->form($this->getInvitationsFields())
                ->label('Agregar invitación')
                ->modalWidth('xl')
                ->slideOver()
                ->mutateFormDataUsing(function (array $data): array {
                    $uuid = str()->uuid()->toString();

                    $data['event_id'] = $this->record->id;
                    $data['uuid'] = $uuid;
                    $data['password'] = Hash::make(passwordFromUUID($uuid));

                    $data['family'] = str($data['family'])->title();

                    return $data;
                }),
            Actions\Action::make('download')
                ->visible(fn () => $this->record->hasFeaturesWithCode('LIS'))
                ->label('Descargar lista')
                ->icon('heroicon-o-document-arrow-down')
                ->url(fn () => route('event.invitations-list-pdf', [
                    'event' => $this->record->id,
                ]))
                ->openUrlInNewTab(),
            Actions\Action::make('download')
                ->visible(fn () => $this->record->hasFeaturesWithCode('LIS'))
                ->label('Ver boleto')
                ->icon('phosphor-ticket-duotone')
                ->outlined()
                ->url(fn () => route('event.preview-tickets', [
                    'event' => $this->record->id,
                ]))
                ->openUrlInNewTab(),
        ];
    }

    public function table(Table $table): Table
    {
        $hasAutoConfirmation = $this->record->hasFeaturesWithCode('COA');

        return $table
            ->recordTitleAttribute('family')
            ->defaultSort('family')
            ->columns([
                Tables\Columns\Layout\Grid::make([
                    'sm' => 1,
                ])
                    ->schema([
                        Tables\Columns\TextColumn::make('family')
                            ->label('Familia')
                            ->searchable()
                            ->weight(FontWeight::Bold)
                            ->color('primary')
                            ->size(Tables\Columns\TextColumn\TextColumnSize::Large),

                        Tables\Columns\TextColumn::make('phone')
                            ->extraAttributes(['class' => 'my-1'])
                            ->icon('phosphor-phone-duotone'),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('guests_count')
                                ->grow(false)
                                ->counts('guests')
                                ->formatStateUsing(fn ($state) => $state.' personas')
                                ->color('warning')
                                ->badge(),
                            Tables\Columns\TextColumn::make('guests')
                                ->state(fn (Invitation $record) => $record->guests
                                    ->map(fn ($guest) => $guest->name)
                                    ->join(', ')),
                        ]),
                    ]),
            ])
            ->paginated([9, 18, 36, 72])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->visible(fn () => auth()->user()->can('restore_invitation')),
            ])
            ->actions([
                Tables\Actions\Action::make('share')
                    ->hidden(fn ($record) => $record->status === InvitationStatus::Declined)
                    ->icon('phosphor-paper-plane-tilt-duotone')
                    ->label('Compartir')
                    ->url(function (Invitation $record): string {
                        if (app()->environment('local')) {
                            return route('invitation.login', ['invitation' => $record->uuid]);
                        }

                        $fullMessage = config('app.url').'/invitations/'.$record->uuid."/login\n\n";
                        $fullMessage .= 'Hola, te comparto la invitación para mi celebración de XV años.'."\n\n";
                        $fullMessage .= 'Tu código de acceso es:'."\n\n".'*'.passwordFromUUID($record->uuid).'*';

                        $encodedMessage = urlencode($fullMessage);

                        return 'https://wa.me/52'.$record->phone.'?text='.$encodedMessage;
                    })
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('pending')
                    ->visible(fn ($record) => $hasAutoConfirmation && $record->status === InvitationStatus::Declined)
                    ->label('Reactivar')
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->action(fn (Invitation $record) => $record->update(['status' => InvitationStatus::Pending])),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('confirm')
                        ->visible(fn ($record) => $hasAutoConfirmation && $record->status === InvitationStatus::Pending)
                        ->label('Marcar como confirmada')
                        ->icon('phosphor-check-circle-duotone')
                        ->requiresConfirmation()
                        ->action(fn (Invitation $record) => $record->update(['status' => InvitationStatus::Confirmed])),
                    Tables\Actions\Action::make('decline')
                        ->visible(fn ($record) => $hasAutoConfirmation && $record->status === InvitationStatus::Pending)
                        ->label('Marcar como declinada')
                        ->icon('phosphor-x-duotone')
                        ->requiresConfirmation()
                        ->action(fn (Invitation $record) => $record->update(['status' => InvitationStatus::Declined])),
                    Tables\Actions\EditAction::make()
                        ->modalWidth('xl')
                        ->form($this->getInvitationsFields())
                        ->closeModalByClickingAway(false)
                        ->slideOver()
                        ->mutateFormDataUsing(function (array $data): array {
                            $data['family'] = str($data['family'])->title();

                            return $data;
                        }),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ])
                    ->link()
                    ->label('Acciones'),
            ]);
    }

    public function getTabs(): array
    {
        return $this->record->hasFeaturesWithCode('COA') ? [
            'pending' => Tab::make(InvitationStatus::Pending->getLabel())
                ->badge(InvitationResource::getEloquentQuery()
                    ->where('status', InvitationStatus::Pending)
                    ->where('event_id', $this->record->id)
                    ->count()
                )
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvitationStatus::Pending)),
            'confirmed' => Tab::make(InvitationStatus::Confirmed->getLabel())
                ->badge(InvitationResource::getEloquentQuery()
                    ->where('status', InvitationStatus::Confirmed)
                    ->where('event_id', $this->record->id)
                    ->count()
                )
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvitationStatus::Confirmed)),
            'declined' => Tab::make(InvitationStatus::Declined->getLabel())
                ->badge(InvitationResource::getEloquentQuery()
                    ->where('status', InvitationStatus::Declined)
                    ->where('event_id', $this->record->id)
                    ->count()
                )
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InvitationStatus::Declined)),
        ] : [];
    }

    protected function getInvitationsFields(): array
    {
        return [
            Forms\Components\Grid::make()
                ->columnSpan('full')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('family')
                        ->label('Familia')
                        ->columnSpan('full')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->label('Número de celular')
                        ->numeric()
                        ->length(10)
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->columnSpan(2)
                        ->label('Correo electrónico')
                        ->email(),

                    Forms\Components\Repeater::make('guests')
                        ->relationship('guests')
                        ->label('Lista de invitados')
                        ->addActionLabel('Agregar invitado')
                        ->columnSpan('full')
                        ->columns(3)
                        ->required()
                        ->orderColumn(false)
                        ->defaultItems(1)
                        ->minItems(1)
                        ->collapsible()
                        ->collapsed()
                        ->simple(fn ($operation) => $operation == 'create' ?
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre')
                                ->columnSpan(3)
                                ->live(onBlur: true)
                                ->required()
                                ->maxLength(255) : null
                        )
                        ->schema(fn ($operation) => $operation == 'edit'
                            ? [Forms\Components\Group::make()
                                ->columnSpan('full')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->hiddenLabel()
                                        ->columnSpan(fn () => $this->record->hasFeaturesWithCode('COA') ? 2 : 3)
                                        ->live(onBlur: true)
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\ToggleButtons::make('confirmed')
                                        ->visible(fn ($operation) => $this->record->hasFeaturesWithCode('COA') && $operation == 'edit')
                                        ->hiddenLabel()
                                        ->default(false)
                                        ->boolean()
                                        ->grouped(),
                                ]),

                            ] : []
                        ),
                ]),
        ];
    }
}
