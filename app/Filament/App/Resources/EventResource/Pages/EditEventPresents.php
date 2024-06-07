<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class EditEventPresents extends EditEventRecord
{
    protected static ?string $title = 'Mesas de regalos';

    protected static ?string $navigationIcon = 'heroicon-c-gift';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos para depósito bancario')
                    ->description('Agrega los datos para que tu regalo lo hagan por medio de un depósito.')
                    ->statePath('content.presents.account')
                    ->columns()
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('bank')
                            ->label('Nombre del banco')
                            ->required(),
                        Forms\Components\TextInput::make('card')
                            ->label('Número de tarjeta')
                            ->numeric()
                            ->length(16)
                            ->required(),
                        Forms\Components\TextInput::make('beneficiary')
                            ->label('Nombre del beneficiario')
                            ->columnSpan(2)
                            ->required(),

                    ]),

                Forms\Components\Section::make('Links a mesas de regalo')
                    ->description('Agrega los vínculos a tus mesas de regalos.')
                    ->statePath('content')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Repeater::make('presents.items')
                            ->hiddenLabel()
                            ->columns(3)
                            ->itemLabel(fn (array $state): ?string => str($state['item'])->title() ?? null)
                            ->collapsible()
                            ->schema([
                                Forms\Components\TextInput::make('item')
                                    ->label('Tienda o lugar')
                                    ->live()
                                    ->required(),
                                Forms\Components\TextInput::make('url')
                                    ->label('Link')
                                    ->prefixIcon('heroicon-c-globe-alt')
                                    ->url()
                                    ->columnSpan(2)
                                    ->required(),
                            ])
                            ->required(),
                    ]),

                Forms\Components\Section::make('Sección con mensaje para regalo o sobres')
                    ->description('Está sección muestra un mensaje para que tus invitados te dejen un regalo o un sobre el día del evento.')
                    ->statePath('content.presents')
                    ->schema([
                        Forms\Components\Toggle::make('envelope')
                            ->label('¿Quieres mostrar la sección con mensaje para regalo o sobres?'),
                    ]),
            ]);
    }
}
