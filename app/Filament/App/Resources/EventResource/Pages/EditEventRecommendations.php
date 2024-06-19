<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class EditEventRecommendations extends EditEventRecord
{
    protected static ?string $title = 'Recomendaciones';

    protected static ?string $navigationIcon = 'phosphor-thumbs-up-duotone';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Recomendaciones para tus invitados')
                    ->description('Agrega recomendaciones de lugares como hoteles, estéticas, restaurantes, etcétera.')
                    ->statePath('content.recommendations')
                    ->schema([
                        Forms\Components\Toggle::make('visible')
                            ->columnSpan(2)
                            ->label('¿Mostrar recomendaciones?')
                            ->live(),

                        Forms\Components\Repeater::make('items')
                            ->hiddenLabel()
                            ->visible(fn (Forms\Get $get) => $get('visible'))
                            ->addActionLabel('Agregar recomendación')
                            ->columns()
                            ->itemLabel(fn (array $state): ?string => str($state['name'])->title() ?? null)
                            ->maxItems(3)
                            ->collapsible()
                            ->schema([
                                Forms\Components\TextInput::make('place')
                                    ->label('Tipo de lugar')
                                    ->required(),
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre del lugar')
                                    ->required(),
                                Forms\Components\TextInput::make('address')
                                    ->label('Dirección')
                                    ->columnSpan(2)
                                    ->required(),
                                Forms\Components\TextInput::make('map')
                                    ->label('Link de Google Maps')
                                    ->url()
                                    ->columnSpan(2)
                                    ->required(),
                            ]),
                    ]),
            ]);
    }
}
