<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Lab;
use App\Models\Laci;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Step 1: Tampilkan semua lab
     */
    public function index()
    {
        $labs = Lab::aktif()
            ->with(['lacis' => fn($q) => $q->where('status', 'aktif')->withCount('alat')])
            ->get();

        return view('user.katalog.index', compact('labs'));
    }

    /**
     * Step 2: Tampilkan laci berdasarkan lab yang dipilih
     */
    public function byLab(Request $request, Lab $lab)
    {
        if ($lab->status !== 'aktif') {
            return redirect()->route('user.katalog')->with('error', 'Lab ini tidak aktif.');
        }

        $lacis = Laci::where('lab_id', $lab->id)
            ->where('status', 'aktif')
            ->withCount('alat')
            ->orderBy('kode_laci')
            ->get();

        return view('user.katalog.laci', compact('lab', 'lacis'));
    }

    /**
     * Step 3: Tampilkan alat berdasarkan laci yang dipilih
     */
    public function byLaci(Request $request, Lab $lab, Laci $laci)
    {
        if ($laci->status !== 'aktif') {
            return redirect()->route('user.katalog.lab', $lab)->with('error', 'Laci ini tidak aktif.');
        }

        $query = Alat::where('laci_id', $laci->id)->where('status', 'tersedia');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                  ->orWhere('kode_alat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $alat = $query->latest()->paginate(12);

        $kategoris = Alat::where('laci_id', $laci->id)
            ->where('status', 'tersedia')
            ->distinct()
            ->pluck('kategori');

        return view('user.katalog.alat', compact('lab', 'laci', 'alat', 'kategoris'));
    }
}