<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Resources\DriverResource\RelationManagers;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Tour Items';
    protected static ?string $navigationLabel = 'Водители';
    protected static ?string $modelLabel = 'Водитель';
    protected static ?string $pluralModelLabel = 'Водители';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('ФИО')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('phone')
                    ->label('Телефон')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                ->label('Адрес')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('license_number')
                ->label('Серия и номер водительского удостоверения')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('license_expiry_date')
                ->label('Дата окончания действия водительского удостоверения')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\FileUpload::make('license_image')
                    ->label('Фото водительского удостоверения')
                    ->image(),
                Forms\Components\FileUpload::make('profile_image')
                    ->label('Фото профиля')
                    ->image(),
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
                ->label('ФИО')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                    Tables\Columns\ImageColumn::make('profile_image')
                    ->label('Фото профиля'),
                Tables\Columns\TextColumn::make('address')
                    ->label('Адрес')
                    ->searchable(),
                   
                Tables\Columns\TextColumn::make('license_number')
                ->label('Серия и номер водительского удостоверения')
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_expiry_date')
                ->label('Дата окончания действия водительского удостоверения')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('license_image')
                ->label('Фото водительского удостоверения'),
               
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
