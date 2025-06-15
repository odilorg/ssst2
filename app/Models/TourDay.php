<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class TourDay extends Model
{
    protected $fillable = [
        'tour_id',
        'name',
        'description',
        'guide_id',
         'transport_type_id',
         'hotel_id',
         'city_id',
         'restaurant_id',
         'type',
         'image',
         'price_type_name',
         'is_guide_booked',
        
    ];
public function isFullyBooked(): bool
{
    return (
        (!$this->guide_id || $this->is_guide_booked)
        && ($this->tourDayHotels->isEmpty() || $this->tourDayHotels->every(fn($h) => (bool) $h->is_booked))
        && ($this->tourDayTransports->isEmpty() || $this->tourDayTransports->every(fn($t) => (bool) $t->is_booked))
        && ($this->mealTypeRestaurantTourDays->isEmpty() || $this->mealTypeRestaurantTourDays->every(fn($r) => (bool) $r->is_booked))
    );
}


    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'city_tour_day', 'tour_day_id', 'city_id')->withTimestamps();
    }

    public function tourDayTransports(): HasMany
    {
        return $this->hasMany(TourDayTransport::class ); 
    }
       
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    
    public function transportType()
    {
        return $this->belongsTo(TransportType::class);
    }
   
    public function mealTypeRestaurantTourDays()
    {
        return $this->hasMany(MealTypeRestaurantTourDay::class, 'tour_day_id');
    }
    

    public function monuments(): BelongsToMany
    {
        return $this->belongsToMany(Monument::class, 'monument_tour_days');
    } 
     
    public function tourDayHotels(): HasMany
    {
        return $this->hasMany(TourDayHotel::class);
    }

      // 1) Day number (1-based index)
    public function getDayNumberAttribute(): int
    {
        // make sure tourDays are loaded
        $days = $this->tour->relationLoaded('tourDays')
            ? $this->tour->tourDays
            : $this->tour->tourDays()->get();

        // find your position in the collection
        $position = $days->pluck('id')->search($this->id);

        return $position === false ? 0 : $position + 1;
    }

    // 2) Check-in at 14:00 on your day
    public function getCheckInAttribute(): Carbon
    {
        return Carbon::parse($this->tour->start_date)
            ->addDays($this->day_number - 1)
            ->setTime(14, 0);
    }

    // 3) Check-out at 12:00 the next morning
    public function getCheckOutAttribute(): Carbon
    {
        return Carbon::parse($this->tour->start_date)
            ->addDays($this->day_number)
            ->setTime(12, 0);
    }
    



}
