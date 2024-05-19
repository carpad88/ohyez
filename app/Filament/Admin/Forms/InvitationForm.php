<?php

namespace App\Filament\Admin\Forms;

use Filament\Forms;

class InvitationForm
{
    public static function getFields(): array
    {
        return [
            Forms\Components\Grid::make()
                ->columnSpan('full')
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                ])->schema([
                    Forms\Components\TextInput::make('family')
                        ->label('Familia')
                        ->columnSpan('full')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->label('Número de celular')
                        ->columnSpan([
                            'sm' => 2,
                            'md' => 1,
                        ])
                        ->numeric()
                        ->length(10)
                        ->required(),
                    Forms\Components\TextInput::make('table')
                        ->label('Mesa')
                        ->numeric(),

                    Forms\Components\Repeater::make('guests')
                        ->label('Lista de invitados')
                        ->columnSpan('full')
                        ->columns(3)
                        ->required()
                        ->orderColumn(false)
                        ->defaultItems(1)
                        ->minItems(1)
                        ->collapsible()
                        ->collapsed()
                        ->simple(fn ($operation) => $operation == 'create' ?
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre')
                                ->columnSpan(3)
                                ->live(onBlur: true)
                                ->required()
                                ->maxLength(255) : null
                        )
                        ->schema(fn ($operation) => $operation == 'edit'
                            ? [Forms\Components\Group::make()
                                ->columnSpan('full')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label('')
                                        ->columnSpan(2)
                                        ->live(onBlur: true)
                                        ->required()
                                        ->markAsRequired(false)
                                        ->maxLength(255),
                                    Forms\Components\ToggleButtons::make('confirmed')
                                        ->visible(fn ($operation) => $operation == 'edit')
                                        ->label('')
                                        ->boolean()
                                        ->grouped(),
                                ]),

                            ] : []
                        ),
                ]),
        ];
    }
}
