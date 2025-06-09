<?php

namespace App\Filament\Pages;

use App\Models\Tour;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;

class BookingProgressReport extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-globe-europe-africa';
    protected static ?string $navigationLabel = 'Booking Progress';
    protected static ?string $title = 'Booking Progress Report';
    protected static string $view = 'filament.pages.booking-progress-report';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tour::query()
                    ->with(['tourDays.tourDayHotels', 'tourDays.tourDayTransports', 'tourDays.mealTypeRestaurantTourDays', 'tourDays'])
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Tour Name')
                    ->searchable(),

                TextColumn::make('progress')
    ->label('Progress %')
    ->getStateUsing(function (Tour $record): string {
        // 1) Total selected subs across all days
        $totalSelected = $record->tourDays->reduce(function (int $carry, $day): int {
            // guide
            $carry += $day->guide_id ? 1 : 0;
            // hotels
            $carry += $day->tourDayHotels->count();
            // transports
            $carry += $day->tourDayTransports->count();
            // restaurants
            $carry += $day->mealTypeRestaurantTourDays->count();
            return $carry;
        }, 0);

        // 2) Total actually booked
        $totalBooked = $record->tourDays->reduce(function (int $carry, $day): int {
            // guide
            $carry += ($day->guide_id && $day->is_guide_booked) ? 1 : 0;
            // hotels
            $carry += $day->tourDayHotels
                ->filter(fn($h) => $h->is_booked)
                ->count();
            // transports
            $carry += $day->tourDayTransports
                ->filter(fn($t) => $t->is_booked)
                ->count();
            // restaurants
            $carry += $day->mealTypeRestaurantTourDays
                ->filter(fn($r) => $r->is_booked)
                ->count();
            return $carry;
        }, 0);

        // 3) Render
        if ($totalSelected === 0) {
            return '—';
        }

        return (string) intval($totalBooked * 100 / $totalSelected) . '%';
    })
    ->sortable(),

                TextColumn::make('tourWideMissing')
                    ->label('Tour-Wide Missing')
                    ->getStateUsing(function (Tour $record): string {
                        return $record->tourDays
                            ->map(function ($day) {
                                $missing = [];
                                if ($day->guide_id && !$day->is_guide_booked) {
                                    $missing[] = 'Guide';
                                }
                                if ($day->tourDayHotels->isNotEmpty() && $day->tourDayHotels->some(function ($h) { return !$h->is_booked; })) {
                                    $missing[] = 'Hotel';
                                }
                                if ($day->tourDayTransports->isNotEmpty() && $day->tourDayTransports->some(function ($t) { return !$t->is_booked; })) {
                                    $missing[] = 'Transport';
                                }
                                if ($day->mealTypeRestaurantTourDays->isNotEmpty() && $day->mealTypeRestaurantTourDays->some(function ($r) { return !$r->is_booked; })) {
                                    $missing[] = 'Restaurant';
                                }
                                return count($missing)
                                    ? $day->name . ': ' . implode(', ', $missing)
                                    : null;
                            })
                            ->filter()
                            ->implode(' | ');
                    })
                    ->wrap()
                    ->toggleable(),

               
            ])
            ->actions([
            Action::make('view')
                ->label('View Details')
                ->icon('heroicon-o-eye')
                ->url(fn (Tour $record) => BookingProgressDetail::getUrl([
                    'tour' => $record->id,
                ]))
                ->openUrlInNewTab(),
        ])
            ->filters([
                SelectFilter::make('city')
                    ->label('City')
                    ->query(function (Builder $query) {
                        $query->whereHas('tourDays.cities');
                    })
                    ->options(fn () => \App\Models\City::pluck('name', 'id')),
            ])
            ->defaultSort('name');
    }
}
