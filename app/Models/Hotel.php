<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'category', ];

    // public function days(): BelongsToMany
    // {
    //     return $this->belongsToMany(Day::class)->withPivot(['number_of_rooms','number_of_nights','agreed_price'])->withTimestamps();
    // }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
    
}
