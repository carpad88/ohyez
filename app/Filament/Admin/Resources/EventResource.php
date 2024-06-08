<?php

namespace App\Filament\Admin\Resources;

use App\Enums\EventType;
use App\Models\Event;
use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'phosphor-confetti-duotone';

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
            ->columns()
            ->schema([
                Forms\Components\Section::make('Información General')
                    ->columnSpan(1)
                    ->columns(1)
                    ->schema([
                        Forms\Components\Select::make('event_type')
                            ->label(trans_choice('ohyez.eventType', 1))
                            ->options(collect(app(GeneralSettings::class)->event_types)
                                ->mapWithKeys(fn ($item) => [$item => __('ohyez.'.$item)])
                            )
                            ->required(),
                        Forms\Components\Select::make('tier')
                            ->label('Plan')
                            ->options((collect(app(GeneralSettings::class)->tiers))
                                ->mapWithKeys(fn ($item) => [$item['key'] => $item['name']])
                            )
                            ->required(),
                        Forms\Components\Select::make('user_id')
                            ->relationship(
                                name: 'host',
                                titleAttribute: 'name',
                            )
                            ->searchable(['name', 'email'])
                            ->label(trans_choice('ohyez.user', 1))
                            ->required(),
                    ]),

                Forms\Components\Section::make('Detalles del Evento')
                    ->columnSpan(1)
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título del evento')
                            ->required(),
                        Forms\Components\DatePicker::make('date')
                            ->label('Fecha')
                            ->native(false)
                            ->default(now()->addMonth()->format('Y-m-d'))
                            ->minDate(now()->format('Y-m-d'))
                            ->required(),
                        Forms\Components\TimePicker::make('time')
                            ->label('Hora')
                            ->native(false)
                            ->default('12:00')
                            ->seconds(false)
                            ->required(),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event_type')
                    ->label('Tipo')
                    ->badge(EventType::class),
                Tables\Columns\TextColumn::make('tier')
                    ->label('Plan')
                    ->description(fn ($record) => $record->template->name ?? 'Sin plantilla'),
                Tables\Columns\TextColumn::make('code')
                    ->label('ID')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Evento')
                    ->description(fn ($record) => $record->date?->format('d \d\e M, Y') ?? 'Sin fecha')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('host.name')
                    ->label('Anfitrión')
                    ->description(fn ($record) => $record->host->email)
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invitations_count')
                    ->counts('invitations')
                    ->badge()
                    ->label('Invitaciones')
                    ->description(fn ($record) => "{$record->guests->count()} personas")
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('preview')
                        ->icon('phosphor-devices-duotone')
                        ->url(
                            fn ($record) => route('event.preview', ['event' => $record->id]),
                            shouldOpenInNewTab: true
                        ),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ActionGroup::make([
                        Tables\Actions\DeleteAction::make(),
                        Tables\Actions\ForceDeleteAction::make(),
                        Tables\Actions\RestoreAction::make(),
                    ])->dropdown(false),
                ])->size(ActionSize::Large),
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
            'edit' => \App\Filament\App\Resources\EventResource\Pages\EditEvent::route('/{record}/edit'),
            'edit-template' => \App\Filament\App\Resources\EventResource\Pages\EditEventTemplate::route('/{record}/edit/template'),
            'edit-cover' => \App\Filament\App\Resources\EventResource\Pages\EditEventCover::route('/{record}/edit/cover'),
            'edit-mentions' => \App\Filament\App\Resources\EventResource\Pages\EditEventMentions::route('/{record}/edit/mentions'),
            'edit-locations' => \App\Filament\App\Resources\EventResource\Pages\EditEventLocations::route('/{record}/edit/locations'),
            'edit-dressCode' => \App\Filament\App\Resources\EventResource\Pages\EditEventDressCode::route('/{record}/edit/dress-code'),
            'edit-program' => \App\Filament\App\Resources\EventResource\Pages\EditEventProgram::route('/{record}/edit/program'),
            'edit-socials' => \App\Filament\App\Resources\EventResource\Pages\EditEventSocials::route('/{record}/edit/socials'),
            'edit-presents' => \App\Filament\App\Resources\EventResource\Pages\EditEventPresents::route('/{record}/edit/presents'),
            'edit-gallery' => \App\Filament\App\Resources\EventResource\Pages\EditEventGallery::route('/{record}/edit/gallery'),
            'edit-recommendations' => \App\Filament\App\Resources\EventResource\Pages\EditEventRecommendations::route('/{record}/edit/recommendations'),
            'edit-faqs' => \App\Filament\App\Resources\EventResource\Pages\EditEventFaqs::route('/{record}/edit/faqs'),
            'invitations' => \App\Filament\App\Resources\EventResource\Pages\ManageInvitations::route('/{record}/invitations'),
            'tables' => \App\Filament\App\Resources\EventResource\Pages\ManageTables::route('/{record}/tables'),
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
            \App\Filament\App\Resources\EventResource\Pages\EditEvent::class,
            \App\Filament\App\Resources\EventResource\Pages\ManageInvitations::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEvent::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEventTemplate::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEventCover::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEventMentions::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEventLocations::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEventDressCode::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEventProgram::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEventSocials::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEventPresents::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEventGallery::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEventRecommendations::class,
            \App\Filament\App\Resources\EventResource\Pages\EditEventFaqs::class,
            \App\Filament\App\Resources\EventResource\Pages\ManageInvitations::class,
            \App\Filament\App\Resources\EventResource\Pages\ManageTables::class,
        ]);
    }
}
