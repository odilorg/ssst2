<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourDayTransport extends Model
{
    protected $fillable = [
        'tour_day_id',
        'transport_id',
        'price_type',
    ];
    protected $table = 'tour_day_transport'; // Specify the table name explicitly

    public function tourDay()
    {
        return $this->belongsTo(TourDay::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }
}
