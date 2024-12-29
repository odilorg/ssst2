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
        Schema::create('monument_tour_days', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('monument_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tour_day_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monument_tour_days');
    }
};
