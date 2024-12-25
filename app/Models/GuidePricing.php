<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuidePricing extends Model
{
    use HasFactory;
    protected $fillable = ['guide_id','language','daily_rate','start_date','end_date'];
}
