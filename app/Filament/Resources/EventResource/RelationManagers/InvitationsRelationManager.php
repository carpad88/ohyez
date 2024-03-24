<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Models\Invitation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class InvitationsRelationManager extends RelationManager
{
    protected static string $relationship = 'invitations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columnSpan('full')
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                    ])->schema([
                        Forms\Components\TextInput::make('family')
                            ->label('Familia')
                            ->columnSpan('full')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Número de celular')
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 1,
                            ])
                            ->numeric()
//                    ->length(10)
                            ->required(),
                        Forms\Components\TextInput::make('table')
                            ->label('Mesa')
                            ->numeric(),

                        Forms\Components\Repeater::make('guests')
                            ->label('Lista de invitados')
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
                                ? [
                                    Forms\Components\Fieldset::make()
                                        ->columns(3)
                                        ->schema([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Nombre')
                                                ->columnSpan(2)
                                                ->live(onBlur: true)
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\ToggleButtons::make('confirmed')
                                                ->visible(fn ($operation) => $operation == 'edit')
                                                ->label('¿Confirmado?')
                                                ->boolean()
                                                ->grouped(),
                                        ]),

                                ] : []
                            ),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('family')
            ->columns([
                Tables\Columns\Layout\Grid::make([
                    'sm' => 1,
                ])
                    ->schema([
                        Tables\Columns\TextColumn::make('family')
                            ->weight(FontWeight::Bold)
                            ->color('primary')
                            ->size(Tables\Columns\TextColumn\TextColumnSize::Large),
                        Tables\Columns\TextColumn::make('phone')
                            ->icon('heroicon-c-phone'),

                        Tables\Columns\Layout\Split::make([
                            Tables\Columns\TextColumn::make('table')
                                ->grow(false)
                                ->color('gray')
                                ->prefix('Mesa ')
                                ->badge(),
                            Tables\Columns\TextColumn::make('guests')
                                ->state(fn (Invitation $record) => count($record->guests).' personas')
                                ->color('warning')
                                ->badge(),
                        ]),

                        Tables\Columns\TextColumn::make('guests')
                            ->state(fn (Invitation $record) => collect($record->guests)
                                ->map(fn (array $guest) => $guest['name'])
                                ->join(', '))
                            ->listWithLineBreaks(),
                    ]),
            ])
            ->contentGrid([
                'md' => 3,
                'xl' => 4,
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->visible(fn () => auth()->user()->can('force_delete_invitation')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalWidth('xl')
                    ->mutateFormDataUsing(function (array $data): array {
                        $uuid = str()->uuid()->toString();
                        $data['code'] = $uuid;
                        $data['password'] = Hash::make($this->passwordFromUUID($uuid));

                        $data['family'] = str($data['family'])->title();
                        $data['guests'] = collect($data['guests'])
                            ->map(fn ($name) => [
                                'name' => str($name)->title()->toString(),
                                'confirmed' => null,
                            ])
                            ->toArray();

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('xl')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['family'] = str($data['family'])->title();
                        $data['guests'] = collect($data['guests'])
                            ->map(fn ($guest) => [
                                'name' => str($guest['name'])->title(),
                                'confirmed' => $guest['confirmed'] ?? null,
                            ])
                            ->toArray();

                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('share')
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
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                //                Tables\Actions\BulkActionGroup::make([
                //                    Tables\Actions\DeleteBulkAction::make(),
                //                    Tables\Actions\RestoreBulkAction::make(),
                //                    Tables\Actions\ForceDeleteBulkAction::make(),
                //                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }

    public static function passwordFromUUID(string $uuid): string
    {
        return str(Arr::join(collect(explode('-', $uuid))
            ->map(fn ($section) => $section[3])
            ->toArray(), '')
        )->upper();
    }
}
