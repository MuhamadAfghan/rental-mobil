<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User
 * Merepresentasikan data user (customer dan admin)
 * Extends Authenticatable untuk fitur autentikasi bawaan Laravel
 * Terhubung dengan tabel 'users' di database
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Field yang boleh diisi secara mass assignment
     * Mass assignment = mengisi banyak field sekaligus
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',         // Nama lengkap user
        'email',        // Email (harus unik)
        'password',     // Password (akan otomatis di-hash)
        'username',     // Username (harus unik)
        'phone_number', // Nomor telepon
        'role',         // Role user (admin/user)
        'address',      // Alamat lengkap
    ];

    /**
     * Field yang disembunyikan saat konversi ke JSON/Array
     * Untuk keamanan, password dan token tidak boleh ditampilkan
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',       // Password tidak boleh di-return dalam response API
        'remember_token', // Token "remember me" juga disembunyikan
    ];

    /**
     * Mendefinisikan tipe data untuk field tertentu
     * Laravel akan otomatis mengkonversi field ke tipe yang ditentukan
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Convert ke objek Carbon (datetime)
            'password' => 'hashed',            // Otomatis hash password saat di-set
        ];
    }
}
