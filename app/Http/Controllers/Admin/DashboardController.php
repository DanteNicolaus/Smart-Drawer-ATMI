<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard admin dengan data real-time
     */
    public function index()
    {
        // Statistik utama
        $totalPeminjaman = Peminjaman::count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $sudahDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();
        $alatTersedia = Alat::where('status', 'tersedia')->where('jumlah_tersedia', '>', 0)->count();
        
        // Peminjaman pending (butuh persetujuan)
        $pendingApproval = Peminjaman::with(['user', 'alat'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();
        
        // Peminjaman yang sedang aktif
        $peminjamanAktif = Peminjaman::with(['user', 'alat'])
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->latest()
            ->take(5)
            ->get();
        
        // Alat yang stok menipis
        $alatMenipis = Alat::where('jumlah_tersedia', '<=', 3)
            ->where('jumlah_tersedia', '>', 0)
            ->orderBy('jumlah_tersedia', 'asc')
            ->take(5)
            ->get();
        
        // Statistik per kategori
        $statistikKategori = Alat::selectRaw('kategori, COUNT(*) as total, SUM(jumlah_tersedia) as tersedia')
            ->groupBy('kategori')
            ->get();
        
        // Peminjaman terakhir
        $peminjamanTerakhir = Peminjaman::with(['user', 'alat'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalPeminjaman',
            'sedangDipinjam',
            'sudahDikembalikan',
            'alatTersedia',
            'pendingApproval',
            'peminjamanAktif',
            'alatMenipis',
            'statistikKategori',
            'peminjamanTerakhir'
        ));
    }

    /**
     * API untuk mendapatkan data dashboard (untuk real-time update)
     */
    public function getDashboardData()
    {
        return response()->json([
            'totalPeminjaman' => Peminjaman::count(),
            'sedangDipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'sudahDikembalikan' => Peminjaman::where('status', 'dikembalikan')->count(),
            'alatTersedia' => Alat::where('status', 'tersedia')->where('jumlah_tersedia', '>', 0)->count(),
            'pendingCount' => Peminjaman::where('status', 'pending')->count(),
        ]);
    }
}
