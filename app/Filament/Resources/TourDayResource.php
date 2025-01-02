<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\TourDay;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TourDayResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TourDayResource\RelationManagers;
use Filament\Forms\Components\Select;

class TourDayResource extends Resource
{
    protected static ?string $model = TourDay::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('tour_id')
                    ->relationship('tour', 'name')
                    ->required()
                    ->preload(),

                Forms\Components\Select::make('guide_id')
                    ->relationship('guide', 'name')
                    ->required()
                    ->preload(),

                Repeater::make('tourDayTransports')
                    ->relationship()
                    ->schema([
                        Select::make('transport_id')
                            ->relationship('transport', 'model')
                            ->required()
                            ->preload(),
                        Select::make('price_type')
                            ->options([
                                'per_day' => 'Per Day',
                                'per_pickup_dropoff' => 'Per Pickup Dropoff'
                            ])
                    ]),

                forms\Components\Select::make('transport_id')
                    ->relationship('transport.transportType', 'type')
                    ->required()
                    ->preload(),

                Forms\Components\Select::make('hotel_id')
                    ->relationship('hotel', 'name')
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tour.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('guide.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('hotel.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transport.transportType.type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transport.category')
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
            'index' => Pages\ListTourDays::route('/'),
            'create' => Pages\CreateTourDay::route('/create'),
            'edit' => Pages\EditTourDay::route('/{record}/edit'),
        ];
    }
}
