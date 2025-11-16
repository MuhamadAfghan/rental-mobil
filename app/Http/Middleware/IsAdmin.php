<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware IsAdmin
 * Memastikan hanya user dengan role 'admin' yang bisa mengakses route tertentu
 * Jika bukan admin, akan menampilkan error 403 Forbidden
 */
class IsAdmin
{
    /**
     * Handle an incoming request.
     * Method ini dipanggil otomatis oleh Laravel setiap ada request ke route yang menggunakan middleware ini
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN role-nya adalah 'admin'
        // auth()->check() = mengecek apakah user sudah login
        // auth()->user()->role = mengambil role dari user yang login
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request); // Lanjutkan request ke controller
        }

        // Jika bukan admin, tampilkan error 403 (Forbidden/Tidak punya akses)
        abort(403, 'Tidak bisa diakses oleh Anda. Role saat ini: ' . (auth()->check() ? auth()->user()->role : 'belum login'));
    }
}
