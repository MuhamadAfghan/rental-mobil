<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Car
 * Merepresentasikan data mobil yang tersedia untuk disewa
 * Terhubung dengan tabel 'cars' di database
 */
class Car extends Model
{
    /**
     * Field yang boleh diisi secara mass assignment
     * Mass assignment = mengisi banyak field sekaligus menggunakan array
     * Contoh: Car::create(['name' => 'Avanza', 'price_per_day' => 250000])
     *
     * Jika field tidak ada di $fillable, maka tidak bisa diisi dengan mass assignment
     * Ini untuk keamanan, mencegah user mengisi field yang tidak seharusnya
     */
    protected $fillable = [
        'name',          // Nama mobil (misal: Toyota Avanza)
        'brand',         // Merk mobil (misal: Toyota)
        'year',          // Tahun produksi
        'color',         // Warna mobil
        'fuel_type',     // Jenis bahan bakar (bensin/diesel)
        'transmission',  // Jenis transmisi (automatic/manual)
        'seats',         // Jumlah kursi penumpang
        'baggage',       // Kapasitas bagasi (jumlah koper)
        'price_per_day', // Harga sewa per hari
        'images',        // Path gambar mobil dalam format JSON array
        'driver',        // Apakah tersedia dengan supir (1/0)
        'is_available',  // Status ketersediaan mobil (true/false)
    ];
}
