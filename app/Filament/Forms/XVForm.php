<?php

namespace App\Filament\Forms;

use App\Models\Message;
use Filament\Forms;

class XVForm
{
    public static function getFields(): array
    {
        return [
            Forms\Components\Group::make()
                ->statePath('content')
                ->schema([
                    Forms\Components\Fieldset::make('Portada')
                        ->columns()
                        ->schema([
                            Forms\Components\TextInput::make('welcome.name')
                                ->label('Nombre de la quinceañera')
                                ->default('asdsada')
                                ->required()
                                ->maxLength(255),
                        ]),

                    Forms\Components\Section::make('Mensaje de bienvenida')
                        ->columns(3)
                        ->collapsible()
                        ->schema([
                            Forms\Components\ToggleButtons::make('welcome.visible')
                                ->label('¿Mostrar mensaje de bienvenida?')
                                ->live()
                                ->default(true)
                                ->boolean()
                                ->inline(),
                            Forms\Components\Select::make('welcome.message')
                                ->label('Buscar mensaje')
                                ->columnSpan(2)
                                ->disabled(fn (Forms\Get $get) => ! $get('welcome.visible'))
                                ->searchable()
                                ->live()
                                ->dehydrated()
                                ->getSearchResultsUsing(fn (string $search): array => Message::where('event_type', 'like', 'xv')
                                    ->limit(50)
                                    ->pluck('content', 'content')
                                    ->toArray()
                                ),
                        ]),

                    Forms\Components\Section::make('Padres')
                        ->columns(4)
                        ->collapsible()
                        ->schema([
                            Forms\Components\ToggleButtons::make('parents.visible')
                                ->label('¿Mostrar nombres de los padres?')
                                ->live()
                                ->default(true)
                                ->boolean()
                                ->inline(),
                            Forms\Components\Group::make()
                                ->columnSpan(3)
                                ->columns()
                                ->disabled(fn (Forms\Get $get) => ! $get('parents.visible'))
                                ->schema([
                                    Forms\Components\TextInput::make('parents.mother')
                                        ->label('Nombre de la mamá')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('parents.father')
                                        ->label('Nombre del papá')
                                        ->maxLength(255),
                                ]),
                        ]),

                    Forms\Components\Section::make('Padrinos')
                        ->columns(4)
                        ->collapsible()
                        ->schema([
                            Forms\Components\ToggleButtons::make('godparents.visible')
                                ->label('¿Mostrar nombres de los padres?')
                                ->live()
                                ->default(true)
                                ->boolean()
                                ->inline(),
                            Forms\Components\Group::make()
                                ->columnSpan(3)
                                ->columns()
                                ->disabled(fn (Forms\Get $get) => ! $get('godparents.visible'))
                                ->schema([
                                    Forms\Components\TextInput::make('godparents.mother')
                                        ->label('Nombre de la madrina')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('godparents.father')
                                        ->label('Nombre del padrino')
                                        ->maxLength(255),
                                ]),
                        ]),
                ]),
        ];
    }
}
