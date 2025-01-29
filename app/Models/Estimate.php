<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Support\Str;
use App\Jobs\GenerateEstimatePdf;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    protected $fillable = [
        'guide_id',
        'hotel_id',
        'estimate_number',
        'estimate_date',
        'notes',
        'customer_id',
        'tour_id',
        'transport_id',
        'file_name',
        'markup',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    protected static function booted()
    {
        static::creating(function ($estimate) {
            // Handle estimate year based on the month
            $month = now()->month;
            $year = $month >= 11 ? now()->year + 1 : now()->year; // Use next year if it's November or December

            // Temporarily assign a placeholder number (needed for saving)
            $estimate->number = 'TEMP';
        });

        static::created(function ($estimate) {
            // Handle estimate year based on the month
            $month = now()->month;
            $year = $month >= 11 ? now()->year + 1 : now()->year;

            // Generate the estimate number using the actual ID
            $estimate->number = "EST-$year-" . Str::padLeft($estimate->id, 3, '0');

            // Save the updated estimate number
            $estimate->saveQuietly();

            // Dispatch the job to generate the estimate PDF
            GenerateEstimatePdf::dispatch($estimate);
        });
    }


    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        // Placeholder for estimate_number during creation (if required)
        $model->estimate_number = 'EST0000' . date('mY');
    });

    static::created(function ($model) {
        // Update estimate_number after the ID is assigned
        $model->estimate_number = 'EST' . $model->id . date('mY');
        $model->save();
    });
}
}
