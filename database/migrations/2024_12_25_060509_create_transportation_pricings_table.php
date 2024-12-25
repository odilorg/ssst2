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
        Schema::create('transportation_pricings', function (Blueprint $table) {
            $table->id();
    $table->foreignId('transportation_id')->constrained()->onDelete('cascade');
    $table->string('vehicle_type');
    $table->decimal('cost_per_unit', 10, 2);
    $table->date('start_date')->nullable(); // Optional: For date-based pricing
    $table->date('end_date')->nullable();   // Optional: For date-based pricing
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportation_pricings');
    }
};
