<?php

namespace App\Filament\Admin\Resources;

use App\Models\Template;
use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $navigationIcon = 'phosphor-blueprint-duotone';

    public static function getModelLabel(): string
    {
        return trans_choice('ohyez.template', 1);
    }

    public static function getPluralModelLabel(): string
    {
        return trans_choice('ohyez.template', 2);
    }

    public static function getNavigationGroup(): ?string
    {
        return trans_choice('ohyez.content', 2);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Select::make('event_type')
                    ->options(collect(app(GeneralSettings::class)->event_types)
                        ->mapWithKeys(fn ($item) => [$item => __('ohyez.'.$item)])
                    )
                    ->required(),
                Forms\Components\TextInput::make('view')
                    ->required(),
                Forms\Components\Group::make()
                    ->columns()
                    ->schema([
                        Forms\Components\ToggleButtons::make('is_public')
                            ->boolean()
                            ->grouped()
                            ->default(true),
                        Forms\Components\ToggleButtons::make('is_active')
                            ->boolean()
                            ->grouped()
                            ->default(true),
                    ]),
                Forms\Components\FileUpload::make('cover')
                    ->visibleOn('edit')
                    ->disk('templates')
                    ->directory(fn (Template $record) => $record->id)
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event_type')
                    ->formatStateUsing(fn ($state) => __('ohyez.'.$state))
                    ->badge(),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\IconColumn::make('is_public')
                    ->alignCenter()
                    ->boolean()
                    ->trueIcon('phosphor-eye-duotone')
                    ->falseIcon('phosphor-eye-closed-duotone')
                    ->trueColor('primary')
                    ->falseColor('gray'),
                Tables\Columns\IconColumn::make('is_active')
                    ->alignCenter()
                    ->boolean()
                    ->trueColor('primary')
                    ->falseColor('gray'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('md'),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Admin\Resources\TemplateResource\Pages\ManageTemplates::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
