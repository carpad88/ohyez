<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class EditEventFaqs extends EditEventRecord
{
    protected static ?string $title = 'Preguntas frecuentes';

    protected static ?string $navigationIcon = 'heroicon-c-question-mark-circle';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Preguntas frecuentes de tus invitados')
                    ->description('Anticipa posibles preguntas de tus invitados y dales una respuesta por adelantado.')
                    ->statePath('content')
                    ->schema([
                        Forms\Components\Repeater::make('faqs')
                            ->hiddenLabel()
                            ->addActionLabel('Agregar pregunta')
                            ->columns(1)
                            ->itemLabel(fn (array $state): ?string => str($state['question'])->title() ?? null)
                            ->maxItems(3)
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
