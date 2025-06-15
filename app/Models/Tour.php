<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    protected $fillable = ['name', 'description', 'tour_number',
     'number_people',
     'tour_duration',
     'start_date',
     'end_date',
     'image',
     'tour_file',
     'country'
    ];

    public function tourDays(): HasMany
    {
        return $this->hasMany(TourDay::class);
    }

    public function estimates(): HasMany
    {
        return $this->hasMany(Estimate::class);
    }
public function bookingProgressPercentage(): int
{
    $total = $this->tourDays->count();

    if ($total === 0) return 0;

    $ready = $this->tourDays->filter(fn($day) => $day->isFullyBooked())->count();

    return intval(($ready / $total) * 100);
}



    

    
}