<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $fillable = [
        'plate_number',
        'model',
        'number_of_seat',
        'transportation_id',
        'category',
        'transport_type_id'
    ];

    public function transportation()
    {
        return $this->belongsTo(Transportation::class);
    }

    public function transportType()
    {
        return $this->belongsTo(TransportType::class);
    }
}
