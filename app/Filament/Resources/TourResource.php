<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use App\Models\Tour;
use Filament\Tables;
use App\Models\Hotel;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
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
                            ->required(),
                        Select::make('city_id')
                            ->label('City')
                            ->relationship('city', 'name')
                            ->live()
                            ->afterStateUpdated(fn($state, callable $set) => $set('hotel_rooms', [])) // Clear hotel_rooms when hotel_id changes
                            ->required()
                            ->preload(),
                        Forms\Components\Select::make('guide_id')
                            ->label('Guide')
                            ->relationship('guide', 'name', function ($query) {
                                $query->where('is_marketing', true); // Add the constraint for the is_marketing column
                            })
                            ->searchable() // Enable searching for guides
                            ->required()
                            ->preload(),

                        Repeater::make('tourDayTransports')
                            ->relationship()
                            ->schema([
                                Select::make('category')
                                    ->label('Category')
                                    ->options([
                                        'bus' => 'Bus',
                                        'car' => 'Car',
                                        'mikro_bus' => 'Mikro Bus',
                                        'air' => 'Air',
                                        'rail' => 'Rail',
                                    ])
                                    ->dehydrated(false) // Prevent this field from being sent to the server
                                    ->live(), // Make this field reactive to trigger updates in the dependent field

                                Select::make('transport_id')
                                    ->label('Transport')
                                    ->relationship('transport', 'model', function ($query, callable $get) {
                                        $category = $get('category'); // Get the selected category
                                        if ($category) {
                                            $query->where('category', $category); // Filter transports by selected category
                                        }
                                    })
                                    ->required()
                                    ->preload()
                                    ->live(), // Make this field reactive to update when the category changes

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

                                        // Return static options
                                        return [
                                            'per_day' => 'Per Day',
                                            'per_pickup_dropoff' => 'Per Pickup Dropoff',
                                        ];
                                    })
                                    ->required()
                                    ->live()
                                    ->searchable(), // Enable search for usability
                            ]),


                        Forms\Components\Select::make('type')
                            ->label('Hotel Category')
                            ->options([
                                'bed_breakfast' => 'Bed and Breakfast',
                                '3_star' => '3 Star',
                                '4_star' => '4 Star',
                                '5_star' => '5 Star',
                            ])
                            ->live()
                            ->afterStateUpdated(fn($state, callable $set) => $set('hotel_rooms', [])) // Clear hotel_rooms when hotel_id changes
                            ->dehydrated(false),
                            Select::make('hotel_id')
                                ->label('Hotel')
                            ->options(fn (Get $get): Collection => Hotel::query()
                                ->where('type', $get('type'))
                                ->where('city_id', $get('city_id'))
                                ->pluck('name', 'id'))
                                ->afterStateUpdated(fn($state, callable $set) => $set('hotel_rooms', [])) // Clear hotel_rooms when hotel_id changes
                                ->live(),

                        // Forms\Components\Select::make('hotel_id')
                        //     ->label('Hotel')
                        //     ->options(function (callable $get) {
                        //         $cityId = $get('city_id'); // Fetch city_id from the parent Repeater (tourDays)
                        //         $type = $get('type'); // Get the selected hotel type

                        //         $query = \App\Models\Hotel::query();

                        //         if ($cityId) {
                        //             $query->where('city_id', $cityId); // Filter by city_id
                        //         }
                        //         if ($type) {
                        //             $query->where('type', $type); // Filter by type
                        //         }

                        //         return $query->pluck('name', 'id');
                        //     })
                        //     ->required()
                        //    // ->reactive() // Updates the repeater when changed
                        //     ->afterStateUpdated(fn($state, callable $set) => $set('hotel_rooms', [])) // Clear hotel_rooms when hotel_id changes
                        //     ->live(),

                        Forms\Components\Repeater::make('hotel_rooms')
                            ->relationship('hotelRooms') // Explicitly define the relationship
                            ->label('Hotel Rooms')
                            ->schema([
                                // Hidden field to ensure hotel_id is submitted inside the pivot table
                                Forms\Components\Hidden::make('hotel_id')
                                    ->default(fn(callable $get) => $get('../../hotel_id')) // Fetch the parent hotel_id
                                    ->dehydrated(fn(callable $get) => $get('../../hotel_id')), // Include in the payload only if set

                                    Select::make('room_id')
                                    ->label('Hotel')
                                    ->options(fn (Get $get): Collection => Room::query()
                                        ->with('roomType')
                                        ->where('hotel_id', $get('hotel_id'))
                                        //->where('city_id', $get('city_id'))
                                        ->get()
                                        ->mapWithKeys(function ($room) {
                                            return [$room->id => $room->roomType->type]; // Map room id to the type from roomType
                                        }))
                                   ->required()
                                   ->searchable(),


                                // Forms\Components\Select::make('room_id')
                                //     ->label('Room Type')
                                //     ->options(function (callable $get) {
                                //         $hotelId = $get('hotel_id'); // Get the selected hotel ID
                                //         return $hotelId
                                //             ? Room::where('hotel_id', $hotelId)
                                //             ->with('roomType') // Eager load the roomType relationship
                                //             ->get()
                                //             ->mapWithKeys(function ($room) {
                                //                 return [
                                //                     $room->id => "{$room->roomType->type} ", // Format: "RoomType "
                                //                 ];
                                //             })
                                //             : [];
                                //     })
                                //     ->required()
                                //     ->searchable(), // Enable search for better usability

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->default(1)
                                    ->numeric()
                                    ->required(),
                            ])
                            ->columns(2)
                            ->hidden(fn(callable $get) => !$get('hotel_id')) // Show only when a hotel is selected
                            ->live()
                            ->collapsible(),

                        Select::make('monuments')
                            ->label('Select Monuments')
                            ->preload()
                            ->multiple()
                            ->searchable()
                            ->relationship('monuments', 'name')
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('city')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('ticket_price')
                                    ->required()
                                    ->numeric(),
                                Forms\Components\Textarea::make('description')
                                    ->columnSpanFull(),
                            ]),  // Allow multiple selections

                        Select::make('restaurant_id')

                            ->label('Select Restaurant')
                            ->relationship('restaurant', 'name')
                            ->searchable()
                            ->preload(),

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
