<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'phosphor-barcode-duotone';

    protected static ?string $navigationGroup = 'Catálogo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General')
                    ->collapsible()
                    ->columns()
                    ->schema([
                        Forms\Components\Toggle::make('active')
                            ->label('Activo')
                            ->inline(false)
                            ->visibleOn('edit'),
                        Forms\Components\ToggleButtons::make('bundle')
                            ->label('Tipo')
                            ->options([
                                true => 'Bundle',
                                false => 'Single',
                            ])
                            ->default(true)
                            ->grouped(),

                        Forms\Components\Group::make()
                            ->columnSpan('full')
                            ->columns()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre')
                                    ->required(),
                                Forms\Components\TextInput::make('default_price_amount')
                                    ->label('Precio')
                                    ->formatStateUsing(fn ($state) => $state / 100)
                                    ->numeric()
                                    ->required(),
                            ]),

                        Forms\Components\Textarea::make('description')
                            ->columnSpan('full')
                            ->label('Descripción')
                            ->rows(3),
                    ]),

                Forms\Components\Section::make('Metadata')
                    ->collapsed()
                    ->schema([
                        Forms\Components\KeyValue::make('metadata')
                            ->hiddenLabel()
                            ->columnSpan('full'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->orderBy('default_price_amount', 'asc'))
            ->columns([
                Tables\Columns\IconColumn::make('active')
                    ->width('1%')
                    ->alignCenter()
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('bundle')
                    ->label('Type')
                    ->width('1%')
                    ->alignCenter()
                    ->boolean()
                    ->trueIcon('phosphor-package-duotone')
                    ->falseIcon('phosphor-number-circle-one-duotone')
                    ->trueColor('primary')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('features_count')
                    ->label('Features')
                    ->alignCenter()
                    ->badge()
                    ->counts('features'),
                Tables\Columns\TextColumn::make('default_price_amount')
                    ->money('mxn', divideBy: 100)
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FeaturesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
