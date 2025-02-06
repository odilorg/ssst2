<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $fillable = [
        'tour_group_code',
         'itinerary',
         'transport_id',
         'tour_id',
         'km_start',
         'km_end'
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
}
