<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageGeneralSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    protected static ?string $title = 'Configuración general';

    protected static ?string $navigationLabel = 'Configuración general';

    protected static ?string $navigationGroup = 'Configuraciones';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tipos de evento')
                    ->schema([
                        Forms\Components\Repeater::make('event_types')
                            ->label('')
                            ->addActionLabel('Agregar tipo de evento')
                            ->simple(
                                Forms\Components\TextInput::make('event_type')
                                    ->required()
                            ),
                    ]),
            ]);
    }
}
