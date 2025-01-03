<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Estimate;
use Filament\Forms\Form;
use App\Mail\SendEstimate;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EstimateResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EstimateResource\RelationManagers;

class EstimateResource extends Resource
{
    protected static ?string $model = Estimate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('estimate_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('estimate_date')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required()
                    ->preload(),
                Forms\Components\Select::make('tour_id')
                ->relationship('tour', 'name')    
                ->required()
                    ->preload(),
                
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
                Tables\Columns\TextColumn::make('estimate_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estimate_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tour.name')
                    ->numeric()
               
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-s-cloud-arrow-down')
                    ->visible(fn(Estimate $record): bool => !is_null($record->file_name))
                    ->action(function (Estimate $record) {
                        return response()->download(storage_path('app/public/estimates/') . $record->file_name);
                    }),

                    Tables\Actions\Action::make('send_contract')
                    ->icon('heroicon-o-envelope')
                    ->visible(fn(Estimate $record): bool => !is_null($record->file_name))
                    ->action(function (Estimate $record) {
                        Mail::to($record->client_email)->queue(new SendEstimate($record));
                    }),

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
            'index' => Pages\ListEstimates::route('/'),
            'create' => Pages\CreateEstimate::route('/create'),
            'edit' => Pages\EditEstimate::route('/{record}/edit'),
        ];
    }
}
