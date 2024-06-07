<?php

namespace App\Filament\App\Resources\EventResource\Pages;

use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;

class EditEventLocations extends EditEventRecord
{
    protected static ?string $title = 'Ubicaciones';

    protected static ?string $navigationIcon = 'phosphor-map-pin-area-duotone';

    protected static ?string $navigationGroup = 'Secciones de la invitación';

    public function form(Form $form): Form
    {
        return $form
            ->extraAttributes([
                'class' => 'max-w-full',
            ])
            ->columns()
            ->schema([
                Forms\Components\Section::make('Detalles de la Recepción')
                    ->description('Agrega los detalles de la ubicación de donde se llevará a cabo la recepción.')
                    ->statePath('content.locations')
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\TextInput::make('reception.name')
                            ->label('Nombre del lugar')
                            ->required(),

                        Forms\Components\TextInput::make('reception.address')
                            ->prefixIcon('heroicon-c-map-pin')
                            ->label('Dirección')
                            ->required(),

                        Map::make('receptionLocation')
                            ->hiddenLabel()
                            ->mapControls([
                                'mapTypeControl' => false,
                                'scaleControl' => false,
                                'streetViewControl' => true,
                                'rotateControl' => false,
                                'fullscreenControl' => false,
                                'searchBoxControl' => false, // creates geocomplete field inside map
                                'zoomControl' => true,
                            ])
                            ->height(fn () => '400px') // map height (width is controlled by Filament options)
                            ->defaultZoom(15) // default zoom level when opening form
                            ->autocomplete('reception.address', countries: ['MX']) // field on form to use as Places geocompletion field
                            ->autocompleteReverse() // reverse geocode marker location to autocomplete field
                            ->defaultLocation([39.526610, -107.727261]) // default for new forms
                            ->clickable(),
                    ]),

                Forms\Components\Section::make('Detalles de la Ceremonia')
                    ->description('Agrega los detalles de la ubicación de donde se llevará a cabo la ceremonia.')
                    ->statePath('content.locations')
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\Toggle::make('ceremony.visibility')
                            ->label('¿Mostrar ubicación de la ceremonia?')
                            ->live(),

                        Forms\Components\Group::make()
                            ->visible(fn (Forms\Get $get) => $get('ceremony.visibility'))
                            ->schema([
                                Forms\Components\TextInput::make('ceremony.name')
                                    ->label('Nombre del lugar')
                                    ->required(),

                                Forms\Components\TextInput::make('ceremony.address')
                                    ->prefixIcon('heroicon-c-map-pin')
                                    ->label('Dirección')
                                    ->required(),

                                Map::make('ceremonyLocation')
                                    ->hiddenLabel()
                                    ->mapControls([
                                        'mapTypeControl' => false,
                                        'scaleControl' => false,
                                        'streetViewControl' => true,
                                        'rotateControl' => false,
                                        'fullscreenControl' => false,
                                        'searchBoxControl' => false, // creates geocomplete field inside map
                                        'zoomControl' => true,
                                    ])
                                    ->height(fn () => '400px') // map height (width is controlled by Filament options)
                                    ->defaultZoom(15) // default zoom level when opening form
                                    ->autocomplete('ceremony.address') // field on form to use as Places geocompletion field
                                    ->autocompleteReverse() // reverse geocode marker location to autocomplete field
                                    ->defaultLocation([39.526610, -107.727261]) // default for new forms
                                    ->clickable(),
                            ]),
                    ]),
            ]);
    }
}
