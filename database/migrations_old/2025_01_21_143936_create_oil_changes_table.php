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
        Schema::create('oil_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transport_id')->constrained()->onDelete('cascade');
            $table->date('oil_change_date');
            $table->unsignedBigInteger('mileage_at_change');
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('oil_type')->nullable();
            $table->string('service_center')->nullable();
            $table->text('notes')->nullable();
            $table->json('other_services')->nullable();
            $table->date('next_change_date')->nullable();
            $table->integer('next_change_mileage')->nullable();
            $table->decimal('oil_cost', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_changes');
    }
};
