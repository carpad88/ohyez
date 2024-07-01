<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class EditEventDressCode extends EditEventRecord
{
    protected static ?string $title = 'Código de vestimenta';

    protected static ?string $navigationIcon = 'phosphor-dress-duotone';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public static function canAccess(array $parameters = []): bool
    {
        return $parameters['record']->hasFeaturesWithCode('DRE');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Código de vestimenta')
                    ->description('Elige el código de vestimenta para tus invitados.')
                    ->statePath('content')
                    ->schema([
                        Forms\Components\Toggle::make('dressCode.visible')
                            ->label('¿Mostrar sección de código de vestimenta?')
                            ->live(),

                        Forms\Components\Select::make('dressCode.code')
                            ->hiddenLabel()
                            ->options([
                                'Formal' => 'Formal',
                                'Etiqueta' => 'Etiqueta',
                                'Casual' => 'Casual',
                            ])
                            ->required(),
                    ]),

                Forms\Components\Section::make('Colores de vestimenta no permitidos')
                    ->description('Agrega los colores que están reservados para alguien específico.')
                    ->statePath('content')
                    ->visible(fn (Forms\Get $get) => $get('content.dressCode.visible'))
                    ->schema([
                        Forms\Components\Toggle::make('dressCode.colors.visible')
                            ->label('¿Mostrar sección de colores restringidos?')
                            ->live(),

                        Forms\Components\Repeater::make('dressCode.colors.items')
                            ->visible(fn (Forms\Get $get) => $get('dressCode.colors.visible'))
                            ->hiddenLabel()
                            ->simple(
                                Forms\Components\TextInput::make('item')
                                    ->hiddenLabel()
                                    ->required(),
                            )
                            ->required(),
                    ]),
            ]);
    }
}
