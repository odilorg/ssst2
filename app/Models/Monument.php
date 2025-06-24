<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Monument extends Model
{
    protected $fillable = ['name', 'city', 'ticket_price', 'description', 'city_id', 'images', 'company_id', 'voucher'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

     public function company(): BelongsTo
{
    return $this->belongsTo(Company::class);
}

    protected $casts = [
        'images' => 'array',
    ];
}
