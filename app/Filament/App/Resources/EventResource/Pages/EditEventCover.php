<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Enums\EventType;
use App\Models\Event;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;

class EditEventCover extends EditEventRecord
{
    protected static ?string $title = 'Portada';

    protected static ?string $navigationIcon = 'phosphor-image-duotone';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Nombre de la quinceañera')
                    ->description('Es el nombre que se muestra en la portada de la invitación.')
                    ->statePath('content')
                    ->visible(fn (Event $record) => $record->event_type === EventType::XV)
                    ->schema([
                        Forms\Components\TextInput::make('cover.fifteen')
                            ->hiddenLabel()
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Nombre de los novios')
                    ->description('Los nombres que se muestran en la portada de la invitación.')
                    ->statePath('content')
                    ->visible(fn (Event $record) => $record->event_type === EventType::Wedding)
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('cover.bride')
                            ->label('Nombre de la novia')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('cover.groom')
                            ->label('Nombre del novio')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Archivos multimedia')
                    ->description('Puedes agregar archivos multimedia para personalizar la invitación.')
                    ->columns()
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->disk('events')
                            ->directory(fn (Event $record) => $record->code)
                            ->label('Logotipo')
                            ->image()
                            ->imageEditor(),
                        Forms\Components\FileUpload::make('music')
                            ->label('Música'),
                    ]),

                Forms\Components\Section::make('Mensaje de bienvenida')
                    ->description('Este mensaje se muestra inmediatamente después de la portada de la invitación.')
                    ->statePath('content')
                    ->columns()
                    ->schema([
                        Forms\Components\Toggle::make('welcome.visible')
                            ->label('¿Mostrar mensaje de bienvenida?')
                            ->columnSpan(2)
                            ->live(),
                        Forms\Components\Select::make('welcome.message_search')
                            ->label('Buscar mensaje')
                            ->hintIcon(
                                'heroicon-m-question-mark-circle',
                                tooltip: 'Puedes elegir une mensaje del catálogo o escribir uno nuevo.')
                            ->visible(fn (Forms\Get $get) => $get('welcome.visible'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $state ? $set('welcome.message', $state) : '')
                            ->getSearchResultsUsing(fn (string $search, Event $record): array => Message::query()
                                ->where('event_type', '=', $record->event_type)
                                ->limit(50)
                                ->pluck('content', 'content')
                                ->toArray()
                            ),
                        Forms\Components\Textarea::make('welcome.message')
                            ->label('Editar mensaje')
                            ->visible(fn (Forms\Get $get) => $get('welcome.visible'))
                            ->rows(5),
                    ]),

                Forms\Components\Section::make('Cuenta regresiva')
                    ->description('Está sección muestra el tiempo que falta hasta el día del evento.')
                    ->schema([
                        Forms\Components\Toggle::make('counter')
                            ->label('¿Mostrar cuenta regresiva?'),
                    ]),

            ]);
    }
}
