<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OilChange extends Model
{
    protected $fillable = [
        'transport_id',
        'oil_change_date',
        'mileage_at_change',
        'cost',
        'oil_type',
        'service_center',
        'notes',
        'other_services',
        'next_change_date',
        'next_change_mileage',
        
    ];

    protected $casts = [
        'other_services' => 'array',
    ];

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }
}
