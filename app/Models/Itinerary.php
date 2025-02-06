<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Jobs\GenerateItineraryPdf;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $fillable = [
        'tour_group_code',
         'itinerary',
         'transport_id',
         'tour_id',
         'km_start',
         'km_end',
         'fuel_expenditure_factual',
         'fuel_expenditure',
         'accommodation',
         'food',
         'file_name',
         'number',
         'itinerary_number',
         
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }

    protected $casts = [
        'itinerary' => 'array'
    ];

    protected static function booted()
    {
        static::creating(function ($itinerary) {
            // Handle tinerary year based on the month
            $month = now()->month;
            $year = $month >= 11 ? now()->year + 1 : now()->year; // Use next year if it's November or December

            // Temporarily assign a placeholder number (needed for saving)
            $itinerary->number = 'TEMP';
        });

        static::created(function ($itinerary) {
            // Handle tinerary year based on the month
            $month = now()->month;
            $year = $month >= 11 ? now()->year + 1 : now()->year;

            // Generate the tinerary number using the actual ID
            $itinerary->number = "EST-$year-" . Str::padLeft($itinerary->id, 3, '0');

            // Save the updated tinerary number
            $itinerary->saveQuietly();

            // Dispatch the job to generate the tinerary PDF
            GenerateItineraryPdf::dispatch($itinerary);
        });
    }


    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        // Placeholder for tinerary_number during creation (if required)
        $model->itinerary_number = 'EST0000' . date('mY');
    });

    static::created(function ($model) {
        // Update tinerary_number after the ID is assigned
        $model->itinerary_number = 'EST' . $model->id . date('mY');
        $model->save();
    });
}
}
