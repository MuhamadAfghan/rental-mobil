<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function home()
    {
        $cars = Car::all();
        return view('welcome', compact('cars'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Try to login with email or username
        $fieldType = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (auth()->attempt([$fieldType => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            if (auth()->user()->role === 'user') {
                return redirect()->intended('/user/history');
            }
            return redirect()->intended('/admin/general-report');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function storeRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string',

            'phone_number' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect('/login')->with('success', 'Registration successful. Please login.');
    }
}