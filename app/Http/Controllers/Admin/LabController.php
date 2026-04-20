<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use Illuminate\Http\Request;

class LabController extends Controller
{
    /**
     * Cek apakah admin punya akses ke lab tertentu
     */
    private function checkLabAccess(Lab $lab)
    {
        if (auth()->user()->lab_id !== $lab->id) {
            abort(403, 'Anda tidak memiliki akses ke lab ini.');
        }
    }

    /**
     * Tampilkan lab milik admin ini saja
     */
    public function index()
    {
        $admin = auth()->user();

        if (!$admin->lab_id) {
            return view('admin.lab.index', ['lab' => null])
                ->with('warning', 'Anda belum di-assign ke lab manapun. Hubungi Super Admin.');
        }

        $lab = Lab::withCount('lacis')->find($admin->lab_id);

        return view('admin.lab.index', compact('lab'));
    }

    /**
     * Admin tidak boleh buat lab baru
     */
    public function create()
    {
        abort(403, 'Admin Lab tidak memiliki izin untuk membuat lab baru.');
    }

    public function store(Request $request)
    {
        abort(403, 'Admin Lab tidak memiliki izin untuk membuat lab baru.');
    }

    /**
     * Form edit lab (hanya lab miliknya)
     */
    public function edit(Lab $lab)
    {
        $this->checkLabAccess($lab);
        return view('admin.lab.edit', compact('lab'));
    }

    /**
     * Update lab (hanya lab miliknya, tidak bisa ubah kode_lab)
     */
    public function update(Request $request, Lab $lab)
    {
        $this->checkLabAccess($lab);

        $request->validate([
            'nama_lab'  => 'required|string|max:255',
            'lokasi'    => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'required|in:aktif,nonaktif',
        ], [
            'nama_lab.required' => 'Nama lab harus diisi',
            'status.required'   => 'Status harus dipilih',
        ]);

        // Admin hanya bisa update info dasar, TIDAK bisa ubah kode_lab
        $lab->update($request->only(['nama_lab', 'lokasi', 'deskripsi', 'status']));

        return redirect()->route('admin.lab.index')
            ->with('success', 'Informasi lab berhasil diupdate!');
    }

    /**
     * Admin tidak boleh hapus lab
     */
    public function destroy(Lab $lab)
    {
        abort(403, 'Admin Lab tidak memiliki izin untuk menghapus lab.');
    }
}