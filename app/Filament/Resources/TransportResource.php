<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Transport;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TransportResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransportResource\RelationManagers;

class TransportResource extends Resource
{
    protected static ?string $model = Transport::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category')
                ->label('Category')
                ->options([
                    'bus' => 'Bus',
                    'car' => 'Car',
                    'mikro_bus' => 'Mikro Bus',
                    'air' => 'Air',
                    'rail' => 'Rail',

                ]),
                Forms\Components\TextInput::make('plate_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('model')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('number_of_seat')
                    ->required()
                    ->numeric(),
                // Forms\Components\Select::make('transportation_id')

                //     ->relationship('transportation', 'category')
                //     ->required()
                //     ->preload(),
                Forms\Components\Select::make('transport_type_id')
                    ->relationship('transportType', 'type')
                    ->createOptionForm([
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

                    ])
                    ->required()
                    ->preload(),
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
                Tables\Columns\TextColumn::make('plate_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_seat')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('category'),
                    Tables\Columns\TextColumn::make('transportType.cost'),

               
                Tables\Columns\TextColumn::make('transportType.type')
                  //  ->numeric()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransports::route('/'),
            'create' => Pages\CreateTransport::route('/create'),
            'edit' => Pages\EditTransport::route('/{record}/edit'),
        ];
    }
}
