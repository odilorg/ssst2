<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'website',
        'email',
        'city_id',
        'menu_images',
        'company_id'
    ];

    protected $casts = [
        'menu_images' => 'array'
    ];
 public function company(): BelongsTo
{
    return $this->belongsTo(Company::class);
}
    public function mealTypes()
    {
        return $this->hasMany(MealType::class, 'restaurant_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
