<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (Auth::check()) {
            // Ambil waktu terakhir aktivitas dari session
            $lastActivity = Session::get('last_activity');
            
            // Timeout dalam detik (1 menit = 60 detik untuk testing, nanti ganti jadi 300 untuk 5 menit)
            $timeout = 60; // 1 menit untuk testing
            
            // Jika sudah lebih dari timeout tanpa aktivitas, logout
            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                // Logout user
                Auth::logout();
                
                // Hapus semua session
                Session::flush();
                
                // Regenerate token untuk keamanan
                $request->session()->regenerate();
                
                // Redirect ke login dengan pesan
                return redirect()->route('login')
                    ->with('info', '⏰ Sesi Anda telah berakhir karena tidak ada aktivitas selama 1 menit. Silakan login kembali.');
            }
            
            // Update waktu terakhir aktivitas (setiap request)
            Session::put('last_activity', time());
        }
        
        return $next($request);
    }
}