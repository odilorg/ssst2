<?php

namespace App\Models;

use App\Jobs\GenerateBookingRequestPdf;
use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    protected $fillable = [
        'tour_id',
        'date',
        'file_name',
        'request_number',
        'tour_voucher_file',
    ];

    
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    protected static function booted()
    {
        static::created(function (BookingRequest $request) {
            // Dispatch PDF‐generation
            GenerateBookingRequestPdf::dispatch($request);
        });
    }
}
