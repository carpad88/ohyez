<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class EditEventSocials extends EditEventRecord
{
    protected static ?string $title = 'Redes sociales';

    protected static ?string $navigationIcon = 'phosphor-share-network-duotone';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Links a redes sociales')
                    ->description('Agrega vínculos a tus redes sociales.')
                    ->statePath('content')
                    ->schema([
                        Forms\Components\Repeater::make('socials')
                            ->hiddenLabel()
                            ->columns()
                            ->itemLabel(fn (array $state): ?string => str($state['red'])->title() ?? null)
                            ->maxItems(3)
                            ->collapsible()
                            ->schema([
                                Forms\Components\Select::make('red')
                                    ->label('Red social')
                                    ->live()
                                    ->options([
                                        'facebook' => 'Facebook',
                                        'instagram' => 'Instagram',
                                        'twitter' => 'Twitter',
                                        'youtube' => 'YouTube',
                                        'tiktok' => 'TikTok',
                                    ]),
                                Forms\Components\TextInput::make('hashtag')
                                    ->label('Hashtag')
                                    ->prefix('@')
                                    ->required(),
                                Forms\Components\TextInput::make('url')
                                    ->label('Link')
                                    ->prefixIcon('heroicon-c-globe-alt')
                                    ->url()
                                    ->columnSpan(2)
                                    ->required(),
                            ]),
                    ]),
            ]);
    }
}
