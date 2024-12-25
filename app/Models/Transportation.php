<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transportation extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'provider', 'cost_per_unit'];

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class)->withPivot(['quantity','agreed_price'])->withTimestamps();
    }
    public function pricings()
    {
        return $this->hasMany(TransportationPricing::class);
    }
    public function getPriceForVehicleType(string $vehicleType, $date = null): ?float
    {
       $query= $this->pricings()->where('vehicle_type', $vehicleType);
        if ($date) {
            $query->where(function ($q) use ($date) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $date);
            })->where(function ($q) use ($date) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $date);
            });
        }
       $pricing= $query->latest()->first();
       return $pricing ? $pricing->cost_per_unit: null;
    }
}
