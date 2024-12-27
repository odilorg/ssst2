<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Hotel;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                
                    Select::make('category')
                    ->label('Category')
                    ->options([
                        'bed_breakfast' => 'B&B',
                        '3_star' => '3 Star',
                        '4_star' => '4 Star',
                        '5_star' => '5 Star',
                    ])
                   // ->default('bus')  // If you want a default value
                    ->required(),


                    Repeater::make('rooms')
                    ->relationship()
                    ->schema([
                       
                    Forms\Components\select::make('room_type_id')
                        ->relationship('roomType', 'type')
                        ->required()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('type')
                                ->required(),
                            ]),
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
                    ])        


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('address'),
                SelectColumn::make('category')
                ->options([
                    'bed_breakfast' => 'B&B',
                    '3_star' => '3 Star',
                    '4_star' => '4 Star',
                    '5_star' => '5 Star',
                ]),        ])
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