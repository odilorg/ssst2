<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportType extends Model
{
    //

    protected $fillable = [
        'type',
        
        
    ];

    public function transportPrices()
    {
        return $this->hasMany(TransportPrice::class, 'transport_type_id', 'id');
    }
}
