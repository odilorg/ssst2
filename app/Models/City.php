<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class City extends Model
{
    protected $fillable = ['name', 'description', 'images'];

    protected $casts = [
        'images' => 'array',
    ];
    public function tourDays(): BelongsToMany
    {
        return $this->belongsToMany(TourDay::class, 'city_tour_day', 'city_id', 'tour_day_id')
                    ->withTimestamps();
    }
    
}
