<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login dengan NIM
     */
    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'password' => 'required',
        ], [
            'nim.required' => 'Username (NIM) harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        // Cari user berdasarkan NIM
        $user = User::where('nim', $request->nim)->first();

        if (!$user) {
            return back()->withErrors([
                'nim' => 'NIM tidak ditemukan.',
            ])->withInput($request->only('nim'));
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'nim' => 'NIM atau password salah.',
            ])->withInput($request->only('nim'));
        }

        // Login user
        Auth::login($user, $request->has('remember'));
        $request->session()->regenerate();

        // Redirect berdasarkan role
        if ($user->isSuperAdmin()) {
            return redirect()->route('super-admin.dashboard')
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }
        
        if ($user->isUserAdmin()) {
            return redirect()->route('user-admin.dashboard')
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return redirect()->route('user.dashboard')
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah logout.');
    }
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    /**
     * Extract NIM dari email
     * Format email: nama.NIM@student.atmi.ac.id atau nama.NIM@atmi.ac.id
     * Contoh: angela.20232006@student.atmi.ac.id -> NIM: 20232006
     */
    private function extractNimFromEmail($email)
    {
        // Ambil bagian sebelum @
        $localPart = explode('@', $email)[0];
        
        // Split berdasarkan titik
        $parts = explode('.', $localPart);
        
        // Cek dari belakang, cari yang berupa angka
        for ($i = count($parts) - 1; $i >= 0; $i--) {
            if (is_numeric($parts[$i])) {
                \Log::info('NIM extracted: ' . $parts[$i] . ' from email: ' . $email);
                return $parts[$i];
            }
        }
        
        \Log::warning('NIM not found in email: ' . $email);
        return null;
    }
    
    public function handleGoogleCallback()
{
    try {
        \Log::info('=== GOOGLE CALLBACK STARTED ===');
        
        $googleUser = Socialite::driver('google')->stateless()->user();
        
        \Log::info('Google User Data:', [
            'id' => $googleUser->getId(),
            'email' => $googleUser->getEmail(),
            'name' => $googleUser->getName(),
        ]);

        $email = $googleUser->getEmail();
        
        \Log::info('Validating email: ' . $email);
        
        if (!Str::endsWith($email, ['@student.atmi.ac.id', '@atmi.ac.id'])) {
            \Log::warning('Email tidak valid: ' . $email);
            return redirect()->route('login')
                ->withErrors(['nim' => 'Gunakan email resmi ATMI.']);
        }

        \Log::info('Email valid, searching for user...');

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $email)
            ->first();

        if ($user) {
            \Log::info('User found:', ['id' => $user->id, 'email' => $user->email]);
            
            // ✅ CEK APAKAH GOOGLE LOGIN DINONAKTIFKAN
            if ($user->google_login_enabled === false) {
                \Log::warning('Google login disabled for user: ' . $user->email);
                return redirect()->route('login')
                    ->withErrors(['nim' => 'Login dengan Google telah dinonaktifkan untuk akun Anda. Silakan login menggunakan NIM dan password.']);
            }
        } else {
            \Log::info('User not found, will create new user');
        }

        $roleMapping = [
            'nicolaus.20232024@student.atmi.ac.id' => 'super_admin',
            'indrayana.20236027@student.atmi.ac.id' => 'user_admin',
            'angela.20232006@student.atmi.ac.id' => 'admin',
        ];

        $assignedRole = $roleMapping[$email] ?? 'user';
        
        \Log::info('Assigned role for ' . $email . ': ' . $assignedRole);

        $extractedNim = $this->extractNimFromEmail($email);

        if (!$user) {
            \Log::info('Creating new user...');
            
            $defaultPassword = $extractedNim ?? 'password123';
            
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make($defaultPassword),
                'role' => $assignedRole,
                'nim' => $extractedNim,
                'koin' => 10,
                'no_hp' => null,
                'jurusan' => null,
                'google_login_enabled' => true, // ✅ Default aktif untuk user baru
            ]);
            
            \Log::info('User created successfully');
        } else {
            \Log::info('Updating existing user...');
            
            $updateData = [
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'role' => $assignedRole,
            ];
            
            if (empty($user->nim) && $extractedNim) {
                $updateData['nim'] = $extractedNim;
                $updateData['password'] = Hash::make($extractedNim);
            }
            
            $user->update($updateData);
            
            \Log::info('User updated successfully');
        }

        \Log::info('Logging in user...');
        Auth::login($user, true);
        \Log::info('User logged in successfully');

        \Log::info('Redirecting to dashboard...');
        return redirect()->route('redirect');

    } catch (\Exception $e) {
        \Log::error('=== GOOGLE LOGIN ERROR ===');
        \Log::error('Error Message: ' . $e->getMessage());
        \Log::error('Error Trace: ' . $e->getTraceAsString());
        
        return redirect()->route('login')
            ->withErrors(['nim' => 'Login Google gagal: ' . $e->getMessage()]);
    }
}

}