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
        Schema::create('booking_itinerary_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('tour_itinerary_item_id')->nullable()->constrained('itinerary_items')->onDelete('set null');
            $table->boolean('is_custom')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->string('status')->default('planned');
            $table->date('date');
            $table->string('type');
            $table->integer('sort_order')->default(0);
            $table->string('title');
            $table->text('description')->nullable();
            $table->time('planned_start_time')->nullable();
            $table->integer('planned_duration_minutes')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_itinerary_items');
    }
};
