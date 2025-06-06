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
        'city_id',
        'menu_images'
    ];

    protected $casts = [
        'menu_images' => 'array'
    ];

    public function mealTypes()
    {
        return $this->hasMany(MealType::class, 'restaurant_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
