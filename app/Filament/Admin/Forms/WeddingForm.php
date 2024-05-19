<?php

namespace App\Filament\Admin\Forms;

use Filament\Forms;

class WeddingForm
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
                            Forms\Components\TextInput::make('cover.bride')
                                ->label('Nombre de la novia')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('cover.groom')
                                ->label('Nombre del novio')
                                ->required()
                                ->maxLength(255),
                        ]),
                ]),

        ];
    }
}
