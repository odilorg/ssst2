<?php

namespace App\Models;

use App\Models\MealType;
use Illuminate\Database\Eloquent\Model;

class MealTypeRestaurantTourDay extends Model
{
    protected $fillable = [
        'meal_type_id',
        'restaurant_id',
        'tour_day_id',
    ];
    protected $table = 'meal_type_restaurant_tour_days';

    public function mealType()
    {
        return $this->belongsTo(MealType::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function tourDay()
    {
        return $this->belongsTo(TourDay::class);
    }
}
