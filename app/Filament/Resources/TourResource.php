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

                Section::make('Информация о туре')
                    ->description('Введите информацию о туре')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Название')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('tour_number', Str::slug($state))),

                        TextInput::make('number_people')
                            ->label('Количество человек')
                            ->numeric()
                            ->required(),

                        Forms\Components\DatePicker::make('start_date')
                            ->label('Дата начала')
                            ->required()
                            ->before('end_date')
                            ->live(),

                        Forms\Components\DatePicker::make('end_date')
                            ->label('Дата окончания')
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
                            ->label('Описание')
                            ->required(),

                        Forms\Components\TextInput::make('tour_duration')
                            ->label('Длительность тура')
                            ->required()
                            ->suffix('дней')
                            ->readOnly()
                            ->default(0),

                        Forms\Components\Hidden::make('tour_number'),
                    ])->columns(2),

                Repeater::make('tourDays')
                    ->label('Добавить дни тура')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Название Дня. Day 1,2 и т.д. добавляется автоматически')
                            ->required(),

                        Select::make('city_id')
                            ->label('Город')
                            ->relationship('city', 'name')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('hotel_rooms', []);
                                $set('restaurant_meal_types', []);
                            })
                            ->required()
                            ->preload(),

                        Forms\Components\Select::make('guide_id')
                            ->label('Гид')
                            ->relationship('guide', 'name', function ($query) {
                                $query->where('is_marketing', true);
                            })
                            ->searchable()
                            ->required()
                            ->preload(),

                        Tabs::make('Транспорт')
                            ->tabs([
                                Tabs\Tab::make('Транспорт')
                                    ->label('Транспорт')
                                    ->schema([
                                        Repeater::make('tourDayTransports')
                                            ->label('Выбрать транспорт')
                                            ->relationship()
                                            ->schema([
                                                Select::make('category')
                                                    ->label('Категория')
                                                    ->options([
                                                        'bus' => 'Автобус',
                                                        'car' => 'Машина',
                                                        'mikro_bus' => 'Микроавтобус',
                                                        'mini_van' => 'Минивэн',
                                                        'air' => 'Воздушный',
                                                        'rail' => 'Железнодорожный',
                                                    ])
                                                    ->dehydrated(false)
                                                    ->live(),

                                                Select::make('transport_type_id')
                                                    ->label('Транспорт')
                                                    ->relationship('transportType', 'type', function ($query, callable $get) {
                                                        $category = $get('category');
                                                        if ($category) {
                                                            $query->where('category', $category);
                                                        }
                                                    })
                                                    ->required()
                                                    ->preload()
                                                    ->live(),

                                                Select::make('price_type')
                                                    ->label('Тип цены')
                                                    ->options([
                                                        'per_day' => 'За день',
                                                        'per_pickup_dropoff' => 'За трансфер',
                                                        'po_gorodu' => 'По городу',
                                                        'vip' => 'VIP',
                                                        'economy' => 'Эконом',
                                                        'business' => 'Бизнес',
                                                    ])
                                                    ->required()
                                                    ->live()
                                                    ->searchable(),
                                            ]),
                                    ]),

                                Tabs\Tab::make('Отели')
                                    ->label('Отели')
                                    ->schema([
                                        Forms\Components\Select::make('type')
                                            ->label('Категория отеля')
                                            ->options([
                                                'bed_breakfast' => 'Bed & Breakfast',
                                                '3_star' => '3 звезды',
                                                '4_star' => '4 звезды',
                                                '5_star' => '5 звезд',
                                            ])
                                            ->live()
                                            ->afterStateUpdated(fn($state, callable $set) => $set('hotel_rooms', [])),

                                        Select::make('hotel_id')
                                            ->label('Отель')
                                            ->options(fn(Get $get): Collection => Hotel::query()
                                                ->where('type', $get('type'))
                                                ->where('city_id', $get('city_id'))
                                                ->pluck('name', 'id'))
                                            ->afterStateUpdated(fn($state, callable $set) => $set('hotel_rooms', []))
                                            ->live(),

                                        Forms\Components\Repeater::make('hotel_rooms')
                                            ->label('Номера в отеле')
                                            ->relationship('hotelRooms')
                                            ->schema([
                                                Forms\Components\Hidden::make('hotel_id')
                                                    ->default(fn(callable $get) => $get('../../hotel_id'))
                                                    ->dehydrated(fn(callable $get) => $get('../../hotel_id')),

                                                Select::make('room_id')
                                                    ->label('Номер')
                                                    ->options(fn(Get $get): Collection => Room::query()
                                                        ->with('roomType')
                                                        ->where('hotel_id', $get('hotel_id'))
                                                        ->get()
                                                        ->mapWithKeys(fn($room) => [$room->id => $room->roomType->type]))
                                                    ->required()
                                                    ->searchable(),

                                                Forms\Components\TextInput::make('quantity')
                                                    ->label('Количество')
                                                    ->default(1)
                                                    ->numeric()
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->hidden(fn(callable $get) => !$get('hotel_id'))
                                            ->live()
                                            ->collapsible(),
                                    ]),

                                Tabs\Tab::make('Рестораны')
                                    ->label('Рестораны')
                                    ->schema([
                                       
                                        Repeater::make('restaurant_meal_types')
                                            ->label('Добавить рестораны')
                                            ->relationship('mealTypeRestaurantTourDays')
                                            ->schema([
                                                // Forms\Components\Hidden::make('restaurant_id')
                                                //     ->default(fn(callable $get) => $get('../../restaurant_id'))
                                                //     ->dehydrated(fn(callable $get) => $get('../../restaurant_id')),
                                                Select::make('restaurant_id')
                                                ->label('Ресторан')
                                                ->options(fn(Get $get): Collection => Restaurant::query()
                                                    ->where('city_id', $get('../../city_id'))
                                                    ->pluck('name', 'id'))
                                                ->afterStateUpdated(fn($state, callable $set) => $set('restaurant_meal_types', []))
                                                ->live(),
    
                                                    Select::make('meal_type_id')
                                                    ->label('Тип питания')
                                                    ->options([
                                                        'breakfast' => 'Завтрак', // Match the enum values from the database
                                                        'lunch' => 'Обед',
                                                        'dinner' => 'Ужин',
                                                        'coffee_break' => 'Кофе брейк',
                                                    ])
                                                    ->required(),
                                                
                                            ]),
                                    ]),

                                Tabs\Tab::make('Памятники')
                                    ->label('Памятники')
                                    ->schema([
                                        Select::make('monuments')
                                            ->label('Выбрать памятники')
                                            ->preload()
                                            ->multiple()
                                            ->searchable()
                                            ->relationship('monuments', 'name', fn(Builder $query, $get) => $query->where('city_id', $get('city_id')))
                                            ->afterStateUpdated(function ($state, $record) {
                                                if ($record) {
                                                    $record->monuments()->sync($state);
                                                } else {
                                                    Log::warning('Record is null while syncing monuments. Ensure the record is properly saved.');
                                                }
                                            }),
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
                    ->label('Название')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Описание')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tour_number')
                    ->label('Номер тура')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters here
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
            // Define relations here
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
