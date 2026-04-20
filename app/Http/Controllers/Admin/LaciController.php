<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laci;
use App\Models\Lab;
use Illuminate\Http\Request;

class LaciController extends Controller
{
    /**
     * Hanya tampilkan laci dari lab milik admin ini
     */
    public function index()
    {
        $adminLabId = auth()->user()->lab_id;

        $lacis = Laci::withCount('alat')
            ->where('lab_id', $adminLabId)
            ->latest()
            ->paginate(15);

        return view('admin.laci.index', compact('lacis'));
    }

    /**
     * Form tambah laci - tidak perlu pilih lab karena otomatis lab admin
     */
    public function create()
    {
        $adminLab = auth()->user()->lab;

        if (!$adminLab) {
            return redirect()->route('admin.laci.index')
                ->with('error', 'Anda belum di-assign ke lab manapun. Hubungi Super Admin.');
        }

        return view('admin.laci.create', compact('adminLab'));
    }

    /**
     * Simpan laci baru - lab_id otomatis dari lab admin, user tidak bisa ganti
     */
    public function store(Request $request)
    {
        $adminLabId = auth()->user()->lab_id;

        if (!$adminLabId) {
            return redirect()->route('admin.laci.index')
                ->with('error', 'Anda belum di-assign ke lab manapun. Hubungi Super Admin.');
        }

        $request->validate([
            'kode_laci' => 'required|unique:laci,kode_laci',
            'nama_laci' => 'required|string|max:255',
            'lokasi'    => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'required|in:aktif,nonaktif',
        ], [
            'kode_laci.required' => 'Kode laci harus diisi',
            'kode_laci.unique'   => 'Kode laci sudah digunakan',
            'nama_laci.required' => 'Nama laci harus diisi',
            'status.required'    => 'Status harus dipilih',
        ]);

        Laci::create([
            'kode_laci' => $request->kode_laci,
            'nama_laci' => $request->nama_laci,
            'lab_id'    => $adminLabId, // ← otomatis dari lab admin, tidak bisa dimanipulasi
            'lokasi'    => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'status'    => $request->status,
        ]);

        return redirect()->route('admin.laci.index')
            ->with('success', 'Laci berhasil ditambahkan!');
    }

    /**
     * Form edit laci - pastikan laci milik lab admin
     */
    public function edit(Laci $laci)
    {
        $adminLabId = auth()->user()->lab_id;

        // Pastikan laci ini milik lab admin
        if ($laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke laci ini.');
        }

        $adminLab = auth()->user()->lab;

        return view('admin.laci.edit', compact('laci', 'adminLab'));
    }

    /**
     * Update laci - lab_id tidak boleh diubah
     */
    public function update(Request $request, Laci $laci)
    {
        $adminLabId = auth()->user()->lab_id;

        // Pastikan laci ini milik lab admin
        if ($laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke laci ini.');
        }

        $request->validate([
            'kode_laci' => 'required|unique:laci,kode_laci,' . $laci->id,
            'nama_laci' => 'required|string|max:255',
            'lokasi'    => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'required|in:aktif,nonaktif',
        ], [
            'kode_laci.required' => 'Kode laci harus diisi',
            'kode_laci.unique'   => 'Kode laci sudah digunakan',
            'nama_laci.required' => 'Nama laci harus diisi',
        ]);

        // lab_id tidak diupdate, tetap milik lab admin
        $laci->update([
            'kode_laci' => $request->kode_laci,
            'nama_laci' => $request->nama_laci,
            'lokasi'    => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'status'    => $request->status,
        ]);

        return redirect()->route('admin.laci.index')
            ->with('success', 'Laci berhasil diupdate!');
    }

    /**
     * Hapus laci - pastikan milik lab admin
     */
    public function destroy(Laci $laci)
    {
        $adminLabId = auth()->user()->lab_id;

        // Pastikan laci ini milik lab admin
        if ($laci->lab_id !== $adminLabId) {
            abort(403, 'Anda tidak memiliki akses ke laci ini.');
        }

        $laci->alat()->update(['laci_id' => null]);
        $laci->delete();

        return redirect()->route('admin.laci.index')
            ->with('success', 'Laci berhasil dihapus!');
    }
}