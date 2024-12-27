<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TransportType;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransportTypeResource\Pages;
use App\Filament\Resources\TransportTypeResource\RelationManagers;

class TransportTypeResource extends Resource
{
    protected static ?string $model = TransportType::class;
    protected static ?string $navigationGroup = 'Tour Items';

    protected static ?string $navigationParentItem = 'Transports';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Repeater::make('transportPrices')
                    ->relationship()
                    ->schema([

                        Forms\Components\Select::make('price_type')
                            ->options([
                                'per_day' => 'Per Day',
                                'per_pickup_dropoff' => 'Per Pickup Dropoff'
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('cost')
                            ->required()
                            ->numeric()
                            // ->default(0.00)
                            ->prefix('$'),
                    ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cost')
                    ->searchable(),
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
            'index' => Pages\ListTransportTypes::route('/'),
            'create' => Pages\CreateTransportType::route('/create'),
            'edit' => Pages\EditTransportType::route('/{record}/edit'),
        ];
    }
}
