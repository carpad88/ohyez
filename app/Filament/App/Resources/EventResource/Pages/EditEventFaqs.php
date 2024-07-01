<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;

class EditEventFaqs extends EditEventRecord
{
    protected static ?string $title = 'Preguntas frecuentes';

    protected static ?string $navigationIcon = 'phosphor-question-duotone';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Preguntas frecuentes de tus invitados')
                    ->description('Anticipa posibles preguntas de tus invitados y dales una respuesta por adelantado.')
                    ->statePath('content.faqs')
                    ->schema([
                        Forms\Components\Toggle::make('visible')
                            ->columnSpan(2)
                            ->label('¿Mostrar preguntas frecuentes?')
                            ->live(),

                        Forms\Components\Repeater::make('items')
                            ->hiddenLabel()
                            ->visible(fn (Forms\Get $get) => $get('visible'))
                            ->addActionLabel('Agregar pregunta')
                            ->columns(1)
                            ->itemLabel(fn (array $state): ?string => str($state['question'])->title() ?? null)
                            ->maxItems(fn (Event $record) => $record->features()
                                ->whereIn('code', ['FA2', 'FA4', 'FAQ'])
                                ->first()->limit ?? 1)
                            ->collapsible()
                            ->schema([
                                Forms\Components\TextInput::make('question')
                                    ->label('Pregunta')
                                    ->live()
                                    ->debounce()
                                    ->required(),
                                Forms\Components\Textarea::make('answer')
                                    ->label('Respuesta')
                                    ->rows(3)
                                    ->required(),
                            ]),
                    ]),
            ]);
    }
}
