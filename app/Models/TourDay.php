<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        
    ];

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
       
//     public function hotels()
// {
//     return $this->belongsToMany(Hotel::class, 'tour_day_hotels', 'tour_day_id', 'hotel_id')->withPivot('type');
// }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    
    public function transportType()
    {
        return $this->belongsTo(TransportType::class);
    }
    // public function hotelRooms()
    // {
    //     return $this->hasMany(HotelTourDayRoom::class); // HasMany with the pivot model
    // }
    // public function hotelRooms()
    // {
    //     return $this->hasManyThrough(Room::class, Hotel::class, 'id', 'hotel_id', 'id', 'id');
    // }
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
    



}
