<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Day extends Model
{
    use HasFactory;

    protected $fillable = ['tour_id', 'day_number', 'description'];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class)->withPivot(['number_of_rooms','number_of_nights','agreed_price'])->withTimestamps();
    }

    public function transportations(): BelongsToMany
    {
        return $this->belongsToMany(Transportation::class)->withPivot(['quantity','agreed_price'])->withTimestamps();
    }
    public function guides(): BelongsToMany
    {
        return $this->belongsToMany(Guide::class)->withPivot(['number_of_days','agreed_price'])->withTimestamps();
    }

    // Day.php

public function getTotalHotelCost(): float
{
    $total = 0;
    foreach ($this->hotels as $hotel) {
        $total += ($hotel->pivot->agreed_price ?? $hotel->cost_per_night) * $hotel->pivot->number_of_rooms * $hotel->pivot->number_of_nights;
    }
    return $total;
}

public function getTotalTransportationCost($date = null): float
{
    $total = 0;
    foreach ($this->transportations as $transportation) {
        $price = $transportation->getPriceForVehicleType($transportation->pivot->vehicle_type, $date);
        if ($price === null){
            throw new \Exception("Price not found for vehicle type {$transportation->pivot->vehicle_type} on ". ($date ?? 'any date'));
        }
        $total += ($transportation->pivot->agreed_price ?? $price) * $transportation->pivot->quantity;
    }
    return $total;
}

public function getTotalGuideCost($date = null): float
{
    $total = 0;
    foreach ($this->guides as $guide) {
        $price = $guide->getPriceForLanguage($guide->pivot->language, $date);
        if ($price === null){
            throw new \Exception("Price not found for language {$guide->pivot->language} on ". ($date ?? 'any date'));
        }
        $total += ($guide->pivot->agreed_price ?? $price) * $guide->pivot->number_of_days;
    }
    return $total;
}

public function getTotalDayCost($date = null): float
{
    return $this->getTotalHotelCost() + $this->getTotalTransportationCost($date) + $this->getTotalGuideCost($date);
}
}
