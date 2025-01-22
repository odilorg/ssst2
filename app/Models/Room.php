<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    protected $fillable = [
        'name',
        'description',
        'room_type_id',
        'cost_per_night',
        'hotel_id',
        'images',
        'image'
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    } 
    
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    } 

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function tourDays()
    {
        return $this->belongsToMany(TourDay::class, 'tour_day_hotel_room')
            ->withPivot('quantity')
            ->withTimestamps();
    }
   

    protected $casts = [
        'images' => 'array',
    ];

    public function hotelRooms(): HasMany
{
    return $this->hasMany(HotelRoom::class);
}
}
