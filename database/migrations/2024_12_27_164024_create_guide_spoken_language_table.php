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
        Schema::create('guide_spoken_language', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('guide_id')->constrained()->cascadeOnDelete();
            $table->foreignId('spoken_language_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guide_spoken_language');
    }
};
