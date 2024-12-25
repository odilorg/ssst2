<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransportationPricing extends Model
{
    use HasFactory;
    protected $fillable = ['transportation_id','vehicle_type','cost_per_unit','start_date','end_date'];
}
