<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Hotel;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;
    protected static ?string $navigationGroup = 'Tour Items';


    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Гостиницы';
    protected static ?string $modelLabel = 'Гостиница';
    protected static ?string $pluralModelLabel = 'Гостиницы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Инфо Гостиницы')
                    ->description('Введите информацию о гостинице')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                        ->label('Название гостиницы')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                        ->label('Телефон')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                        ->label('Email')    
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address')
                        ->label('Адрес')
                            ->maxLength(255),
                        Select::make('city_id')
                            ->relationship('city', 'name')
                            ->label('Город расположения')
                            ->required()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->maxLength(555)
                                    ->default(null),
                                Forms\Components\FileUpload::make('images')
                                    ->multiple()
                                    ->image()
                                    ->columnSpanFull(),
                            ]),
                        Select::make('type')
                            ->label('Категория гостиницы')
                            ->options([
                                'bed_breakfast' => 'B&B',
                                '3_star' => '3 Star',
                                '4_star' => '4 Star',
                                '5_star' => '5 Star',
                            ])
                            // ->default('bus')  // If you want a default value
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label('Описание гостиницы')
                            ->maxLength(555)
                            ->default(null),
                        Forms\Components\FileUpload::make('images')
                            ->label('Фотографии гостиницы')
                            ->multiple()
                            ->image(),

                    ])->columns(2),

                    Section::make('Номера гостиницы')
                    ->description('Введите типы и стоимость номеров')
                    ->schema([
                        Repeater::make('rooms')
                        ->label('Номера')
                        ->relationship()
                        ->schema([
    
                            Forms\Components\select::make('room_type_id')
                                ->relationship('roomType', 'type')
                                ->label('Тип номера или создать новый нажми плюсик в конце')
                                ->required()
                                ->preload()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('type')
                                        ->required(),
                                ]),
                            // Forms\Components\TextInput::make('name')
                            //     ->required()
                            //     ->maxLength(255),
                            
    
    
                            Select::make('amenities')
                            ->label('Удобства в номере или создать новый нажми плюсик в конце')
                                ->multiple()
                                ->preload()
                                ->searchable()
                                ->relationship(titleAttribute: 'name')
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required(),
    
                                ]),
                            Forms\Components\TextInput::make('cost_per_night')
                                ->label('Стоимость за ночь')
                                ->required()
                                ->numeric(),
                             Forms\Components\TextInput::make('room_size')
                                ->label('Размер номера (кв. м.)')
                                ->required()
                                ->numeric(),    
                               
                                Forms\Components\Textarea::make('description')
                                ->label('Описание номера')
                                ->columnSpanFull(),    
                            FileUpload::make('images')
                            ->label('Фотографии номера')
                                ->multiple()
                                ->columnSpanFull(),   
                        ])
                    ])


                   
                        
                   



                

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    
                    ->searchable()
                    ->label('Название'),
                TextColumn::make('city.name')
                    ->searchable()
                    ->label('Город'),
                TextColumn::make('type')
                    ->label('Категория'),
                TextColumn::make('phone')    
                    ->label('Телефон'),
                TextColumn::make('email')    
                    ->label('Email'),
                    ImageColumn::make('images')
                    ->circular()
                    ->stacked()     
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
            'index' => \App\Filament\Resources\HotelResource\Pages\ListHotels::route('/'),
            'create' => \App\Filament\Resources\HotelResource\Pages\CreateHotel::route('/create'),
            'edit' => \App\Filament\Resources\HotelResource\Pages\EditHotel::route('/{record}/edit'),
        ];
    }
}
