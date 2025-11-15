<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware IsUser
 * Memastikan hanya user dengan role 'user' (customer) yang bisa mengakses route tertentu
 * Jika bukan user, akan menampilkan error 403 Forbidden
 */
class IsUser
{
    /**
     * Handle an incoming request.
     * Method ini dipanggil otomatis oleh Laravel setiap ada request
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN role-nya adalah 'user'
        if (auth()->check() && auth()->user()->role === 'user') {
            return $next($request); // Lanjutkan ke controller
        }

        // Jika bukan user, tampilkan error 403
        abort(403, 'Unauthorized');
    }
}
