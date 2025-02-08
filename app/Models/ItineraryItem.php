<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryItem extends Model
{
    protected $fillable = [
        'date',
        'itinerary_id',
        'city_distance_id',
        'time',
        'program',
        'accommodation',
        'food',
    ];

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }

    public function cityDistance()
    {
        return $this->belongsTo(CityDistance::class);
    }
         
}
