<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\BookingRequest;
use App\Mail\SendBookingRequest;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BookingRequestResource\Pages;
use App\Filament\Resources\BookingRequestResource\RelationManagers;

class BookingRequestResource extends Resource
{
    protected static ?string $model = BookingRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tour_id')
                    ->relationship('tour', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('request_number')
    ->label('Req. #')
    ->sortable()
    ->searchable(),
                Tables\Columns\TextColumn::make('tour.name')->label('Tour'),
                Tables\Columns\TextColumn::make('date')->date()->label('Date'),
                Tables\Columns\IconColumn::make('file_name')
                    ->label('PDF')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download PDF')
                    ->icon('heroicon-s-cloud-arrow-down')
                    ->visible(fn(BookingRequest $r) => ! is_null($r->file_name))
                    ->action(
                        fn(BookingRequest $r) =>
                        response()->download(
                            storage_path("app/public/booking_requests/{$r->file_name}")
                        )
                    ),
                // ← New “Send” action
                Tables\Actions\Action::make('send_booking_request')
                    ->label(label: 'Send Booking Request')
                    ->icon('heroicon-o-envelope')
                    ->requiresConfirmation()
                    ->visible(fn(BookingRequest $record): bool => ! is_null($record->file_name))
                    ->action(function (BookingRequest $record) {
                        Mail::to($record->email)            // assuming you have an `email` field
                            ->queue(new SendBookingRequest($record));
                    })
                    ->successNotificationTitle('Booking request queued for sending'),
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
            'index' => Pages\ListBookingRequests::route('/'),
            'create' => Pages\CreateBookingRequest::route('/create'),
            'edit' => Pages\EditBookingRequest::route('/{record}/edit'),
        ];
    }
}
