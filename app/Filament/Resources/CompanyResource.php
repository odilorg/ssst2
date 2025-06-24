<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Hotel;
use App\Models\Company;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use App\Jobs\GenerateVoucherTemplatePdf;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CompanyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompanyResource\RelationManagers;
use Filament\Pages\Actions;


class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address_street')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('address_city')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('inn')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('account_number')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('bank_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('bank_mfo')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('director_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('license_number')
                    ->label('License Number')
                    ->maxLength(255)
                    ->default(null)
                    ->helperText('Optional: If your company has a license number, please provide it here.'),
                // Optional: Add a select field for hotels                
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->maxSize(1024),
                Forms\Components\Toggle::make('is_operator')
                    ->label('Is Tour Operator')
                    ->helperText('Mark this company as your own tour-operator profile'),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
          // make operator‐flagged companies come first…
        ->defaultSort('is_operator', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('hotels_list')
                    ->label('Hotels')
                    ->state(function ($record) {
                        return $record->hotels->pluck('name')->implode(', ');
                    })
                    ->wrap()
                    ->limit(50) // Optional: trims long lists
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_street')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('inn')

                    ->sortable(),
                Tables\Columns\TextColumn::make('account_number')

                    ->sortable(),
                Tables\Columns\TextColumn::make('bank_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_mfo')

                    ->sortable(),
                Tables\Columns\TextColumn::make('director_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('logo')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                  // ← new “Regenerate Voucher” button
             Tables\Actions\Action::make('regenerateVoucher')
                ->label('Regenerate Voucher Template')
                ->icon('heroicon-o-document-text')
                ->requiresConfirmation()
                ->action(fn() => GenerateVoucherTemplatePdf::dispatch())
                ->successNotificationTitle('Voucher template regeneration queued'),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('hotels');
    }
}
