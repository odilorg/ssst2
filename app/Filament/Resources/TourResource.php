<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use App\Models\Tour;
use Filament\Tables;
use App\Models\Hotel;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\MealType;
use Filament\Forms\Form;
use App\Models\Restaurant;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TourResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TourResource\RelationManagers;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-europe-africa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Tour Information')
                    ->description('Enter the tour information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('tour_number', Str::slug($state))),

                        TextInput::make('number_people')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Forms\Components\DatePicker::make('start_date')
                            ->required()
                            ->before('end_date')
                            ->live(),



                        Forms\Components\DatePicker::make('end_date')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (callable $set, $state, $get) {
                                $startDate = $get('start_date');
                                $endDate = $get('end_date');
                                if ($startDate && $endDate) {
                                    $duration = \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1;
                                    $set('tour_duration', $duration);
                                }
                            }),
                        Forms\Components\Textarea::make('description')
                            ->required(),




                        Forms\Components\TextInput::make('tour_duration')
                            ->required()
                            ->suffix('days')
                            ->readOnly()
                            ->default(0),
                        Forms\Components\Hidden::make('tour_number'),
                    ])->columns(2),






                Repeater::make('tourDays')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Select::make('city_id')
                            ->label('City')
                            ->relationship('city', 'name')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('hotel_rooms', []); // Clear the hotel_rooms field
                                $set('restaurant_meal_types', []); // Set another_field to a specific value
                            })->required()
                            ->preload(),
                        Forms\Components\Select::make('guide_id')
                            ->label('Guide')
                            ->relationship('guide', 'name', function ($query) {
                                $query->where('is_marketing', true); // Add the constraint for the is_marketing column
                            })
                            ->searchable() // Enable searching for guides
                            ->required()
                            ->preload(),

                        Tabs::make('Transport')
                            ->tabs([
                                Tabs\Tab::make('Transport')
                                    ->schema([
                                        Repeater::make('tourDayTransports')
                                            ->label('Choose Transport')
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
                                                    ->relationship('transport.transportType', 'type', function ($query, callable $get) {
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
                                                                'vip' => 'VIP',
                                                                'economy' => 'Economy',
                                                                'business' => 'Business',
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
                                                                'vip' => 'VIP',
                                                                'economy' => 'Economy',
                                                                'business' => 'Business',
                                                            ]; // Fallback if transport or transportType is missing
                                                        }

                                                        // Return static options
                                                        return [
                                                            'per_day' => 'Per Day',
                                                            'per_pickup_dropoff' => 'Per Pickup Dropoff',
                                                            'vip' => 'VIP',
                                                            'economy' => 'Economy',
                                                            'business' => 'Business',
                                                        ];
                                                    })
                                                    ->required()
                                                    ->live()
                                                    ->searchable(), // Enable search for usability
                                            ]),
                                    ]),
                                Tabs\Tab::make('Hotels')
                                    ->schema([
                                        Forms\Components\Select::make('type')
                                            ->label('Hotel Category')
                                            ->options([
                                                'bed_breakfast' => 'Bed and Breakfast',
                                                '3_star' => '3 Star',
                                                '4_star' => '4 Star',
                                                '5_star' => '5 Star',
                                            ])
                                            ->live()
                                            ->afterStateUpdated(fn($state, callable $set) => $set('hotel_rooms', [])), // Clear hotel_rooms when hotel_id changes
                                        //->dehydrated(false),
                                        Select::make('hotel_id')
                                            ->label('Hotel')
                                            ->options(fn(Get $get): Collection => Hotel::query()
                                                ->where('type', $get('type'))
                                                ->where('city_id', $get('city_id'))
                                                ->pluck('name', 'id'))
                                            ->afterStateUpdated(fn($state, callable $set) => $set('hotel_rooms', [])) // Clear hotel_rooms when hotel_id changes
                                            ->live(),

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
                                                    ->options(fn(Get $get): Collection => Room::query()
                                                        ->with('roomType')
                                                        ->where('hotel_id', $get('hotel_id'))
                                                        //->where('city_id', $get('city_id'))
                                                        ->get()
                                                        ->mapWithKeys(function ($room) {
                                                            return [$room->id => $room->roomType->type]; // Map room id to the type from roomType
                                                        }))
                                                    ->required()
                                                    ->searchable(),
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
                                    ]),
                                Tabs\Tab::make('Monuments')
                                    ->schema([
                                        Select::make('monuments')
                                            ->label('Select Monuments')
                                            ->preload()
                                            ->multiple()
                                            ->searchable()
                                            ->relationship('monuments', 'name', fn(Builder $query, $get) => $query->where('city_id', $get('city_id')))
                                            ->required()
                                            ->afterStateUpdated(function ($state, $record) {
                                                if ($record) {
                                                    // Sync the monuments relationship with the selected values
                                                    $record->monuments()->sync($state);
                                                } else {
                                                    Log::warning('Record is null while syncing monuments. Ensure the record is properly saved.');
                                                }
                                            }),
                                    ]),

                                Tabs\Tab::make('Restaurants')
                                    ->schema([
                                        Select::make('restaurant_id')
                                            ->label('Restaurant')
                                            ->options(fn(Get $get): Collection => Restaurant::query()
                                                //->where('type', $get('type'))
                                                ->where('city_id', $get('city_id'))
                                                ->pluck('name', 'id'))
                                            ->afterStateUpdated(fn($state, callable $set) => $set('restaurant_meal_types', [])) // Clear hotel_rooms when hotel_id changes
                                            ->live(),
                                        Repeater::make('restaurant_meal_types')
                                            ->relationship('mealTypeRestaurantTourDays')
                                            ->schema([
                                                Forms\Components\Hidden::make('restaurant_id')
                                                    ->default(fn(callable $get) => $get('../../restaurant_id'))
                                                    ->dehydrated(fn(callable $get) => $get('../../restaurant_id'))
                                                    ->afterStateHydrated(function ($state) {
                                                        Log::info('Restaurant ID set in hidden field:', ['restaurant_id' => $state]);
                                                    }),
                                                Select::make('meal_type_id')
                                                    ->label('Meal Type')
                                                    ->options(function (callable $get) {
                                                        $restaurantId = $get('restaurant_id');
                                                        $mealTypes = MealType::where('restaurant_id', $restaurantId)
                                                            ->pluck('name', 'id');
                                                        Log::info('Meal Type Options:', $mealTypes->toArray());
                                                        return $mealTypes;
                                                    })
                                                    ->required()
                                                    ->afterStateUpdated(function ($state) {
                                                        Log::info('Meal Type ID Selected:', ['meal_type_id' => $state]);
                                                    })

                                            ])
                                    ]),


                            ]),















                    ])->columnSpanFull(),
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

    // protected function afterSave($record, array $data): void
    // {
    //     // Sync the monuments relationship with the selected values
    //     $record->monuments()->sync($data['monuments'] ?? []);
    // }
}
