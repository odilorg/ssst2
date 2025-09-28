<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tour_day_transport', function ($table) {
        $table->boolean('is_booked')->default(false);
    });

    Schema::table('tour_day_hotels', function ($table) {
        $table->boolean('is_booked')->default(false);
    });

    Schema::table('meal_type_restaurant_tour_days', function ($table) {
        $table->boolean('is_booked')->default(false);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_day_related', function (Blueprint $table) {
            //
        });
    }
};
