<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class TourDay extends Model
{
    protected $fillable = [
        'tour_id',
        'name',
        'description',
        'type',
        'image',
        'price_type_name',
    ];
public function isFullyBooked(): bool
{
    // This method will be updated when we implement the new assignment system
    return false;
}


    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

      // 1) Day number (1-based index)
    public function getDayNumberAttribute(): int
    {
        // make sure tourDays are loaded
        $days = $this->tour->relationLoaded('tourDays')
            ? $this->tour->tourDays
            : $this->tour->tourDays()->get();

        // find your position in the collection
        $position = $days->pluck('id')->search($this->id);

        return $position === false ? 0 : $position + 1;
    }

    // 2) Check-in at 14:00 on your day
    public function getCheckInAttribute(): Carbon
    {
        return Carbon::parse($this->tour->start_date)
            ->addDays($this->day_number - 1)
            ->setTime(14, 0);
    }

    // 3) Check-out at 12:00 the next morning
    public function getCheckOutAttribute(): Carbon
    {
        return Carbon::parse($this->tour->start_date)
            ->addDays($this->day_number)
            ->setTime(12, 0);
    }
    



}
