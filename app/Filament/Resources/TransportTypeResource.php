<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransportTypeResource\Pages;
use App\Filament\Resources\TransportTypeResource\RelationManagers;
use App\Models\TransportType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransportTypeResource extends Resource
{
    protected static ?string $model = TransportType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\Select::make('price_type')
                    ->options([
                        'per_day' => 'Per Day',
                        'per_pickup_dropoff' => 'Per Pickup Dropoff'
                    ])
                    ->required(),
                    //->maxLength(255),
                    Forms\Components\TextInput::make('cost')
                    ->required()
                    ->maxLength(255),
                
    

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
