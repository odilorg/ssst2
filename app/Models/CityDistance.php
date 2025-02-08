<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityDistance extends Model
{
   protected $fillable = [
       'city_from_to',
       'distance_km'
   ];
}
