<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;

class EditEventGallery extends EditEventRecord
{
    protected static ?string $title = 'Galería de fotos';

    protected static ?string $navigationIcon = 'phosphor-camera-duotone';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->extraAttributes([
                'class' => 'max-w-full',
            ])
            ->schema([
                Forms\Components\Section::make('Imágenes para mostar en la galería')
                    ->description('Agrega las imágenes que quieras mostrar en la gallería.')
                    ->statePath('content')
                    ->columns()
                    ->collapsible()
                    ->schema([
                        Forms\Components\FileUpload::make('gallery')
                            ->hiddenLabel()
                            ->columnSpan(2)
                            ->panelLayout('grid')
                            ->multiple()
                            ->reorderable()
                            ->directory(fn (Event $record) => $record->code)
                            ->image()
                            ->imageEditor()
                            ->appendFiles()
                            ->required(),

                    ]),
            ]);
    }
}
