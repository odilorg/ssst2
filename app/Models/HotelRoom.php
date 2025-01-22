<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelRoom extends Model
{
    protected $fillable = ['tour_day_hotel_id', 'room_id', 'quantity'];

    /**
     * Relationship to TourDayHotel.
     */
    public function tourDayHotel(): BelongsTo
    {
        return $this->belongsTo(TourDayHotel::class);
    }

    /**
     * Relationship to Room.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
