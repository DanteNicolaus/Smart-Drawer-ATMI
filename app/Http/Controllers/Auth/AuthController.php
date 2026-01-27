<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect based on role
            if (Auth::user()->isAdmin()) {
                return redirect()->intended('/dashboard')->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '! 🎉');
            }

            // Regular users cannot login for now
            Auth::logout();
            return back()->withErrors([
                'username' => 'Hanya admin yang dapat mengakses sistem saat ini.',
            ]);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $userName = Auth::user()->name;
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('logout_success', 'Terima kasih ' . $userName . ', Anda telah berhasil logout. Sampai jumpa lagi! 👋');
    }
}