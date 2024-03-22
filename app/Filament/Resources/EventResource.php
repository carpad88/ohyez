<?php

namespace App\Filament\Resources;

use App\Enums\EventType;
use App\Filament\Forms\WeddingForm;
use App\Filament\Forms\XVForm;
use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return trans_choice('ohyez.event', 1);
    }

    public static function getPluralModelLabel(): string
    {
        return trans_choice('ohyez.event', 2);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Evento')
                        ->columns(3)
                        ->schema([
                            Forms\Components\Select::make('event_type')
                                ->label(trans_choice('ohyez.eventType', 1))
                                ->options(collect(app(GeneralSettings::class)->event_types)
                                    ->mapWithKeys(fn ($item) => [$item => __('ohyez.'.$item)])
                                )
                                ->live()
                                ->required()
                                ->afterStateUpdated(fn (Select $component) => $component
                                    ->getContainer()
                                    ->getParentComponent()
                                    ->getContainer()
                                    ->getComponents()[1]
                                    ->getContainer()
                                    ->getComponent('dynamicTypeFields')
                                    ->getChildComponentContainer()
                                    ->fill()
                                ),
                            Forms\Components\DatePicker::make('date')
                                ->default(now()->format('Y-m-d'))
                                ->required(),
                            Forms\Components\TextInput::make('title')
                                ->default(now()->format('h-i-s'))
                                ->required()
                                ->maxLength(255),
                        ]),
                    Forms\Components\Wizard\Step::make('Información de la Invitación')
                        ->schema([
                            Forms\Components\Group::make()
                                ->key('dynamicTypeFields')
                                ->schema(fn (Forms\Get $get) => match ($get('event_type')) {
                                    'wedding' => WeddingForm::getFields(),
                                    'xv' => XVForm::getFields(),
                                    default => [],
                                }),
                        ]),

                    Forms\Components\Wizard\Step::make('Diseño de la Invitación')
                        ->columns(3)
                        ->schema([
                            Forms\Components\Select::make('template_id')
                                ->relationship('template', 'name')
                                ->required(),
                            Forms\Components\Select::make('content.design.typography')
                                ->label('Tipografía')
                                ->options([
                                    'sans-serif' => 'Sans-serif',
                                    'serif' => 'Serif',
                                    'monospace' => 'Monospace',
                                ])
                                ->required(),
                            Forms\Components\Select::make('content.design.color')
                                ->label('Tipografía')
                                ->options([
                                    'black' => 'Black',
                                    'white' => 'White',
                                    'gray' => 'Gray',
                                    'red' => 'Red',
                                    'blue' => 'Blue',
                                    'green' => 'Green',
                                ])
                                ->required(),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('host.name')
                    ->description(fn ($record) => $record->host->email)
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_type')
                    ->badge(EventType::class)
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('template.name')
                    ->searchable(),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
