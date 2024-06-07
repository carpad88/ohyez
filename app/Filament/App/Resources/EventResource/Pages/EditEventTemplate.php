<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Models\Template;
use Filament\Forms;
use Filament\Forms\Form;

class EditEventTemplate extends EditEventRecord
{
    protected static ?string $title = 'Plantilla de invitación';

    protected static ?string $navigationIcon = 'heroicon-c-squares-2x2';

    public function form(Form $form): Form
    {
        return $form
            ->extraAttributes([
                'class' => 'max-w-full',
            ])
            ->schema([
                Forms\Components\Section::make('Plantilla de la invitación')
                    ->description('Elige el diseño de la invitación que más te guste.')
                    ->schema([
                        Forms\Components\ViewField::make('template_id')
                            ->view('filament.app.forms.components.templates')
                            ->viewData([
                                'templates' => Template::where('event_type', '=', $this->getRecord()->event_type)->get(),
                            ]),
                    ]),

            ]);
    }
}
