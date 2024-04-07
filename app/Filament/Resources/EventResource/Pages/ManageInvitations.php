<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Enums\InvitationStatus;
use App\Filament\Forms\InvitationForm;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\InvitationResource;
use App\Models\Invitation;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class ManageInvitations extends ManageRelatedRecords
{
    protected static string $resource = EventResource::class;

    protected static string $relationship = 'invitations';

    protected static ?string $title = 'Invitaciones';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            Actions\CreateAction::make()
                ->model(Invitation::class)
                ->form(InvitationForm::getFields())
                ->label('Agregar invitación')
                ->modalWidth('xl')
                ->slideOver()
                ->mutateFormDataUsing(function (array $data): array {
                    $uuid = str()->uuid()->toString();
                    $data['event_id'] = $this->record->id;
                    $data['code'] = $uuid;
                    $data['password'] = Hash::make($this->passwordFromUUID($uuid));

                    $data['family'] = str($data['family'])->title();
                    $data['guests'] = collect($data['guests'])
                        ->map(fn ($name) => [
                            'name' => str($name)->title()->toString(),
                            'confirmed' => null,
                            'id' => str()->random(4),
                        ])
                        ->toArray();

                    return $data;
                }),
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
            ->defaultGroup('table')
            ->groupingSettingsHidden()
            ->groups([
                Group::make('table')
                    ->label('Mesa'),
            ])
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
                            Tables\Columns\TextColumn::make('guests')
                                ->grow(false)
                                ->state(fn (Invitation $record) => count($record->guests).' personas')
                                ->color('warning')
                                ->badge(),
                            Tables\Columns\TextColumn::make('guests')
                                ->state(fn (Invitation $record) => collect($record->guests)
                                    ->map(fn (array $guest) => $guest['name'])
                                    ->join(', '))
                                ->listWithLineBreaks(),
                        ]),

                    ]),
            ])
            ->paginated([9, 18, 36, 72])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make('asd')
                    ->visible(fn () => auth()->user()->can('restore_invitation')),
            ])
            ->actions([
                Tables\Actions\Action::make('share')
                    ->hidden(fn ($record) => $record->status === InvitationStatus::Declined)
                    ->icon('heroicon-o-paper-airplane')
                    ->label('Compartir')
                    ->url(function (Invitation $record): string {
                        //                        $fullMessage = config('app.url').'/invitation/'.$record->code."\n\n";
                        //                        $fullMessage .= 'Hola, te comparto la invitación para mi celebración de XV años.'."\n\n";
                        //                        $fullMessage .= 'Tu código de acceso es:'."\n\n".'*'.self::passwordFromUUID($record->code).'*';
                        //
                        //                        $encodedMessage = urlencode($fullMessage);
                        //
                        //                        return 'https://wa.me/52'.$record->phone.'?text='.$encodedMessage;
                        return route('invitation.login',
                            [
                                'invitation' => $record->code,
                                'password' => self::passwordFromUUID($record->code),
                            ]
                        );
                    })
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('pending')
                    ->visible(fn ($record) => $record->status === InvitationStatus::Declined)
                    ->label('Reactivar')
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->action(fn (Invitation $record) => $record->update(['status' => InvitationStatus::Pending])),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->modalWidth('xl')
                        ->closeModalByClickingAway(false)
                        ->slideOver()
                        ->mutateFormDataUsing(function (array $data): array {
                            $data['family'] = str($data['family'])->title();
                            $data['guests'] = collect($data['guests'])
                                ->map(fn ($guest, $index) => [
                                    'name' => str($guest['name'])->title(),
                                    'confirmed' => $guest['confirmed'] ?? null,
                                    'id' => $guest['id'] ?? str()->random(4),
                                ])
                                ->toArray();

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

    public static function passwordFromUUID(string $uuid): string
    {
        return str(Arr::join(collect(explode('-', $uuid))
            ->map(fn ($section) => $section[3])
            ->toArray(), '')
        )->upper();
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
