<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $fillable = [
        'tour_group_code',
        'transport_id',
        'tour_id',
        'company_id',
        'km_start',
        'km_end',
        'fuel_expenditure_factual',
        'fuel_expenditure',
        'accommodation',
        'food',
        'file_name',
        'number',
        'itinerary_number',
        'fuel_remaining_liter'
        // 'itinerary' // remove if you're no longer using the old JSON field
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }

     public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function itineraryItems()
    {
        return $this->hasMany(ItineraryItem::class);
    }

    /**
     * Consolidated Eloquent model events in a single boot() method.
     */
    protected static function boot()
    {
        parent::boot();

        // Before creation: set placeholder values
        static::creating(function (Itinerary $itinerary) {
            // Example: set placeholders
            $itinerary->number = 'TEMP';
            $itinerary->itinerary_number = 'EST0000' . date('mY');
        });

        // After creation: finalize number/itinerary_number
        static::created(function (Itinerary $itinerary) {
            $month = now()->month;
            $year = ($month >= 11) ? now()->year + 1 : now()->year;

            // Example final 'number', e.g. "EST-2025-005"
            $itinerary->number = "EST-$year-" . Str::padLeft($itinerary->id, 3, '0');

            // Example final itinerary_number
            $itinerary->itinerary_number = 'EST' . $itinerary->id . date('mY');

            // Use saveQuietly() to avoid re-triggering model events
            $itinerary->saveQuietly();
        });
    }
}
