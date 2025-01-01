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
        Schema::create('meal_type_restaurant_tour_days', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('meal_type_id');
            $table->foreignId('restaurant_id');
            $table->foreignId('tour_day_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_type_restaurant_tour_days');
    }
};
