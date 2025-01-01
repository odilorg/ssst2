<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monument extends Model
{
    protected $fillable = ['name', 'city', 'ticket_price', 'description', 'city_id', 'images'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected $casts = [
        'images' => 'array',
    ];
}
