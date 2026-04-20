<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Laci;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    /**
     * Hanya tampilkan alat dari laci yang ada di lab admin ini
     */
    public function index()
    {
        $adminLabId = auth()->user()->lab_id;

        $alat = Alat::with('laci')
            ->whereHas('laci', function($q) use ($adminLabId) {
                $q->where('lab_id', $adminLabId);
            })
            ->latest()
            ->paginate(10);

        return view('admin.alat.index', compact('alat'));
    }

    /**
     * Form tambah alat - hanya laci dari lab admin ini
     */
    public function create()
    {
        $adminLabId = auth()->user()->lab_id;

        $lacis = Laci::aktif()
            ->where('lab_id', $adminLabId)
            ->orderBy('kode_laci')
            ->get();

        return view('admin.alat.create', compact('lacis'));
    }

    /**
     * Simpan alat baru - pastikan laci milik lab admin
     */
    public function store(Request $request)
    {
        $adminLabId = auth()->user()->lab_id;

        $request->validate([
            'kode_alat'          => 'required|unique:alat',
            'nama_alat'          => 'required|string|max:255',
            'deskripsi'          => 'nullable|string',
            'kategori'           => 'required|string',
            'jumlah_total'       => 'required|integer|min:1',
            'kondisi'            => 'required|in:baik,rusak ringan,rusak berat',
            'lokasi_penyimpanan' => 'nullable|string',
            'foto'               => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'laci_id'            => 'nullable|exists:laci,id',
        ]);

        // Validasi: laci harus milik lab admin ini
        if ($request->laci_id) {
            $laci = Laci::find($request->laci_id);
            if (!$laci || $laci->lab_id !== $adminLabId) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Laci yang dipilih bukan milik lab Anda!');
            }
        }

        $data                    = $request->all();
        $data['jumlah_tersedia'] = $request->jumlah_total;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('alat', 'public');
        }

        Alat::create($data);

        return redirect()->route('admin.alat.index')
            ->with('success', 'Alat berhasil ditambahkan!');
    }

    /**
     * Form edit alat - pastikan alat milik lab admin
     */
    public function edit(Alat $alat)
    {
        $adminLabId = auth()->user()->lab_id;

        // Cek alat ini milik lab admin
        if ($alat->laci && $alat->laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke alat ini.');
        }

        $lacis = Laci::aktif()
            ->where('lab_id', $adminLabId)
            ->orderBy('kode_laci')
            ->get();

        return view('admin.alat.edit', compact('alat', 'lacis'));
    }

    /**
     * Update alat - pastikan alat & laci milik lab admin
     */
    public function update(Request $request, Alat $alat)
    {
        $adminLabId = auth()->user()->lab_id;

        // Cek alat ini milik lab admin
        if ($alat->laci && $alat->laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke alat ini.');
        }

        $request->validate([
            'kode_alat'          => 'required|unique:alat,kode_alat,' . $alat->id,
            'nama_alat'          => 'required|string|max:255',
            'deskripsi'          => 'nullable|string',
            'kategori'           => 'required|string',
            'jumlah_total'       => 'required|integer|min:1',
            'kondisi'            => 'required|in:baik,rusak ringan,rusak berat',
            'lokasi_penyimpanan' => 'nullable|string',
            'foto'               => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'laci_id'            => 'nullable|exists:laci,id',
        ]);

        // Validasi: laci harus milik lab admin ini
        if ($request->laci_id) {
            $laci = Laci::find($request->laci_id);
            if (!$laci || $laci->lab_id !== $adminLabId) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Laci yang dipilih bukan milik lab Anda!');
            }
        }

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($alat->foto) {
                Storage::disk('public')->delete($alat->foto);
            }
            $data['foto'] = $request->file('foto')->store('alat', 'public');
        }

        if ($request->jumlah_total != $alat->jumlah_total) {
            $selisih               = $request->jumlah_total - $alat->jumlah_total;
            $data['jumlah_tersedia'] = $alat->jumlah_tersedia + $selisih;
        }

        $alat->update($data);

        return redirect()->route('admin.alat.index')
            ->with('success', 'Data alat berhasil diupdate!');
    }

    /**
     * Hapus alat - pastikan milik lab admin
     */
    public function destroy(Alat $alat)
    {
        $adminLabId = auth()->user()->lab_id;

        if ($alat->laci && $alat->laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke alat ini.');
        }

        if ($alat->peminjaman()->whereIn('status', ['pending', 'disetujui', 'dipinjam'])->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus alat yang sedang dipinjam!');
        }

        if ($alat->foto) {
            Storage::disk('public')->delete($alat->foto);
        }

        $alat->delete();

        return redirect()->route('admin.alat.index')
            ->with('success', 'Alat berhasil dihapus!');
    }

    /**
     * Toggle status - pastikan milik lab admin
     */
    public function toggleStatus(Alat $alat)
    {
        $adminLabId = auth()->user()->lab_id;

        if ($alat->laci && $alat->laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke alat ini.');
        }

        $alat->update([
            'status' => $alat->status === 'tersedia' ? 'tidak_tersedia' : 'tersedia'
        ]);

        return redirect()->back()
            ->with('success', 'Status alat berhasil diubah!');
    }
}