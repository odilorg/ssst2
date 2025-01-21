<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Faker\Core\File;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Transport;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TransportResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransportResource\RelationManagers;

class TransportResource extends Resource
{
    protected static ?string $model = Transport::class;
    protected static ?string $navigationGroup = 'Tour Items';

    protected static ?string $navigationLabel = 'Транспорт';
    protected static ?string $modelLabel = 'Транспорт';
    protected static ?string $pluralModelLabel = 'Транспорт';


    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category')
                    ->label('Выберите категорию')
                    ->options([
                        'bus' => 'Bus',
                        'car' => 'Car',
                        'mikro_bus' => 'Mikro Bus',
                        'mini_van' => 'Mini Van',
                        'air' => 'Air',
                        'rail' => 'Rail'
                    ])
                    ->live() // Make it reactive
                    ->required(),

                Select::make('transport_type_id')
                    ->label('Тип транспорта')
                    ->options(function ($get) {
                        $selectedCategory = $get('category');

                        if (!$selectedCategory) {
                            return [];
                        }

                        // Fetch the transport types dynamically based on the selected category
                        return \App\Models\TransportType::where('category', $selectedCategory)
                            ->pluck('type', 'id');
                    })
                    ->required()
                    ->preload(),

                Select::make('driver_id')
                    ->label('Водитель')
                    ->relationship('driver', 'name')
                    ->visible(function ($get) {
                        return !in_array($get('category'), ['rail', 'air']); // Hide for rail and air
                    })
                    ->required()
                    ->preload(),


                Forms\Components\TextInput::make('plate_number')
                    ->label('Гос. номер')
                    ->visible(function ($get) {
                        return !in_array($get('category'), ['rail', 'air']); // Hide for rail and air
                    })
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('model')
                    ->label('Модель')
                    ->visible(function ($get) {
                        return !in_array($get('category'), ['rail', 'air']); // Hide for rail and air
                    })
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('number_of_seat')
                    ->label('Количество мест')
                    ->visible(function ($get) {
                        return !in_array($get('category'), ['rail', 'air']); // Hide for rail and air
                    })
                    ->required()
                    ->numeric(),

                TimePicker::make('departure_time')
                    ->visible(function ($get) {
                        return in_array($get('category'), ['rail', 'air']); // Show only for rail and air
                    })
                    ->required(),

                TimePicker::make('arrival_time')
                    ->visible(function ($get) {
                        return in_array($get('category'), ['rail', 'air']); // Show only for rail and air
                    })
                    ->required(),
                    FileUpload::make('images')
                    ->label('Фотографии транспорта')    
                    ->image()
                    ->multiple(),
                    Select::make('amenities')
                    ->label('Удобства')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->relationship(titleAttribute: 'name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),

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
                Tables\Columns\TextColumn::make('plate_number')
                    ->label('Гос. номер')
                    ->searchable(),
                Tables\Columns\TextColumn::make('driver.name')
                    ->label('Водитель')
                    ->searchable(),
                    ImageColumn::make('images')
                    ->circular()
                    ->stacked(), 
                Tables\Columns\TextColumn::make('model')
                    ->label('Модель')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_seat')
                    ->label('Кол. мест')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable()
                    ->sortable()
                    ->label('Категория'),
                    TextColumn::make('amenities.name')
                    ->listWithLineBreaks()   
                    //->bulleted()

 

                // Tables\Columns\TextColumn::make('transportType.transportPrices.cost')
                //     ->label('Per Day, Per Pickup'),


                // Tables\Columns\TextColumn::make('transportType.type')
                //     //  ->numeric()
                //     ->sortable(),
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
