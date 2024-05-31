<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\EventResource\Pages;
use App\Models\Event;
use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
            ->extraAttributes([
                'class' => 'max-w-3xl',
            ])
            ->schema([
                Forms\Components\Section::make('Información del evento')
                    ->description('Elige el tipo de evento y proporciona los detalles necesarios.')
                    ->columns()
                    ->schema([
                        Forms\Components\Select::make('event_type')
                            ->label(trans_choice('ohyez.eventType', 1))
                            ->required()
                            ->options(collect(app(GeneralSettings::class)->event_types)
                                ->mapWithKeys(fn ($item) => [$item => __('ohyez.'.$item)])
                            ),
                        Forms\Components\TextInput::make('title')
                            ->label('Título del evento')
                            ->required(),

                        Forms\Components\DatePicker::make('date')
                            ->label('Fecha')
                            ->native(false)
                            ->default(now()->format('Y-m-d'))
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tier'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'edit' => Pages\EditEvent::route('/{record}/edit'),
            'edit-template' => Pages\EditEventTemplate::route('/{record}/edit/template'),
            'edit-cover' => Pages\EditEventCover::route('/{record}/edit/cover'),
            'edit-mentions' => Pages\EditEventMentions::route('/{record}/edit/mentions'),
            'edit-locations' => Pages\EditEventLocations::route('/{record}/edit/locations'),
            'edit-dressCode' => Pages\EditEventDressCode::route('/{record}/edit/dress-code'),
            'edit-program' => Pages\EditEventProgram::route('/{record}/edit/program'),
            'edit-socials' => Pages\EditEventSocials::route('/{record}/edit/socials'),
            'edit-presents' => Pages\EditEventPresents::route('/{record}/edit/presents'),
            'edit-gallery' => Pages\EditEventGallery::route('/{record}/edit/gallery'),
            'edit-recommendations' => Pages\EditEventRecommendations::route('/{record}/edit/recommendations'),
            'edit-faqs' => Pages\EditEventFaqs::route('/{record}/edit/faqs'),
            'invitations' => Pages\ManageInvitations::route('/{record}/invitations'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditEvent::class,
            Pages\EditEventTemplate::class,
            Pages\EditEventCover::class,
            Pages\EditEventMentions::class,
            Pages\EditEventLocations::class,
            Pages\EditEventDressCode::class,
            Pages\EditEventProgram::class,
            Pages\EditEventSocials::class,
            Pages\EditEventPresents::class,
            Pages\EditEventGallery::class,
            Pages\EditEventRecommendations::class,
            Pages\EditEventFaqs::class,
            Pages\ManageInvitations::class,
        ]);
    }
}
