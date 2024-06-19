<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class EditEventProgram extends EditEventRecord
{
    protected static ?string $title = 'Programa';

    protected static ?string $navigationIcon = 'phosphor-clock-countdown-duotone';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Programa del evento')
                    ->description('Agrega las actividades con horario para el evento.')
                    ->statePath('content')
                    ->schema([
                        Forms\Components\Toggle::make('program.visible')
                            ->label('¿Mostrar programa del evento?')
                            ->live(),

                        Forms\Components\Repeater::make('program.items')
                            ->hiddenLabel()
                            ->visible(fn (Forms\Get $get) => $get('program.visible'))
                            ->columns()
                            ->itemLabel(fn (array $state): ?string => $state['item'] ?? null)
                            ->collapsible()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Actividad')
                                    ->live()
                                    ->required(),
                                Forms\Components\TimePicker::make('time')
                                    ->label('Hora')
                                    ->native(false)
                                    ->seconds(false)
                                    ->required(),
                            ])
                            ->required(),
                    ]),
            ]);
    }
}
