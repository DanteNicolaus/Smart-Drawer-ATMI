<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    /**
     * Helper: base query peminjaman yang hanya milik lab admin ini
     */
    private function baseQuery()
    {
        $adminLabId = auth()->user()->lab_id;

        return Peminjaman::with(['user', 'alat.laci'])
            ->whereHas('alat.laci', function($q) use ($adminLabId) {
                $q->where('lab_id', $adminLabId);
            });
    }

    /**
     * Daftar peminjaman - hanya dari lab admin ini
     */
    public function index(Request $request)
    {
        $query = $this->baseQuery()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->paginate(15);

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Form tambah peminjaman - alat hanya dari lab admin ini
     */
    public function create()
    {
        $adminLabId = auth()->user()->lab_id;

        $users = User::where('role', 'user')->orderBy('name')->get();

        $alats = Alat::where('status', 'tersedia')
            ->where('jumlah_tersedia', '>', 0)
            ->whereHas('laci', function($q) use ($adminLabId) {
                $q->where('lab_id', $adminLabId);
            })
            ->orderBy('nama_alat')
            ->get();

        return view('admin.peminjaman.create', compact('users', 'alats'));
    }

    /**
     * Simpan peminjaman - validasi alat milik lab admin
     */
    public function store(Request $request)
    {
        $adminLabId = auth()->user()->lab_id;

        $request->validate([
            'user_id'                 => 'required|exists:users,id',
            'alat_id'                 => 'required|exists:alat,id',
            'jumlah_pinjam'           => 'required|integer|min:1',
            'tanggal_pinjam'          => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keperluan'               => 'required|string|max:500',
        ], [
            'user_id.required'                 => 'User harus dipilih',
            'alat_id.required'                 => 'Alat harus dipilih',
            'jumlah_pinjam.required'           => 'Jumlah pinjam harus diisi',
            'jumlah_pinjam.min'                => 'Jumlah pinjam minimal 1',
            'tanggal_pinjam.required'          => 'Tanggal pinjam harus diisi',
            'tanggal_kembali_rencana.required' => 'Tanggal rencana kembali harus diisi',
            'tanggal_kembali_rencana.after'    => 'Tanggal kembali harus setelah tanggal pinjam',
            'keperluan.required'               => 'Keperluan peminjaman harus diisi',
        ]);

        $user = User::findOrFail($request->user_id);
        $alat = Alat::with('laci')->findOrFail($request->alat_id);

        // Pastikan alat milik lab admin ini
        if (!$alat->laci || $alat->laci->lab_id !== $adminLabId) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Alat yang dipilih bukan milik lab Anda!');
        }

        if ($user->koin < 1) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'User tidak memiliki koin yang cukup! Koin tersisa: ' . $user->koin);
        }

        if ($alat->jumlah_tersedia < $request->jumlah_pinjam) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jumlah alat tidak mencukupi! Tersedia: ' . $alat->jumlah_tersedia . ' unit');
        }

        Peminjaman::create([
            'kode_peminjaman'         => Peminjaman::generateKodePeminjaman(),
            'user_id'                 => $request->user_id,
            'alat_id'                 => $request->alat_id,
            'jumlah_pinjam'           => $request->jumlah_pinjam,
            'tanggal_pinjam'          => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'keperluan'               => $request->keperluan,
            'status'                  => 'dipinjam',
            'catatan_admin'           => 'Diinput oleh Admin Lab: ' . auth()->user()->name,
        ]);

        $user->kurangiKoin(1);
        $alat->decrement('jumlah_tersedia', $request->jumlah_pinjam);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan! Sisa koin user: ' . $user->koin);
    }

    /**
     * Detail peminjaman - validasi akses lab
     */
    public function show(Peminjaman $peminjaman)
    {
        $adminLabId = auth()->user()->lab_id;

        // Pastikan peminjaman ini terkait lab admin
        if (!$peminjaman->alat->laci || $peminjaman->alat->laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke peminjaman ini.');
        }

        $peminjaman->load(['user', 'alat']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Setujui peminjaman
     */
    public function approve(Request $request, Peminjaman $peminjaman)
    {
        $adminLabId = auth()->user()->lab_id;

        if (!$peminjaman->alat->laci || $peminjaman->alat->laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke peminjaman ini.');
        }

        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman ini sudah diproses!');
        }

        if ($peminjaman->alat->jumlah_tersedia < $peminjaman->jumlah_pinjam) {
            return redirect()->back()->with('error', 'Jumlah alat tidak mencukupi!');
        }

        $peminjaman->update([
            'status'        => 'disetujui',
            'catatan_admin' => $request->catatan_admin,
        ]);

        $peminjaman->alat->decrement('jumlah_tersedia', $peminjaman->jumlah_pinjam);

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!');
    }

    /**
     * Tolak peminjaman
     */
    public function reject(Request $request, Peminjaman $peminjaman)
    {
        $adminLabId = auth()->user()->lab_id;

        if (!$peminjaman->alat->laci || $peminjaman->alat->laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke peminjaman ini.');
        }

        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman ini sudah diproses!');
        }

        $request->validate([
            'catatan_admin' => 'required|string',
        ], [
            'catatan_admin.required' => 'Alasan penolakan harus diisi',
        ]);

        $peminjaman->update([
            'status'        => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak!');
    }

    /**
     * Proses peminjaman (alat diambil)
     */
    public function process(Peminjaman $peminjaman)
    {
        $adminLabId = auth()->user()->lab_id;

        if (!$peminjaman->alat->laci || $peminjaman->alat->laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke peminjaman ini.');
        }

        if ($peminjaman->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Peminjaman belum disetujui!');
        }

        $peminjaman->update(['status' => 'dipinjam']);

        return redirect()->back()->with('success', 'Alat sudah diambil peminjam!');
    }

    /**
     * Proses pengembalian alat
     */
    public function return(Request $request, Peminjaman $peminjaman)
    {
        $adminLabId = auth()->user()->lab_id;

        if (!$peminjaman->alat->laci || $peminjaman->alat->laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke peminjaman ini.');
        }

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Status peminjaman tidak valid!');
        }

        $request->validate([
            'kondisi_saat_kembali' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'catatan_pengembalian' => 'nullable|string',
        ]);

        $peminjaman->update([
            'status'               => 'dikembalikan',
            'tanggal_kembali_aktual' => now(),
            'kondisi_saat_kembali' => $request->kondisi_saat_kembali,
            'catatan_pengembalian' => $request->catatan_pengembalian,
        ]);

        if ($request->kondisi_saat_kembali !== 'hilang') {
            $peminjaman->alat->increment('jumlah_tersedia', $peminjaman->jumlah_pinjam);
        } else {
            $peminjaman->alat->decrement('jumlah_total', $peminjaman->jumlah_pinjam);
        }

        if ($request->kondisi_saat_kembali === 'baik') {
            $peminjaman->user->tambahKoin(1);
        }

        return redirect()->back()
            ->with('success', 'Pengembalian alat berhasil dicatat!' .
                   ($request->kondisi_saat_kembali === 'baik' ? ' Koin user dikembalikan.' : ''));
    }

    /**
     * Hapus peminjaman
     */
    public function destroy(Peminjaman $peminjaman)
    {
        $adminLabId = auth()->user()->lab_id;

        if (!$peminjaman->alat->laci || $peminjaman->alat->laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke peminjaman ini.');
        }

        if (!in_array($peminjaman->status, ['ditolak', 'dikembalikan'])) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus peminjaman yang masih aktif!');
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus!');
    }

    /**
     * Export Excel - hanya lab admin ini
     */
    public function exportExcel(Request $request)
    {
        $query = $this->baseQuery();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->get();
        $filename   = 'Riwayat_Peminjaman_' . date('Y-m-d_His') . '.csv';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        return view('admin.peminjaman.export-excel', compact('peminjaman'));
    }

    /**
     * Export PDF - hanya lab admin ini
     */
    public function exportPdf(Request $request)
    {
        $query = $this->baseQuery();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('admin.peminjaman.export-pdf', compact('peminjaman'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('Riwayat_Peminjaman_' . date('Y-m-d_His') . '.pdf');
    }
}