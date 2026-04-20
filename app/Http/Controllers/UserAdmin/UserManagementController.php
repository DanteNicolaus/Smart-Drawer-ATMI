<?php

namespace App\Http\Controllers\UserAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class UserManagementController extends Controller
{
    /**
     * Dashboard User Admin
     */
    public function dashboard()
    {
        try {
            $totalUsers = User::where('role', 'user')->count();
            $activeUsers = User::where('role', 'user')
                ->where('koin', '>', 0)
                ->count();
            
            // User terbaru (5 user terakhir)
            // Tambah whereNotNull untuk memastikan created_at tidak null
            $recentUsers = User::where('role', 'user')
                ->whereNotNull('created_at')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return view('user-admin.dashboard', compact('totalUsers', 'activeUsers', 'recentUsers'));
            
        } catch (\Exception $e) {
            // Jika error, set nilai default
            $totalUsers = 0;
            $activeUsers = 0;
            $recentUsers = collect(); // Empty collection
            
            return view('user-admin.dashboard', compact('totalUsers', 'activeUsers', 'recentUsers'))
                ->with('error', 'Terjadi kesalahan saat memuat dashboard.');
        }
    }

    /**
     * Tampilkan daftar semua user
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan jurusan
        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->where('jurusan', $request->jurusan);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Ambil daftar jurusan untuk filter
        $jurusans = User::where('role', 'user')
            ->whereNotNull('jurusan')
            ->distinct()
            ->pluck('jurusan');

        return view('user-admin.users.index', compact('users', 'jurusans'));
    }

    /**
     * Tampilkan form untuk membuat user baru
     * DIPERBAIKI: Pastikan view exists dan tidak ada error
     */
    public function create()
    {
        try {
            return view('user-admin.users.create');
        } catch (\Exception $e) {
            // Jika view tidak ditemukan atau ada error
            return redirect()->route('user-admin.users.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Simpan user baru ke database
     * DIPERBAIKI: Validasi lengkap dan error handling
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'nim' => 'required|string|max:20|unique:users,nim',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'jurusan' => 'required|string|max:100',
                'no_hp' => 'nullable|string|max:20',
            ], [
                'name.required' => 'Nama harus diisi',
                'nim.required' => 'NIM harus diisi',
                'nim.unique' => 'NIM sudah terdaftar',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'jurusan.required' => 'Jurusan harus diisi',
            ]);

            // Buat user baru
            $user = User::create([
                'name' => $validated['name'],
                'nim' => $validated['nim'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'jurusan' => $validated['jurusan'],
                'no_hp' => $validated['no_hp'] ?? null,
                'role' => 'user',
                'koin' => 10, // Koin awal untuk user baru
            ]);

            return redirect()->route('user-admin.users.index')
                ->with('success', 'User berhasil ditambahkan! Koin awal: 10');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Error validasi
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            // Error lainnya
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form untuk edit user
     */
    public function edit(User $user)
    {
        try {
            // Pastikan hanya bisa edit user dengan role 'user'
            if ($user->role !== 'user') {
                return redirect()->route('user-admin.users.index')
                    ->with('error', 'Tidak dapat mengedit user ini!');
            }

            return view('user-admin.users.edit', compact('user'));
            
        } catch (\Exception $e) {
            return redirect()->route('user-admin.users.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Update data user
     */
    public function update(Request $request, User $user)
    {
        try {
            // Pastikan hanya bisa edit user dengan role 'user'
            if ($user->role !== 'user') {
                return redirect()->route('user-admin.users.index')
                    ->with('error', 'Tidak dapat mengedit user ini!');
            }

            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'nim' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => 'nullable|string|min:8|confirmed',
                'jurusan' => 'required|string|max:100',
                'no_hp' => 'nullable|string|max:20',
                'koin' => 'required|integer|min:0',
            ], [
                'name.required' => 'Nama harus diisi',
                'nim.required' => 'NIM harus diisi',
                'nim.unique' => 'NIM sudah terdaftar',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'jurusan.required' => 'Jurusan harus diisi',
                'koin.required' => 'Koin harus diisi',
                'koin.min' => 'Koin tidak boleh negatif',
            ]);

            // Update data user
            $user->name = $validated['name'];
            $user->nim = $validated['nim'];
            $user->email = $validated['email'];
            $user->jurusan = $validated['jurusan'];
            $user->no_hp = $validated['no_hp'] ?? null;
            $user->koin = $validated['koin'];

            // Update password jika diisi
            if ($request->filled('password')) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            return redirect()->route('user-admin.users.index')
                ->with('success', 'Data user berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        try {
            // Pastikan hanya bisa hapus user dengan role 'user'
            if ($user->role !== 'user') {
                return redirect()->route('user-admin.users.index')
                    ->with('error', 'Tidak dapat menghapus user ini!');
            }

            // Cek apakah user masih memiliki peminjaman aktif
            $activePeminjaman = $user->peminjaman()
                ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
                ->count();

            if ($activePeminjaman > 0) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat menghapus user yang masih memiliki peminjaman aktif!');
            }

            $user->delete();

            return redirect()->route('user-admin.users.index')
                ->with('success', 'User berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function exportExcel(Request $request)
{
    $query = User::where('role', 'user');

    // Filter berdasarkan pencarian
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('nim', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('jurusan', 'like', "%{$search}%");
        });
    }

    // Filter berdasarkan jurusan
    if ($request->has('jurusan') && $request->jurusan != '') {
        $query->where('jurusan', $request->jurusan);
    }

    $users = $query->orderBy('created_at', 'desc')->get();

    $filename = 'Data_Users_' . date('Y-m-d_His') . '.csv';

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    return view('user-admin.users.export-excel', compact('users'));
}

/**
 * Export data users ke PDF
 */
public function exportPdf(Request $request)
{
    $query = User::where('role', 'user');

    // Filter berdasarkan pencarian
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('nim', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('jurusan', 'like', "%{$search}%");
        });
    }

    // Filter berdasarkan jurusan
    if ($request->has('jurusan') && $request->jurusan != '') {
        $query->where('jurusan', $request->jurusan);
    }

    $users = $query->orderBy('created_at', 'desc')->get();

    $pdf = Pdf::loadView('user-admin.users.export-pdf', compact('users'))
        ->setPaper('A4', 'landscape'); // Landscape untuk tabel yang lebih lebar

    return $pdf->download('Data_Users_' . date('Y-m-d_His') . '.pdf');
}
}