<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourDay extends Model
{
    protected $fillable = [
        'tour_id',
        'name',
        'description',
        'guide_id',
         'transport_id',
         'hotel_id',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    public function tourDayTransports(): HasMany
    {
        return $this->hasMany(TourDayTransport::class); ;
    }
       
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    
    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }




}
