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
        Schema::create('transportations', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // e.g., "Bus", "Train", "Flight"
            $table->string('provider')->nullable();
            $table->decimal('cost_per_unit', 10, 2)->default(0); // Cost per trip, per person, etc.
            $table->timestamps();
            $table->string('vehicle_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportations');
    }
};
