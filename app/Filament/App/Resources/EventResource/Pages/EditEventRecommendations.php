<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class EditEventRecommendations extends EditEventRecord
{
    protected static ?string $title = 'Recomendaciones';

    protected static ?string $navigationIcon = 'heroicon-c-hand-thumb-up';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Recomendaciones para tus invitados')
                    ->description('Agrega recomendaciones de lugares como hoteles, estéticas, restaurantes, etcétera.')
                    ->statePath('content')
                    ->schema([
                        Forms\Components\Repeater::make('recommendations')
                            ->hiddenLabel()
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
