<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'address_street',
        'address_city',
        'phone',
        'email',
        'inn',
        'account_number',
        'bank_name',
        'bank_mfo',
        'director_name',
        'logo',
        'is_operator',
        'license_number',
    ];

    public function hotels(): HasMany
{
    return $this->hasMany(Hotel::class);
}
protected $casts = [
    'is_operator' => 'boolean',
];

}
