<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'cost_per_night'];

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class)->withPivot(['number_of_rooms','number_of_nights','agreed_price'])->withTimestamps();
    }
}
