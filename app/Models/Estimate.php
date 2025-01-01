<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    protected $fillable = [
        'guide_id',
        'hotel_id',
        'estimate_number',
        'estimate_date',
        'notes',
        'customer_id',
        'tour_id',
        'transport_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }
}
