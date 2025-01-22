<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\OilChange;
use App\Models\Transport;
use function Livewire\on;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OilChangeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OilChangeResource\RelationManagers;

class OilChangeResource extends Resource
{
    protected static ?string $model = OilChange::class;
    protected static ?string $navigationGroup = 'Tour Items';

    protected static ?string $navigationParentItem = 'Транспорт';
    protected static ?string $navigationLabel = 'Замена Масла';
    protected static ?string $modelLabel = 'Замена Масла';
    protected static ?string $pluralModelLabel = 'Замены Масла';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('transport_id')
    ->label('Транспортное средство')
    ->relationship('transport', 'plate_number')
    ->required()
    ->preload()
    ->live(onBlur: true) // Make reactive to trigger updates
    ->afterStateUpdated(function ($state, callable $set) {
        if ($state) {
            $transport = Transport::find($state);

            if ($transport) {
                // Set intervals from Transport attributes
                $set('next_change_date', now()->addMonths($transport->oil_change_interval_months)->format('Y-m-d'));
                $set('next_change_mileage', $transport->oil_change_interval_km);
            }
        }
    }),
Forms\Components\DatePicker::make('oil_change_date')
    ->label('Дата замены масла')
    ->required()
    ->native(false)
    // ->format('d/m/Y')
    ->live(onBlur: true)
    ->afterStateUpdated(function ($state, callable $set, $get) {
        // Recalculate next_change_date if the oil_change_date is updated
        $transport = Transport::find($get('transport_id'));

        if ($transport && $state) {
            $nextChangeDate = \Carbon\Carbon::parse($state)->addMonths($transport->oil_change_interval_months);
            $set('next_change_date', $nextChangeDate->format('Y-m-d'));
        }
    }),
Forms\Components\TextInput::make('mileage_at_change')
    ->label('Пробег при замене')
    ->required()
    ->numeric()
    ->live(onBlur: true)
    ->afterStateUpdated(function ($state, callable $set, $get) {
        // Recalculate next_change_mileage if mileage_at_change is updated
        $transport = Transport::find($get('transport_id'));

        if ($transport) {
            $nextChangeMileage = $state + $transport->oil_change_interval_km;
            $set('next_change_mileage', $nextChangeMileage);
        }
    }),
Forms\Components\TextInput::make('cost')
    ->label('Стоимость')
    ->numeric()
    ->default(null)
    ->prefix('UZS'),
Forms\Components\TextInput::make('oil_type')
    ->label('Тип масла')
    ->maxLength(255)
    ->default(null),
Forms\Components\TextInput::make('service_center')
    ->label('Сервисный центр')
    ->maxLength(255)
    ->default(null),
Forms\Components\Textarea::make('notes')
    ->label('Примечания')
    ->columnSpanFull(),
Forms\Components\DatePicker::make('next_change_date')
    ->label('Дата следующей замены')
    ->native(false)
    ->readOnly(), // Disable manual editing since it's auto-calculated
Forms\Components\TextInput::make('next_change_mileage')
    ->label('Пробег для следующей замены')
    ->numeric()
    ->readOnly() // Disable manual editing since it's auto-calculated
    ->default(null),

    Section::make('Дополнительные услуги')
    ->description('Добавьте дополнительные услуги, оказанные вместе с заменой масла')
    ->schema([
        Repeater::make('other_services')
    ->schema([
        TextInput::make('service_name')
            ->label('Наименование услуги')
            ->required()
            ->maxLength(255),
        TextInput::make('service_cost')
            ->label('Стоимость услуги')
            ->numeric()
            ->prefix('UZS'),
    ])
    ->addActionLabel('Добавить доп. услугу'),
    ])



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transport.plate_number')
                    //->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('oil_change_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mileage_at_change')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('next_change_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('next_change_mileage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('oil_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service_center')
                    ->searchable(),

                Tables\Columns\TextColumn::make('oil_cost')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListOilChanges::route('/'),
            'create' => Pages\CreateOilChange::route('/create'),
            'edit' => Pages\EditOilChange::route('/{record}/edit'),
        ];
    }
}
