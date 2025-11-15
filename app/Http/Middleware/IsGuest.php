<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware IsGuest
 * Memastikan route hanya bisa diakses oleh user yang BELUM login
 * Jika sudah login, akan di-redirect ke halaman sesuai role-nya
 * Berguna untuk halaman login/register agar user yang sudah login tidak bisa akses
 */
class IsGuest
{
    /**
     * Handle an incoming request.
     * Redirect user yang sudah login ke dashboard sesuai role-nya
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (auth()->check()) {
            // Jika role admin, redirect ke dashboard admin
            if (auth()->user()->role === 'admin') {
                return redirect('/admin/general-report');
            }
            // Jika role user, redirect ke halaman riwayat pesanan
            elseif (auth()->user()->role === 'user') {
                return redirect('/user/history');
            }
        }

        // Jika belum login, lanjutkan ke halaman yang diminta (login/register)
        return $next($request);
    }
}
