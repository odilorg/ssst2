<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DayResource\RelationManagers\GuidesRelationManager;
use App\Filament\Resources\DayResource\RelationManagers\HotelsRelationManager;
use App\Filament\Resources\DayResource\RelationManagers\TransportationsRelationManager;
use App\Models\Day;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\Tour;
use App\Models\Transportation;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DayResource extends Resource
{
    protected static ?string $model = Day::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tour_id')
                    ->label('Tour')
                    ->options(Tour::all()->pluck('name', 'id'))
                    ->required(),
                TextInput::make('day_number')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Repeater::make('hotels')
                    ->relationship('hotels')
                    ->schema([
                        Select::make('hotel_id')
                            ->label('Hotel')
                            ->options(Hotel::all()->pluck('name', 'id'))
                            ->required(),
                        TextInput::make('number_of_rooms')->numeric()->default(1)->required(),
                        TextInput::make('number_of_nights')->numeric()->default(1)->required(),
                        TextInput::make('agreed_price')->numeric(),
                    ])->columns(3),
                Repeater::make('transportations')
                    ->relationship('transportations')
                    ->schema([
                        Select::make('transportation_id')
                            ->label('Transportation')
                            ->options(Transportation::all()->pluck('type', 'id'))
                            ->required(),
                        Select::make('vehicle_type')
                            ->label('Vehicle Type')
                            ->options(Transportation::all()->pluck('vehicle_type', 'vehicle_type'))
                            ->required(),
                        TextInput::make('quantity')->numeric()->default(1)->required(),
                        TextInput::make('agreed_price')->numeric(),

                    ])->columns(4),
                Repeater::make('guides')
                    ->relationship('guides')
                    ->schema([
                        Select::make('guide_id')
                            ->label('Guide')
                            ->options(Guide::all()->pluck('name', 'id'))
                            ->required(),
                        Select::make('language')
                            ->label('Language')
                            ->options(Guide::all()->pluck('language', 'language'))
                            ->required(),
                        TextInput::make('number_of_days')->numeric()->default(1)->required(),
                        TextInput::make('agreed_price')->numeric(),
                    ])->columns(4),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tour.name'),
                TextColumn::make('day_number'),
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
            // HotelsRelationManager::class,
            // TransportationsRelationManager::class,
            // GuidesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\DayResource\Pages\ListDays::route('/'),
            'create' => \App\Filament\Resources\DayResource\Pages\CreateDay::route('/create'),
            'edit' => \App\Filament\Resources\DayResource\Pages\EditDay::route('/{record}/edit'),
        ];
    }
}