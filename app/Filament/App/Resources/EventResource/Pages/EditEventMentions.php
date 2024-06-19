<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Enums\EventType;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;

class EditEventMentions extends EditEventRecord
{
    protected static ?string $title = 'Menciones y agradecimientos';

    protected static ?string $navigationIcon = 'phosphor-users-duotone';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Padres de la quinceañera')
                    ->statePath('content.mentions')
                    ->visible(fn (Event $record) => $record->event_type === EventType::XV)
                    ->collapsible()
                    ->schema([
                        Forms\Components\Toggle::make('parents.fifteen.visible')
                            ->label('¿Mostrar nombres de los padres?')
                            ->live(),

                        Forms\Components\Group::make()
                            ->visible(fn (Forms\Get $get) => $get('parents.fifteen.visible'))
                            ->columns()
                            ->schema([
                                Forms\Components\TextInput::make('parents.fifteen.femaleName')
                                    ->label('Nombre de la madre')
                                    ->required(),
                                Forms\Components\TextInput::make('parents.fifteen.maleName')
                                    ->label('Nombre del padre')
                                    ->required(),
                            ]),

                    ]),

                Forms\Components\Section::make('Padres de la novia')
                    ->statePath('content.mentions')
                    ->visible(fn (Event $record) => $record->event_type === EventType::Wedding)
                    ->collapsible()
                    ->schema([
                        Forms\Components\Toggle::make('parents.bride.visible')
                            ->label('¿Mostrar nombres de los padres de la novia?')
                            ->live(),

                        Forms\Components\Group::make()
                            ->visible(fn (Forms\Get $get) => $get('parents.bride.visible'))
                            ->columns()
                            ->schema([
                                Forms\Components\TextInput::make('parents.bride.femaleName')
                                    ->label('Nombre de la madre')
                                    ->required(),
                                Forms\Components\TextInput::make('parents.bride.maleName')
                                    ->label('Nombre del padre')
                                    ->required(),
                            ]),

                    ]),

                Forms\Components\Section::make('Padres del novio')
                    ->statePath('content.mentions')
                    ->visible(fn (Event $record) => $record->event_type === EventType::Wedding)
                    ->collapsible()
                    ->schema([
                        Forms\Components\Toggle::make('parents.groom.visible')
                            ->label('¿Mostrar nombres de los padres del novio?')
                            ->live(),

                        Forms\Components\Group::make()
                            ->visible(fn (Forms\Get $get) => $get('parents.groom.visible'))
                            ->columns()
                            ->schema([
                                Forms\Components\TextInput::make('parents.groom.femaleName')
                                    ->label('Nombre de la madre')
                                    ->required(),
                                Forms\Components\TextInput::make('parents.groom.maleName')
                                    ->label('Nombre del padre')
                                    ->required(),
                            ]),

                    ]),

                Forms\Components\Section::make('Menciones y agradecimientos especiales')
                    ->description('Menciona los nombres de alguien a quien quieras agradecer, por ejemplo abuelos, familiares, padrinos de anillos, etcétera.')
                    ->statePath('content.mentions')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Toggle::make('special.visible')
                            ->label('¿Mostrar menciones especiales?')
                            ->live(),
                        Forms\Components\Repeater::make('special.relatives')
                            ->hiddenLabel()
                            ->visible(fn (Forms\Get $get) => $get('special.visible'))
                            ->addActionLabel('Agregar mención')
                            ->columns()
                            ->collapsible()
                            ->defaultItems(1)
                            ->itemLabel(fn (array $state): ?string => $state['relation'] ?? null)
                            ->schema([
                                Forms\Components\TextInput::make('relation')
                                    ->label('Parentesco o relación')
                                    ->live()
                                    ->columnSpan(2)
                                    ->required(),
                                Forms\Components\TextInput::make('her')
                                    ->label('Nombre de ella'),
                                Forms\Components\TextInput::make('him')
                                    ->label('Nombre de el'),
                            ]),
                    ]),

            ]);
    }
}
