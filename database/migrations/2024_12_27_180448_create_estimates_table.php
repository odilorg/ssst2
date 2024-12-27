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
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('estimate_number')->unique();
            $table->date('estimate_date');
            $table->text('notes')->nullable();
            $table->foreignId('customer_id');        
            $table->foreignId('tour_id');
            $table->foreignId('guide_id');
            $table->foreignId('transport_id');
            $table->foreignId('hotel_id');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
