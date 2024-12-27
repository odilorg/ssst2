<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransportPrice extends Model
{
    protected $fillable=[
        'transport_type_id',
        'price_type',
        'cost'
    ];

    public function transportType()
{
    return $this->belongsTo(TransportType::class, 'transport_type_id', 'id');
}
}
