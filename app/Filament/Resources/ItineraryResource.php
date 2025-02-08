<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Itinerary;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ItineraryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ItineraryResource\RelationManagers;

class ItineraryResource extends Resource
{
    protected static ?string $model = Itinerary::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Tour Items';

    protected static ?string $navigationParentItem = 'Транспорт';
    protected static ?string $navigationLabel = 'Маршрут';
    protected static ?string $modelLabel = 'Маршрут';
    protected static ?string $pluralModelLabel = 'Маршруты';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Инфо по маршруту')
                    ->schema([
                        Forms\Components\Select::make('transport_id')
                            ->label('Выберите Транспорт')
                            ->required()
                            ->relationship('transport', 'plate_number'),
                        Forms\Components\Select::make('tour_id')
                            ->label('Выберите Тур')
                          //  ->required()
                            ->relationship('tour', 'name'),

                        Forms\Components\TextInput::make('km_start')
                            ->label('Начальный километраж')
                          //  ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('km_end')
                            ->label('Конечный километраж')
                           // ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('tour_group_code')
                            ->label('Код группы')
                            ->required()
                            ->maxLength(255),
                    ])->columns(),

                // Section::make('Расход топлива')
                //     ->schema([
                //         Forms\Components\TextInput::make('fuel_expenditure_factual')
                //             ->numeric()
                //             ->label('Фактический расход топлива'),
                //         Forms\Components\TextInput::make('fuel_expenditure')
                //             ->label('Расход топлива')
                //             ->numeric(),

                //     ])->columns(2),


                Section::make('Информация о программе')
                    ->schema([
                        Repeater::make('itineraryItems')
                            ->label('Пункты маршрута')
                            ->relationship('itineraryItems') // Ensure this matches the relationship name in the model
                            ->schema([
                                Forms\Components\DatePicker::make('date')
                                    ->label('Дата')
                                    ->required(),
                                Forms\Components\Select::make('city_distance_id')
                                    ->label('Пункт назначения')
                                    ->relationship('cityDistance', 'city_from_to'),
                                Forms\Components\TimePicker::make('time')
                                    ->label('Время подачи'),
                                Forms\Components\TextInput::make('program')
                                    ->label('Программа')
                                    ->maxLength(255),
                                Forms\Components\Checkbox::make('accommodation')
                                    ->label('Проживание'),
                                Forms\Components\Checkbox::make('food')
                                    ->label('Питание'),

                            ])->columns(2)
                            ->addActionLabel('Добавить пункт'),
                    ]),


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
                Tables\Columns\TextColumn::make('transport.plate_number')
                    //->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tour.name')
                    //->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tour_group_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('km_start')
                    ->searchable(),
                Tables\Columns\TextColumn::make('km_end')
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-s-cloud-arrow-down')
                    ->visible(fn(Itinerary $record): bool => !is_null($record->file_name))
                    ->action(function (Itinerary $record) {
                        return response()->download(storage_path('app/public/itineraries/') . $record->file_name);
                    }),

                // Tables\Actions\Action::make('send_contract')
                //     ->icon('heroicon-o-envelope')
                //    // ->visible(fn(Itinerary $record): bool => !is_null($record->file_name))
                //     ->action(function (Itinerary $record) {
                //         Mail::to($record->client_email)->queue(new SendEstimate($record));
                //     }),
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
            'index' => Pages\ListItineraries::route('/'),
            'create' => Pages\CreateItinerary::route('/create'),
            'edit' => Pages\EditItinerary::route('/{record}/edit'),
        ];
    }
}
