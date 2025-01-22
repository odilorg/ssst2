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
        Schema::create('tour_day_hotels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string(column: 'type')->nullable(); // Add type column
            $table->foreignId('tour_day_id')->constrained('tour_days')->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_day_hotels');
    }
};
