<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Guide;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GuideResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GuideResource\RelationManagers;

class GuideResource extends Resource
{
    protected static ?string $model = Guide::class;

    protected static ?string $navigationGroup = 'Tour Items';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Гиды';
    protected static ?string $modelLabel = 'Гид';
    protected static ?string $pluralModelLabel = 'Гиды';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Основная информация гидом')
                    ->description('Заполните основную информацию о гиде')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('ФИО Гида')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Телефон')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address')
                            ->label('Адрес')
                            //->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('city')
                            ->label('Город')
                            //->required()
                            ->maxLength(255),
                        // Forms\Components\TextInput::make('daily_rate')
                        //     ->label('Оплата в день')
                        //     ->required()
                        //     ->numeric(),
                        //     //->default(0.00),

                        Select::make('languages')
                            ->label('Языки')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->relationship('languages', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->required(),

                        Repeater::make('price_types')
                            ->label('Типы цен')
                            ->schema([
                                Select::make('price_type_name')
                                ->options([
                                    'pickup_dropoff' => 'Встреча/проводы',
                                    'halfday' => 'Полдня',
                                    'per_daily' => 'За день',
                                ])
                                ->required(),
                                TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('$'),
                                // ...
                            ]),
                        Forms\Components\FileUpload::make('image')
                            ->label('Фото')
                            ->image(),
                        Toggle::make('is_marketing'),
                    ])->columns(),






            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('ФИО Гида')
                    ->searchable(),
                Tables\Columns\TextColumn::make('daily_rate')
                    ->label('Оплата')
                    ->prefix('$')

                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->iconColor('primary')
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->copyMessageDuration(1500)



                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Адрес')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Город')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Фото'),
                //->thumbnail()
                //->sortable()
                //->searchable(),    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('languages.name')
                    ->listWithLineBreaks()


                    ->label('Языки')
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
            'index' => Pages\ListGuides::route('/'),
            'create' => Pages\CreateGuide::route('/create'),
            'edit' => Pages\EditGuide::route('/{record}/edit'),
        ];
    }
}
