<?php

namespace App\Filament\Pages;

use App\Models\TourDay;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;

class BookingProgressDetail extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-globe-europe-africa';

    protected static string $view = 'filament.pages.booking-progress-detail';

    protected static ?string $navigationLabel = 'Booking Detail';

    protected static ?string $title = 'Booking Detail';

    /** @var int */
    public $tourId;

    public function mount(): void
    {
        // Read ?tour=123 from URL
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
                TextColumn::make('name')->label('Day'),
                TextColumn::make('cities.name')->label('City')->badge()->limit(1),

              IconColumn::make('guide')
    ->label('Guide')
    ->boolean()
    ->state(fn ($record) => ! $record->guide_id || $record->is_guide_booked),


              IconColumn::make('hotel')
    ->label('Hotel')
    ->boolean()
    ->state(fn ($record) =>
        $record->tourDayHotels->isEmpty() ||
        $record->tourDayHotels->every(fn ($h) => $h->is_booked)
    ),

IconColumn::make('transport')
    ->label('Transport')
    ->boolean()
    ->state(fn ($record) =>
        $record->tourDayTransports->isEmpty() ||
        $record->tourDayTransports->every(fn ($t) => $t->is_booked)
    ),

IconColumn::make('restaurant')
    ->label('Restaurant')
    ->boolean()
    ->state(fn ($record) =>
        $record->mealTypeRestaurantTourDays->isEmpty() ||
        $record->mealTypeRestaurantTourDays->every(fn ($m) => $m->is_booked)
    ),
            ])
            ->filters([
                // optional: filter per day name, city, etc.
            ]);
    }
}
