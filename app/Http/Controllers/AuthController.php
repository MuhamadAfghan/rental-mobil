<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman utama/landing page
     * Menampilkan semua mobil yang tersedia untuk disewa
     */
    public function home()
    {
        $cars = Car::all(); // Ambil semua data mobil dari database
        return view('welcome', compact('cars'));
    }

    /**
     * Menampilkan halaman form login
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Memproses login user
     * Mendukung login dengan email atau username
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Deteksi apakah user login dengan email atau username
        // filter_var() dengan FILTER_VALIDATE_EMAIL mengecek apakah input berbentuk email
        $fieldType = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Coba login dengan credential yang diberikan
        if (auth()->attempt([$fieldType => $credentials['email'], 'password' => $credentials['password']])) {
            // Regenerate session untuk keamanan (mencegah session fixation attack)
            $request->session()->regenerate();

            // Redirect berdasarkan role user
            if (auth()->user()->role === 'user') {
                return redirect()->intended('/user/history');
            }
            // Jika bukan user, berarti admin
            return redirect()->intended('/admin/general-report');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Logout user dan redirect ke halaman utama
     */
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    /**
     * Menampilkan halaman form registrasi
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Menyimpan data user baru (registrasi)
     * Password otomatis di-hash untuk keamanan
     */
    public function storeRegister(Request $request)
    {
        // Validasi input registrasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username', // username harus unik
            'email' => 'required|string|email|max:255|unique:users,email', // email harus unik
            'password' => 'required|string',

            'phone_number' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        // Enkripsi password sebelum disimpan ke database
        // JANGAN PERNAH simpan password dalam bentuk plain text!
        $validated['password'] = bcrypt($validated['password']);

        // Simpan user baru ke database
        User::create($validated);

        return redirect('/login')->with('success', 'Registration successful. Please login.');
    }
}
