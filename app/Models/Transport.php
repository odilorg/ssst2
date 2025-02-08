<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transport extends Model
{
    protected $fillable = [
        'plate_number',
        'model',
        'number_of_seat',
        'category',
        'transport_type_id',
        'departure_time',
        'arrival_time',
       'driver_id',
        'city_id',
        'images',
        'fuel_type',
        'oil_change_interval_months',
        'oil_change_interval_km',
        'fuel_consumption',
        'fuel_remaining_liters',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function oilChanges()
    {
        return $this->hasMany(OilChange::class);
    }

    public function latestOilChange()
    {
        return $this->oilChanges()->latest('oil_change_date')->first();
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function transportType()
    {
        return $this->belongsTo(TransportType::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

}
