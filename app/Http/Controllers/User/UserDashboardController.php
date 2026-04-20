<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;


class UserDashboardController extends Controller
{
    /**
     * Dashboard user
     */
    public function index()
    {
        $user = auth()->user();
        
        $totalPeminjaman = Peminjaman::where('user_id', $user->id)->count();
        $sedangDipinjam = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->count();
        $menungguPersetujuan = Peminjaman::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        
        $peminjamanAktif = Peminjaman::with('alat')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('user.dashboard', compact(
            'totalPeminjaman',
            'sedangDipinjam',
            'menungguPersetujuan',
            'peminjamanAktif'
        ));
    }

    // ⚠️ METHOD katalog() DIPINDAH KE KatalogController.php
    // Route 'user.katalog' sekarang ditangani oleh KatalogController@index

    /**
     * Detail alat
     */
    public function detailAlat(Alat $alat)
    {
        return view('user.detail-alat', compact('alat'));
    }

    /**
     * Form peminjaman
     */
    public function formPinjam(Alat $alat)
    {
        if (!$alat->is_available) {
            return redirect()->back()
                ->with('error', 'Alat tidak tersedia untuk dipinjam!');
        }

        return view('user.form-pinjam', compact('alat'));
    }

    /**
     * Proses peminjaman
     */
    public function storePinjam(Request $request, Alat $alat)
    {
        $request->validate([
            'jumlah_pinjam' => 'required|integer|min:1|max:' . $alat->jumlah_tersedia,
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keperluan' => 'required|string|max:500',
        ], [
            'jumlah_pinjam.required' => 'Jumlah pinjam harus diisi',
            'jumlah_pinjam.max' => 'Jumlah melebihi ketersediaan alat',
            'tanggal_pinjam.required' => 'Tanggal pinjam harus diisi',
            'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh kurang dari hari ini',
            'tanggal_kembali_rencana.required' => 'Tanggal kembali harus diisi',
            'tanggal_kembali_rencana.after' => 'Tanggal kembali harus setelah tanggal pinjam',
            'keperluan.required' => 'Keperluan peminjaman harus diisi',
        ]);

        Peminjaman::create([
            'kode_peminjaman' => Peminjaman::generateKodePeminjaman(),
            'user_id' => auth()->id(),
            'alat_id' => $alat->id,
            'jumlah_pinjam' => $request->jumlah_pinjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'keperluan' => $request->keperluan,
            'status' => 'pending',
        ]);

        return redirect()->route('user.riwayat')
            ->with('success', 'Permintaan peminjaman berhasil diajukan! Mohon tunggu persetujuan admin.');
    }

    /**
     * Riwayat peminjaman user
     */
    public function riwayat()
    {
        $riwayatPeminjaman = Peminjaman::with('alat')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.riwayat', compact('riwayatPeminjaman'));
    }

    /**
     * Detail peminjaman
     */
    public function detailPeminjaman(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        $peminjaman->load('alat');
        return view('user.detail-peminjaman', compact('peminjaman'));
    }

    /**
     * Batalkan peminjaman (hanya untuk yang pending)
     */
    public function batalkan(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        if ($peminjaman->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Tidak dapat membatalkan peminjaman ini!');
        }

        $peminjaman->update([
            'status' => 'ditolak',
            'catatan_admin' => 'Dibatalkan oleh peminjam',
        ]);

        return redirect()->back()
            ->with('success', 'Peminjaman berhasil dibatalkan!');
    }

    // ========================================
    // FITUR SETTING PROFILE
    // ========================================

    public function settings()
    {
        $user = auth()->user();
        return view('user.settings', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Nama harus diisi',
        ]);

        $user->update([
            'name' => $request->name,
            'jurusan' => $request->jurusan,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->back()
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function toggleGoogleLogin(Request $request)
    {
        $user = auth()->user();

        if (!$user->nim) {
            return redirect()->back()
                ->with('error', 'Anda harus memiliki NIM terlebih dahulu untuk mengatur login Google!');
        }

        $newStatus = !$user->google_login_enabled;
        
        $user->update([
            'google_login_enabled' => $newStatus
        ]);

        $message = $newStatus 
            ? 'Login dengan Google berhasil diaktifkan!' 
            : 'Login dengan Google berhasil dinonaktifkan! Sekarang Anda hanya bisa login dengan NIM.';

        return redirect()->back()
            ->with('success', $message);
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama harus diisi',
            'new_password.required' => 'Password baru harus diisi',
            'new_password.min' => 'Password baru minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Password lama tidak sesuai!');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()
            ->with('success', 'Password berhasil diubah!');
    }

    public function exportPdf()
    {
        $riwayatPeminjaman = Peminjaman::with('alat')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $pdf = Pdf::loadView('user.riwayat-pdf', compact('riwayatPeminjaman'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('riwayat-peminjaman.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Peminjaman::with(['alat'])
            ->where('user_id', auth()->id());

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $riwayatPeminjaman = $query->orderBy('created_at', 'desc')->get();

        $filename = 'Riwayat_Peminjaman_' . auth()->user()->name . '_' . date('Y-m-d_His') . '.csv';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        return view('user.riwayat-excel', compact('riwayatPeminjaman'));
    }
}