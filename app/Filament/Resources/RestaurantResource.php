<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Restaurant;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RestaurantResource\Pages;
use App\Filament\Resources\RestaurantResource\RelationManagers;
use Faker\Core\File;
use Filament\Forms\Components\FileUpload;

class RestaurantResource extends Resource
{
    protected static ?string $model = Restaurant::class;

    protected static ?string $navigationGroup = 'Tour Items';

    protected static ?string $navigationLabel = 'Рестораны';
    protected static ?string $modelLabel = 'Ресторан';
    protected static ?string $pluralModelLabel = 'Рестораны';



    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Создание ресторана')
                    ->description('Введите данные ресторана')
                    ->schema([
                        Select::make('city_id')
                            ->label('Город расположение')
                            ->relationship('city', 'name')
                            ->required()
                            ->preload()
                            ->searchable(),
                        //->label('City'),
                        Forms\Components\TextInput::make('name')
                            ->label('Название ресторана')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address')
                            ->label('Адрес ресторана')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Телефон ресторана')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('website')
                            ->label('Вэб сайт ресторана')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),



                Repeater::make('mealTypes')
                    ->label('Блюда')
                    ->relationship()
                    ->schema([
                        Select::make('category')
                            ->label('Категория блюда')
                            ->options([
                                'breakfast' => 'Breakfast',
                                'lunch' => 'Lunch',
                                'dinner' => 'Dinner',
                                'coffee_break' => 'Coffee Break',

                            ]),
                        Forms\Components\TextInput::make('description')
                            ->label('Описание блюда или заметки')
                            ->maxLength(255)
                            ->default(null),

                        Forms\Components\TextInput::make('price')
                            ->label('Цена блюда')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        FileUpload::make('menu_images')
                            ->label('Изображения меню или блюд')
                            ->multiple()
                            ->image(),
                        // ->columnSpanFull(),       
                    ])

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
                ->label('Название ')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон ')
                        ->searchable(),
                Tables\Columns\TextColumn::make('address')
                ->label('Адрес ')
                    ->searchable(),
               
                Tables\Columns\TextColumn::make('website')
                ->label('Вэб сайт ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
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
            'index' => Pages\ListRestaurants::route('/'),
            'create' => Pages\CreateRestaurant::route('/create'),
            'edit' => Pages\EditRestaurant::route('/{record}/edit'),
        ];
    }
}
