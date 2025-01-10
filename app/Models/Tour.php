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
     'end_date',];

    public function tourDays(): HasMany
    {
        return $this->hasMany(TourDay::class);
    }

    

    
}