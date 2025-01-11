<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['name',
     'address',
     'category',
     'city_id',
     'type',
     'description',
      'images',
    'description',
    'phone',
    'email',
    'images'
    ];

    // public function days(): BelongsToMany
    // {
    //     return $this->belongsToMany(Day::class)->withPivot(['number_of_rooms','number_of_nights','agreed_price'])->withTimestamps();
    // }
    protected $casts = [
        'images' => 'array',
    ];
    
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
     public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
