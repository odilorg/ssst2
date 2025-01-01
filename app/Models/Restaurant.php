<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'website',
        'email',
        'city_id'
    ];

    public function mealTypes()
    {
        return $this->hasMany(MealType::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
