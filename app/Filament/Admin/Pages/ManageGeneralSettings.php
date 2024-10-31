<?php

namespace App\Filament\Admin\Pages;

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
        return auth()->user()?->can('page_ManageGeneralSettings') ?? false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tipos de evento')
                    ->columnSpan(1)
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
