<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use App\Models\Tour;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TourResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TourResource\RelationManagers;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('tour_number')
                    ->columnSpanFull(),

                Repeater::make('tourDays')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('description')
                            ->columnSpanFull(),
                            Forms\Components\Select::make('guide_id')
                            ->label('Guide')
                            ->options(function () {
                                return \App\Models\Guide::with('languages')->get()->mapWithKeys(function ($guide) {
                                    $languages = $guide->languages->pluck('name')->join(', '); // Combine spoken languages into a string
                                    return [
                                        $guide->id => "{$guide->name} ({$languages})", // Format: "Guide Name (Language1, Language2)"
                                    ];
                                });
                            })
                            ->searchable() // Enable searching for guides
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
                                    ->label('Price Type')
                                    ->options(function (callable $get) {
                                        $transportId = $get('transport_id'); // Get the selected transport ID
                                
                                        if (!$transportId) {
                                            return [
                                                'per_day' => 'Per Day',
                                                'per_pickup_dropoff' => 'Per Pickup Dropoff',
                                            ]; // Default options if no transport is selected
                                        }
                                
                                        // Fetch the selected transport with its related prices
                                        $transport = \App\Models\Transport::where('id', $transportId)
                                            ->with(['transportType.transportPrices'])
                                            ->first();
                                
                                        if (!$transport || !$transport->transportType) {
                                            return [
                                                'per_day' => 'Per Day',
                                                'per_pickup_dropoff' => 'Per Pickup Dropoff',
                                            ]; // Fallback if transport or transportType is missing
                                        }
                                
                                        // Fetch the relevant prices for the two types
                                        $prices = $transport->transportType->transportPrices
                                            ->whereIn('price_type', ['per_day', 'per_pickup_dropoff']);
                                
                                        // Map the prices to the static options
                                        return [
                                            'per_day' => 'Per Day (' . ($prices->where('price_type', 'per_day')->first()->cost ?? 'N/A') . ' USD)',
                                            'per_pickup_dropoff' => 'Per Pickup Dropoff (' . ($prices->where('price_type', 'per_pickup_dropoff')->first()->cost ?? 'N/A') . ' USD)',
                                        ];
                                    })
                                    ->required()
                                    ->reactive()
                                    ->searchable(), // Enable search for usability
                                
                            ]),
                            Forms\Components\Select::make('hotel_id')
                            ->label('Hotel')
                            ->options(function () {
                                return \App\Models\Hotel::all()->mapWithKeys(function ($hotel) {
                                    return [
                                        $hotel->id => "{$hotel->name} ({$hotel->category})", // Format: "Hotel Name (Category)"
                                    ];
                                });
                            })
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('hotel_rooms', []); // Reset hotel rooms when the hotel changes
                            })
                            ->searchable(), // Enable search for better usability
                        
                        // ->dehydrated(false), // Do NOT send this field to the server
                        Forms\Components\Repeater::make('hotel_rooms')
                            ->relationship('hotelRooms') // Explicitly define the relationship
                            ->label('Hotel Rooms')
                            ->schema([
                                // Hidden field to ensure hotel_id is submitted inside the pivot table
                                Forms\Components\Hidden::make('hotel_id')
                                    ->default(fn(callable $get) => $get('../../hotel_id')) // Fetch the parent hotel_id
                                    ->dehydrated(fn(callable $get) => $get('../../hotel_id')), // Include in the payload only if set

                                    Forms\Components\Select::make('room_id')
                                    ->label('Room Type')
                                    ->options(function (callable $get) {
                                        $hotelId = $get('hotel_id'); // Get the selected hotel ID
                                        return $hotelId
                                            ? Room::where('hotel_id', $hotelId)
                                                ->with('roomType') // Eager load the roomType relationship
                                                ->get()
                                                ->mapWithKeys(function ($room) {
                                                    return [
                                                        $room->id => "{$room->roomType->type} ({$room->cost_per_night} USD)", // Format: "RoomType (Price)"
                                                    ];
                                                })
                                            : [];
                                    })
                                    ->required()
                                    ->searchable(), // Enable search for better usability
                                

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->default(1)
                                    ->numeric()

                                    ->required(),
                            ])
                            ->columns(2)
                            ->hidden(fn(callable $get) => !$get('hotel_id')) // Show only when a hotel is selected
                            ->collapsible()
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tour_number')
                    ->searchable(),
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
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }
}
