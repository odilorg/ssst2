<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Monument;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\MonumentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MonumentResource\RelationManagers;


class MonumentResource extends Resource
{
    protected static ?string $model = Monument::class;
    protected static ?string $navigationGroup = 'Tour Items';

    protected static ?string $navigationLabel = 'Монументы';
    protected static ?string $modelLabel = 'Монумент';
    protected static ?string $pluralModelLabel = 'Монументы';

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Название монумента')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('city_id')
                    ->relationship('city', 'name')
                    ->label('Город расположения' )
                    ->required()
                   ->preload(),
                Forms\Components\TextInput::make('ticket_price')
                ->label('Цена билета в $')
                ->suffixIcon('heroicon-m-currency-dollar')

                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                ->label('Описание монумента')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('images')
                ->label('Изображения монумента')
                    ->image()
                    ->avatar()
                    ->multiple()
                    ->columnSpanFull(),
                    Select::make('company_id')
                    ->label('Owning Company')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
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
                ->label('Название монумента')
                    ->searchable(),
                     TextColumn::make('company.name')
                ->label('Owning Company')
                ->sortable()
                ->searchable()
                ->toggleable(),  // optional: let the user hide/show
                Tables\Columns\TextColumn::make('city.name')
                ->label('Город расположения')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ticket_price')
                ->label('Цена билета в $')
                    ->numeric()
                    ->sortable(),
                    ImageColumn::make('images')
                    ->label('Изображения монумента')
                    ->circular()
                    ->stacked()


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),  
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
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name')
                ->color('primary'), // Adds primary color to the text
            TextEntry::make('city.name')
                ->color('primary'), // Adds primary color to the city name
            TextEntry::make('ticket_price')
                ->color('primary'), // Adds primary color to the ticket price
            TextEntry::make('description')
                ->color('primary'), // Adds primary color to the description
            ImageEntry::make('images')
                ->circular()


            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMonuments::route('/'),
            'create' => Pages\CreateMonument::route('/create'),
            'edit' => Pages\EditMonument::route('/{record}/edit'),
             'view' => Pages\ViewMonument::route('/{record}'),
        ];
    }
}
