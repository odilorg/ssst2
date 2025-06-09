<?php

namespace App\Filament\Pages;

use App\Models\TourDay;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;

class BookingProgressReport extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-globe-europe-africa';

    protected static string $view = 'filament.pages.booking-progress-report';

    protected static ?string $navigationLabel = 'Booking Progress';

    protected static ?string $title = 'Booking Progress Report';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TourDay::query()
                    ->with(['tour', 'cities', 'tourDayHotels', 'tourDayTransports', 'mealTypeRestaurantTourDays'])
            )
            ->columns([
                TextColumn::make('tour.name')
                    ->label('Tour')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Day Name')
                    ->searchable(),

                TextColumn::make('cities.name')
                    ->label('City')
                    ->badge()
                    ->limit(1),

                IconColumn::make('is_guide_booked')
                    ->label('Guide')
                    ->state(fn ($record) => !$record->guide_id || $record->is_guide_booked)
                    ->boolean(),

                IconColumn::make('hotel_status')
                    ->label('Hotel')
                    ->state(fn ($record) =>
                        $record->tourDayHotels->isEmpty() || $record->tourDayHotels->every(fn($h) => (bool) $h->is_booked)
                    )
                    ->boolean(),

                IconColumn::make('transport_status')
                    ->label('Transport')
                    ->state(fn ($record) =>
                        $record->tourDayTransports->isEmpty() || $record->tourDayTransports->every(fn($t) => (bool) $t->is_booked)
                    )
                    ->boolean(),

                IconColumn::make('restaurant_status')
                    ->label('Restaurant')
                    ->state(fn ($record) =>
                        $record->mealTypeRestaurantTourDays->isEmpty() || $record->mealTypeRestaurantTourDays->every(fn($r) => (bool) $r->is_booked)
                    )
                    ->boolean(),

                TextColumn::make('status_summary')
                    ->label('Missing')
                    ->state(function ($record) {
                        $missing = [];

                        if ($record->guide_id && !$record->is_guide_booked) {
                            $missing[] = 'Guide';
                        }

                        if ($record->tourDayHotels->isNotEmpty() && $record->tourDayHotels->some(fn($h) => !$h->is_booked)) {
                            $missing[] = 'Hotel';
                        }

                        if ($record->tourDayTransports->isNotEmpty() && $record->tourDayTransports->some(fn($t) => !$t->is_booked)) {
                            $missing[] = 'Transport';
                        }

                        if ($record->mealTypeRestaurantTourDays->isNotEmpty() && $record->mealTypeRestaurantTourDays->some(fn($r) => !$r->is_booked)) {
                            $missing[] = 'Restaurant';
                        }

                        return count($missing) ? implode(', ', $missing) : '✅ All Ready';
                    }),

                TextColumn::make('missing_details_by_day')
                    ->label('Tour-Wide Missing')
                    ->state(function ($record) {
                        return $record->tour->tourDays->map(function ($day) {
                            $missing = [];

                            if ($day->guide_id && !$day->is_guide_booked) {
                                $missing[] = 'Guide';
                            }

                            if ($day->tourDayHotels->isNotEmpty() && $day->tourDayHotels->some(fn($h) => !$h->is_booked)) {
                                $missing[] = 'Hotel';
                            }

                            if ($day->tourDayTransports->isNotEmpty() && $day->tourDayTransports->some(fn($t) => !$t->is_booked)) {
                                $missing[] = 'Transport';
                            }

                            if ($day->mealTypeRestaurantTourDays->isNotEmpty() && $day->mealTypeRestaurantTourDays->some(fn($r) => !$r->is_booked)) {
                                $missing[] = 'Restaurant';
                            }

                            return count($missing)
                                ? $day->name . ': ' . implode(', ', $missing)
                                : null;
                        })->filter()->implode(' | ');
                    })
                    ->wrap()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('tour_id')
                    ->label('Tour')
                    ->relationship('tour', 'name'),

                SelectFilter::make('city')
                    ->label('City')
                    ->query(fn (Builder $query) => $query->with('cities'))
                    ->options(fn () => \App\Models\City::pluck('name', 'id')),
            ]);
    }
}