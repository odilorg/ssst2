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
        Schema::table('transport_types', function (Blueprint $table) {
            $table->decimal('cost', 8, 2)->default(0); // Cost per trip, per person, etc.
            $table->enum('price_type', ['per_day', 'per_pickup_dropoff']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transport_types', function (Blueprint $table) {
            //
        });
    }
};
