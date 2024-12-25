<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'daily_rate'];

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class)->withPivot(['number_of_days','agreed_price'])->withTimestamps();
    }

    public function pricings()
    {
        return $this->hasMany(GuidePricing::class);
    }

    public function getPriceForLanguage(string $language, $date = null): ?float
    {
       $query= $this->pricings()->where('language', $language);
        if ($date) {
            $query->where(function ($q) use ($date) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $date);
            })->where(function ($q) use ($date) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $date);
            });
        }
       $pricing= $query->latest()->first();
       return $pricing ? $pricing->daily_rate: null;
    }
}
