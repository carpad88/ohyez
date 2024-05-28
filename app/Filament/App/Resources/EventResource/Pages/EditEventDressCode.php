<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Enums\EventType;
use App\Models\Event;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;

class EditEventDressCode extends EditEventRecord
{
    protected static ?string $title = 'Código de vestimenta';

    protected static ?string $navigationIcon = 'heroicon-c-swatch';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Código de vestimenta')
                    ->description('Elige el código de vestimenta para tus invitados.')
                    ->statePath('content')
                    ->schema([
                        Forms\Components\Select::make('dressCode.code')
                            ->hiddenLabel()
                            ->options([
                                'formal' => 'Formal',
                                'etiquette' => 'Etiqueta',
                                'casual' => 'Casual',
                            ])
                            ->required(),
                    ]),

                Forms\Components\Section::make('Colores de vestimenta no permitidos')
                    ->description('Agrega los colores que están reservados para alguien específico.')
                    ->statePath('content')
                    ->schema([
                        Forms\Components\Toggle::make('dressCode.colors.visibility')
                            ->label('¿Mostrar sección de colores restringidos?')
                            ->live(),

                        Forms\Components\Repeater::make('dressCode.colors.items')
                            ->visible(fn (Forms\Get $get) => $get('dressCode.colors.visibility'))
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
