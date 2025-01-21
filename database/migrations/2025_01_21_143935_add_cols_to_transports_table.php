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
        Schema::table('transports', function (Blueprint $table) {
            $table->integer('oil_change_interval_months');
            $table->integer('oil_change_interval_km');
            $table->decimal('fuel_consumption', 8, 2);
            $table->enum('fuel_type', ['diesel', 'benzin/propane','natural gas']);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transports', function (Blueprint $table) {
            //
        });
    }
};
