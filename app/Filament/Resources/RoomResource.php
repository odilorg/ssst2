<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RoomResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RoomResource\RelationManagers;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationGroup = 'Tour Items';

    protected static ?string $navigationParentItem = 'Гостиницы';

    protected static ?string $navigationLabel = 'Номера';
    protected static ?string $modelLabel = 'Номер';
    protected static ?string $pluralModelLabel = 'Номера';



    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('hotel_id')
                    ->relationship('hotel', 'name')
                    ->required()
                    ->preload(),
                Forms\Components\select::make('room_type_id')
                    ->relationship('roomType', 'type')
                    ->required()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),


                Select::make('amenities')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->relationship(titleAttribute: 'name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),

                    ]),
                Forms\Components\TextInput::make('cost_per_night')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                FileUpload::make('images')
                    ->multiple(),


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
                Tables\Columns\TextColumn::make('hotel.name')
                    //->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roomType.type')
                    //->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cost_per_night')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
