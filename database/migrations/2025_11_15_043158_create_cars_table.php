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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');
            $table->integer('seats');
            $table->integer('baggage');
            $table->enum('transmission', ['manual', 'automatic']);
            $table->enum('fuel_type', ['bensin', 'diesel', 'electric', 'hybrid']);
            $table->decimal('price_per_day', 10, 2);
            $table->json('images')->nullable();
            $table->boolean('driver');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
