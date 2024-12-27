<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    protected $fillable = ['name', 'description', 'tour_number'];

    public function tourDays(): HasMany
    {
        return $this->hasMany(TourDay::class);
    }
}