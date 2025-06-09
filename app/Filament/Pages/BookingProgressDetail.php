<?php

namespace App\Filament\Pages;

use App\Models\TourDay;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class BookingProgressDetail extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-globe-europe-africa';
    protected static string $view = 'filament.pages.booking-progress-detail';
    protected static ?string $navigationLabel = 'Booking Detail';
    protected static ?string $title = 'Booking Detail';

    public int $tourId;

    public function mount(): void
    {
        $this->tourId = (int) request()->query('tour', 0);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TourDay::query()
                    ->where('tour_id', $this->tourId)
                    ->with(['cities', 'tourDayHotels', 'tourDayTransports', 'mealTypeRestaurantTourDays'])
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Day'),

                TextColumn::make('cities.name')
                    ->label('City')
                    ->badge()
                    ->limit(1),

                IconColumn::make('guide_status')
                    ->label('Guide')
                    ->boolean()
                    ->state(fn ($record) =>
                        $record->guide_id
                            ? (bool) $record->is_guide_booked
                            : null
                    ),

                IconColumn::make('hotel_status')
                    ->label('Hotel')
                    ->boolean()
                    ->state(fn ($record) =>
                        $record->tourDayHotels->isEmpty()
                            ? null
                            : $record->tourDayHotels->every(fn ($h) => (bool) $h->is_booked)
                    ),

                IconColumn::make('transport_status')
                    ->label('Transport')
                    ->boolean()
                    ->state(fn ($record) =>
                        $record->tourDayTransports->isEmpty()
                            ? null
                            : $record->tourDayTransports->every(fn ($t) => (bool) $t->is_booked)
                    ),

                IconColumn::make('restaurant_status')
                    ->label('Restaurant')
                    ->boolean()
                    ->state(fn ($record) =>
                        $record->mealTypeRestaurantTourDays->isEmpty()
                            ? null
                            : $record->mealTypeRestaurantTourDays->every(fn ($r) => (bool) $r->is_booked)
                    ),
            ]);
    }
}
