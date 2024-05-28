<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Enums\EventType;
use App\Models\Event;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;

class EditEventProgram extends EditEventRecord
{
    protected static ?string $title = 'Programa';

    protected static ?string $navigationIcon = 'heroicon-c-clock';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Programa del evento')
                    ->description('Agrega las actividades con horario para el evento.')
                    ->statePath('content')
                    ->schema([
                        Forms\Components\Repeater::make('program.items')
                            ->hiddenLabel()
                            ->columns()
                            ->itemLabel(fn (array $state): ?string => $state['item'] ?? null)
                            ->collapsible()
                            ->schema([
                                Forms\Components\TextInput::make('item')
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
