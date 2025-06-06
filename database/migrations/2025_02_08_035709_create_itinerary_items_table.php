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
        Schema::create('itinerary_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->foreignId('itinerary_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_distance_id')->constrained()->cascadeOnDelete();
            $table->time('time')->nullable();
            $table->string('program');
            $table->boolean('accommodation')->nullable();
            $table->boolean('food')->nullable();
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_items');
    }

   
};
