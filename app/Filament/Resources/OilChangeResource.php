<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OilChangeResource\Pages;
use App\Filament\Resources\OilChangeResource\RelationManagers;
use App\Models\OilChange;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OilChangeResource extends Resource
{
    protected static ?string $model = OilChange::class;
    protected static ?string $navigationGroup = 'Tour Items';

    protected static ?string $navigationParentItem = 'Транспорт';
    protected static ?string $navigationLabel = 'Замена Масла';
    protected static ?string $modelLabel = 'Замена Масла';
    protected static ?string $pluralModelLabel = 'Замены Масла';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('transport_id')
                    ->relationship('transport', 'plate_number')
                    ->required()
                    ->preload(),
                Forms\Components\DatePicker::make('oil_change_date')
                    ->required(),
                Forms\Components\TextInput::make('mileage_at_change')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('cost')
                    ->numeric()
                    ->default(null)
                    ->prefix('UZS'),
                Forms\Components\TextInput::make('oil_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('service_center')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('other_services')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('next_change_date'),
                Forms\Components\TextInput::make('next_change_mileage')
                    ->numeric()
                    ->default(null),
                // Forms\Components\TextInput::make('oil_cost')
                //     ->numeric()
                //     ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transport_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('oil_change_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mileage_at_change')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('oil_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service_center')
                    ->searchable(),
                Tables\Columns\TextColumn::make('next_change_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('next_change_mileage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('oil_cost')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOilChanges::route('/'),
            'create' => Pages\CreateOilChange::route('/create'),
            'edit' => Pages\EditOilChange::route('/{record}/edit'),
        ];
    }
}
