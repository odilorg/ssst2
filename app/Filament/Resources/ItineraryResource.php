<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Itinerary;
use Filament\Tables\Table;
use Filament\Resources\Resource;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Select::make('transport_id')
                    ->required()
                    ->relationship('transport', 'plate_number'),
                Forms\Components\Select::make('tour_id')
                    ->required()
                    ->relationship('tour', 'name'),
                Forms\Components\TextInput::make('tour_group_code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('km_start')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('km_end')
                    ->required()
                    ->numeric(),
                Section::make('Проживание и питание')
                    ->schema([
                        Forms\Components\TextInput::make('fuel_expenditure_factual')
                            ->numeric(),
                        Forms\Components\TextInput::make('fuel_expenditure')
                            ->numeric(),
                          
                    ])->columns(2),

                


                Repeater::make('itinerary')
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->required(),
                        Forms\Components\TextInput::make('destination')
                            // ->required()
                            ->maxLength(255),
                        Forms\Components\TimePicker::make('pickup_time'),
                        //  ->required(),
                        Forms\Components\TextInput::make('program')
                            // ->required()
                            ->maxLength(255),
                            Forms\Components\Checkbox::make('accommodation'),
                            Forms\Components\Checkbox::make('food'),

                    ])->columns(2),
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
