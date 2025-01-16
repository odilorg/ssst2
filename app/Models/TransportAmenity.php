<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportAmenity extends Model
{
    protected $fillable = [
        'name',
    ];

    public function transports()
    {
        return $this->belongsToMany(Transport::class);
    }
}
