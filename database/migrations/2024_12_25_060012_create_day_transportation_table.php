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
        Schema::create('day_transportation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('day_id')->constrained()->onDelete('cascade');
            $table->foreignId('transportation_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1); // Number of buses, train tickets, etc.
                $table->decimal('agreed_price', 10, 2)->nullable(); // Overriding price for this booking
            $table->timestamps();
            $table->unique(['day_id', 'transportation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_transportation');
    }
};
