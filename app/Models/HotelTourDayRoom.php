<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class HotelTourDayRoom extends Pivot
{
    protected $table = 'tour_day_hotel_room';

    protected $fillable = ['tour_day_id', 'hotel_id', 'room_id', 'quantity'];

    public function tourDay()
    {
        return $this->belongsTo(TourDay::class, 'tour_day_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function hotelRoom()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
