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
        // Update tabel cars: tambah kolom is_available
        Schema::table('cars', function (Blueprint $table) {
            $table->boolean('is_available')->default(true)->after('images');
        });

        // Update tabel rentals: tambah rental_status dan hapus is_confirmed
        Schema::table('rentals', function (Blueprint $table) {
            // Hapus kolom is_confirmed
            $table->dropColumn('is_confirmed');

            // Tambah kolom rental_status untuk status penyewaan mobil
            $table->enum('rental_status', ['pending', 'ongoing', 'completed', 'cancelled'])->default('pending')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('is_available');
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn('rental_status');
            $table->boolean('is_confirmed')->default(false);
        });
    }
};
