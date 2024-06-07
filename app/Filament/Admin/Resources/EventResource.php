<?php

namespace App\Filament\Admin\Resources;

use App\Enums\EventType;
use App\Filament\Admin\Forms\WeddingForm;
use App\Filament\Admin\Forms\XVForm;
use App\Models\Event;
use App\Models\Template;
use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';

    protected static ?string $activeNavigationIcon = 'heroicon-c-cake';

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
                                    //                                    ->getContainer()
                                    //                                    ->getParentComponent()
                                    //                                    ->getContainer()
                                    //                                    ->getComponents()[1]
                                    //                                    ->getContainer()
                                    //                                    ->getComponent('dynamicTypeFields')
                                    //                                    ->getChildComponentContainer()
                                    //                                    ->fill()
                                ),
                            //                            Forms\Components\DatePicker::make('date')
                            //                                ->disabled(fn ($operation) => $operation === 'edit')
                            //                                ->native(false)
                            //                                ->default(now()->format('Y-m-d'))
                            //                                ->minDate(now()->format('Y-m-d'))
                            //                                ->required(),
                            Forms\Components\TimePicker::make('time')
                                ->native(false)
                                ->default('12:00')
//                                ->minutesStep(15)
                                ->seconds(false)
                                ->required(),
                            Forms\Components\TextInput::make('title')
                                ->default(now()->format('h-i-s'))
                                ->required()
                                ->maxLength(255),
                        ]),
                    //                    Forms\Components\Wizard\Step::make('Información de la Invitación')
                    //                        ->schema([
                    //                            Forms\Components\Group::make()
                    //                                ->key('dynamicTypeFields')
                    //                                ->schema(fn (Forms\Get $get) => match ($get('event_type')) {
                    //                                    'wedding' => WeddingForm::getFields(),
                    //                                    'xv' => XVForm::getFields(),
                    //                                    default => [],
                    //                                }),
                    //                        ]),

                    //                    Forms\Components\Wizard\Step::make('Diseño de la Invitación')
                    //                        ->columns(3)
                    //                        ->schema([
                    //                            Forms\Components\Select::make('template_id')
                    //                                ->options(fn (Forms\Get $get): array => Template::whereEventType($get('event_type'))
                    //                                    ->pluck('name', 'id')
                    //                                    ->toArray()
                    //                                ),
                    //                            Forms\Components\Select::make('content.design.typography')
                    //                                ->label('Tipografía')
                    //                                ->options([
                    //                                    'sans-serif' => 'Sans-serif',
                    //                                    'serif' => 'Serif',
                    //                                    'monospace' => 'Monospace',
                    //                                ])
                    //                                ->required(),
                    //                            Forms\Components\Select::make('content.design.color')
                    //                                ->label('Tipografía')
                    //                                ->options([
                    //                                    'black' => 'Black',
                    //                                    'white' => 'White',
                    //                                    'gray' => 'Gray',
                    //                                    'red' => 'Red',
                    //                                    'blue' => 'Blue',
                    //                                    'green' => 'Green',
                    //                                ])
                    //                                ->required(),
                    //                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = auth()->user();

        return $table
            ->modifyQueryUsing(fn ($query) => $query->when(
                $user->hasRole('super_admin'),
                fn ($query) => $query,
                fn ($query) => $query->whereUserId($user->id)
            ))
            ->columns([
                Tables\Columns\TextColumn::make('event_type')
                    ->label('Tipo de evento')
                    ->badge(EventType::class)
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Evento')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('host.name')
                    ->label('Anfitrión')
                    ->description(fn ($record) => $record->host->email)
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('template.name')
                    ->label('Plantilla')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->icon('heroicon-c-arrow-top-right-on-square')
                    ->iconButton(),
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-c-pencil')
                    ->iconButton(),
                Tables\Actions\Action::make('invitations')
                    ->label('Invitaciones')
                    ->icon('heroicon-c-rectangle-stack')
                    ->iconButton()
                    ->url(fn ($record) => EventResource::getUrl('invitations', ['record' => $record])),
                Tables\Actions\Action::make('attendance')
                    ->label('Asistencia')
                    ->icon('heroicon-c-qr-code')
                    ->iconButton()
                    ->url(fn ($record) => EventResource::getUrl('attendance', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Admin\Resources\EventResource\Pages\ListEvents::route('/'),
            'create' => \App\Filament\Admin\Resources\EventResource\Pages\CreateEvent::route('/create'),
            'edit' => \App\Filament\Admin\Resources\EventResource\Pages\EditEvent::route('/{record}/edit'),
            'invitations' => \App\Filament\Admin\Resources\EventResource\Pages\ManageInvitations::route('/{record}/invitations'),
            'attendance' => \App\Filament\Admin\Resources\EventResource\Pages\ManageAttendance::route('/{record}/attendance'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            \App\Filament\Admin\Resources\EventResource\Pages\EditEvent::class,
            \App\Filament\Admin\Resources\EventResource\Pages\ManageInvitations::class,
            \App\Filament\Admin\Resources\EventResource\Pages\ManageAttendance::class,
        ]);
    }
}
