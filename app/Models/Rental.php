<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Rental
 * Merepresentasikan data pemesanan/rental mobil oleh user
 * Terhubung dengan tabel 'rentals' di database
 */
class Rental extends Model
{
    /**
     * Field yang boleh diisi secara mass assignment
     */
    protected $fillable = [
        'user_id',         // ID user yang memesan (foreign key ke tabel users)
        'so_number',       // Nomor Sales Order (booking ID unik)
        'car_id',          // ID mobil yang dipesan (foreign key ke tabel cars)
        'pickup_date',     // Tanggal pengambilan mobil
        'return_date',     // Tanggal pengembalian mobil
        'pickup_time',     // Jam pengambilan mobil
        'return_time',     // Jam pengembalian mobil
        'pickup_location', // Lokasi pengambilan mobil
        'is_confirmed',    // Apakah sudah dikonfirmasi admin (true/false)
        'total_price',     // Total harga yang harus dibayar
        'status',          // Status pembayaran (unpaid/paid/cancelled)
        'with_driver',     // Apakah menyewa dengan supir (true/false)
    ];

    /**
     * Relasi ke model Car
     * Setiap rental belongs to (dimiliki oleh) satu mobil
     * Relasi many-to-one (banyak rental bisa untuk 1 mobil)
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Relasi ke model User
     * Setiap rental belongs to (dimiliki oleh) satu user
     * Relasi many-to-one (banyak rental bisa dimiliki 1 user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
