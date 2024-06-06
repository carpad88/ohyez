<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Enums\InvitationStatus;
use App\Filament\Admin\Forms\InvitationForm;
use App\Filament\App\Resources\EventResource;
use App\Filament\App\Resources\InvitationResource;
use App\Models\Invitation;
use Filament\Actions;
use Filament\Forms\Form;
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

    protected static ?string $navigationIcon = 'heroicon-c-rectangle-stack';

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
                ->form(InvitationForm::getFields())
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
                ->label('Descargar lista')
                ->icon('heroicon-o-document-arrow-down')
                ->url(fn () => route('event.invitations-list-pdf', [
                    'event' => $this->record->id,
                ]))
                ->openUrlInNewTab(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema(
                InvitationForm::getFields()
            );
    }

    public function table(Table $table): Table
    {
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
                            ->icon('heroicon-o-device-phone-mobile'),

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
                    ->icon('heroicon-o-paper-airplane')
                    ->label('Compartir')
                    ->url(function (Invitation $record): string {
                        if (app()->environment('local')) {
                            return route('invitation.login', ['invitation' => $record->uuid]);
                        }

                        $fullMessage = config('app.url').'/event/'.$this->record->code.'/invitation/'.$record->code."\n\n";
                        $fullMessage .= 'Hola, te comparto la invitación para mi celebración de XV años.'."\n\n";
                        $fullMessage .= 'Tu código de acceso es:'."\n\n".'*'.passwordFromUUID($record->code).'*';

                        $encodedMessage = urlencode($fullMessage);

                        return 'https://wa.me/52'.$record->phone.'?text='.$encodedMessage;
                    })
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('pending')
                    ->visible(fn ($record) => $record->status === InvitationStatus::Declined)
                    ->label('Reactivar')
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->action(fn (Invitation $record) => $record->update(['status' => InvitationStatus::Pending])),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('confirm')
                        ->visible(fn ($record) => $record->status === InvitationStatus::Pending)
                        ->label('Marcar como confirmada')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->action(fn (Invitation $record) => $record->update(['status' => InvitationStatus::Confirmed])),
                    Tables\Actions\Action::make('decline')
                        ->visible(fn ($record) => $record->status === InvitationStatus::Pending)
                        ->label('Marcar como declinada')
                        ->icon('heroicon-o-x-mark')
                        ->requiresConfirmation()
                        ->action(fn (Invitation $record) => $record->update(['status' => InvitationStatus::Declined])),
                    Tables\Actions\EditAction::make()
                        ->modalWidth('xl')
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
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->link()
                    ->label('Acciones'),
            ]);
    }

    public function getTabs(): array
    {
        return [
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
        ];
    }
}
