<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'license_number',
        'license_expiry_date',
        'license_image',
        'profile_image',
    ];
}
