<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TransportType;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
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
                Select::make('category')
                    ->options([
                        'bus' => 'Bus',
                        'car' => 'Car',
                        'mikro_bus' => 'Mikro Bus',
                        'air' => 'Air',
                        'rail' => 'Rail'
                    ])
                    ->live()
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Repeater::make('transportPrices')
                    ->relationship()
                    ->schema([

                        Forms\Components\Select::make('price_type')
                            ->options([
                                'per_day' => 'Per Day',
                                'per_pickup_dropoff' => 'Per Pickup Dropoff',
                                'vip' => 'VIP',
                                'economy' => 'Economy',
                                'business' => 'Business',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('cost')
                            ->required()
                            ->numeric()
                            // ->default(0.00)
                            ->prefix('$'),
                            ]),
            // New field for selecting running days for "rail"
                    Select::make('running_days')
                    ->label('Running Days')
                    ->options([
                        'monday' => 'Monday',
                        'tuesday' => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday' => 'Thursday',
                        'friday' => 'Friday',
                        'saturday' => 'Saturday',
                        'sunday' => 'Sunday',
                    ])
                    ->multiple() // Allow multiple selections
                    ->required()
                    ->live()
                    ->visible(fn ($get) => $get('category') === 'rail') // Show only for 'rail'
                    ->placeholder('Select running days'),                    

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
