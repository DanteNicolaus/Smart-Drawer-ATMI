<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    // ==========================================
    // DASHBOARD
    // ==========================================
    
    /**
     * Dashboard Super Admin
     */
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalAdminLab = User::where('role', 'admin')->count();
        $totalUserAdmin = User::where('role', 'user_admin')->count();
        $totalPeminjaman = Peminjaman::count();
        $totalAlat = Alat::count();

        // Statistik peminjaman
        $peminjamanPerStatus = Peminjaman::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Peminjaman aktif terbaru
        $peminjamanAktif = Peminjaman::with(['user', 'alat'])
            ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
            ->latest()
            ->limit(5)
            ->get();

        // Statistik alat per kategori
        $alatPerKategori = Alat::selectRaw('kategori, COUNT(*) as total, SUM(jumlah_tersedia) as tersedia')
            ->groupBy('kategori')
            ->get();

        return view('super-admin.dashboard', compact(
            'totalUsers',
            'totalAdminLab',
            'totalUserAdmin',
            'totalPeminjaman',
            'totalAlat',
            'peminjamanPerStatus',
            'peminjamanAktif',
            'alatPerKategori'
        ));
    }

    // ==========================================
    // KELOLA ADMIN (Admin Lab & User Admin)
    // ==========================================
    
    /**
     * Tampilkan daftar admin
     */
    public function adminIndex(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'user_admin']);

        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }

        $admins = $query->latest()->paginate(15);

        return view('super-admin.admins.index', compact('admins'));
    }

    /**
     * Tampilkan form tambah admin
     */
public function adminCreate()
{
    $labs = \App\Models\Lab::where('status', 'aktif')->orderBy('nama_lab')->get();
    return view('super-admin.admins.create', compact('labs'));
}

    /**
     * Simpan admin baru
     */
    public function adminStore(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'no_hp'    => 'required|string|max:15',
        'email'    => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role'     => 'required|in:admin,user_admin',
        'lab_id'   => 'nullable|exists:lab,id', // ← TAMBAH
    ], [
        'name.required'      => 'Nama lengkap harus diisi',
        'no_hp.required'     => 'Nomor HP harus diisi',
        'email.required'     => 'Email harus diisi',
        'email.email'        => 'Format email tidak valid',
        'email.unique'       => 'Email sudah terdaftar',
        'password.required'  => 'Password harus diisi',
        'password.min'       => 'Password minimal 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
        'role.required'      => 'Role harus dipilih',
        'role.in'            => 'Role tidak valid',
    ]);

    User::create([
        'name'       => $request->name,
        'nim'        => null,
        'jurusan'    => null,
        'no_hp'      => $request->no_hp,
        'email'      => $request->email,
        'password'   => Hash::make($request->password),
        'role'       => $request->role,
        'lab_id'     => $request->role === 'admin' ? $request->lab_id : null, // ← TAMBAH
        'created_by' => auth()->id(),
    ]);

    $roleDisplay = $request->role === 'admin' ? 'Admin Lab' : 'User Admin';

    return redirect()->route('super-admin.admins.index')
        ->with('success', $roleDisplay . ' berhasil ditambahkan!');
}

    /**
     * Tampilkan form edit admin
     */
    public function adminEdit(User $admin)
{
    if (!in_array($admin->role, ['admin', 'user_admin'])) {
        abort(403, 'User ini bukan admin!');
    }

    $labs = \App\Models\Lab::where('status', 'aktif')->orderBy('nama_lab')->get();
    return view('super-admin.admins.edit', compact('admin', 'labs'));
}


    /**
     * Update admin
     */
  public function adminUpdate(Request $request, User $admin)
{
    if (!in_array($admin->role, ['admin', 'user_admin'])) {
        abort(403, 'User ini bukan admin!');
    }

    $request->validate([
        'name'     => 'required|string|max:255',
        'no_hp'    => 'required|string|max:15',
        'email'    => 'required|string|email|max:255|unique:users,email,' . $admin->id,
        'password' => 'nullable|string|min:8|confirmed',
        'role'     => 'required|in:admin,user_admin',
        'lab_id'   => 'nullable|exists:lab,id', // ← TAMBAH
    ], [
        'name.required'      => 'Nama lengkap harus diisi',
        'no_hp.required'     => 'Nomor HP harus diisi',
        'email.required'     => 'Email harus diisi',
        'email.email'        => 'Format email tidak valid',
        'email.unique'       => 'Email sudah terdaftar',
        'password.min'       => 'Password minimal 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
        'role.required'      => 'Role harus dipilih',
        'role.in'            => 'Role tidak valid',
    ]);

    $data = [
        'name'   => $request->name,
        'no_hp'  => $request->no_hp,
        'email'  => $request->email,
        'role'   => $request->role,
        'lab_id' => $request->role === 'admin' ? $request->lab_id : null, // ← TAMBAH
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $admin->update($data);

    return redirect()->route('super-admin.admins.index')
        ->with('success', 'Admin berhasil diupdate!');
}

    /**
     * Hapus admin
     */
    public function adminDestroy(User $admin)
    {
        if (!in_array($admin->role, ['admin', 'user_admin'])) {
            abort(403, 'User ini bukan admin!');
        }

        if ($admin->role === 'super_admin') {
            abort(403, 'Tidak dapat menghapus Super Admin!');
        }

        if ($admin->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $admin->delete();

        return redirect()->route('super-admin.admins.index')
            ->with('success', 'Admin berhasil dihapus!');
    }

    // ==========================================
    // KELOLA USER BIASA
    // ==========================================
    
    /**
     * Tampilkan daftar user
     */
    public function userIndex(Request $request)
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

        return view('super-admin.users.index', compact('users', 'jurusans'));
    }

    /**
     * Tampilkan form tambah user
     */
    public function userCreate()
    {
        return view('super-admin.users.create');
    }

    /**
     * Simpan user baru
     */
    public function userStore(Request $request)
    {
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

        User::create([
            'name' => $validated['name'],
            'nim' => $validated['nim'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'jurusan' => $validated['jurusan'],
            'no_hp' => $validated['no_hp'] ?? null,
            'role' => 'user',
            'koin' => 10,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User berhasil ditambahkan! Koin awal: 10');
    }

    /**
     * Tampilkan form edit user
     */
    public function userEdit(User $user)
    {
        if ($user->role !== 'user') {
            return redirect()->route('super-admin.users.index')
                ->with('error', 'Tidak dapat mengedit user ini!');
        }

        return view('super-admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function userUpdate(Request $request, User $user)
    {
        if ($user->role !== 'user') {
            return redirect()->route('super-admin.users.index')
                ->with('error', 'Tidak dapat mengedit user ini!');
        }

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

        $user->name = $validated['name'];
        $user->nim = $validated['nim'];
        $user->email = $validated['email'];
        $user->jurusan = $validated['jurusan'];
        $user->no_hp = $validated['no_hp'] ?? null;
        $user->koin = $validated['koin'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('super-admin.users.index')
            ->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Hapus user
     */
    public function userDestroy(User $user)
    {
        if ($user->role !== 'user') {
            return redirect()->route('super-admin.users.index')
                ->with('error', 'Tidak dapat menghapus user ini!');
        }

        // Cek peminjaman aktif
        $activePeminjaman = $user->peminjaman()
            ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
            ->count();

        if ($activePeminjaman > 0) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus user yang masih memiliki peminjaman aktif!');
        }

        $user->delete();

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    // ==========================================
    // KELOLA ALAT
    // ==========================================
    
    /**
     * Tampilkan daftar alat
     */
    public function alatIndex(Request $request)
    {
        $query = Alat::query();

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                  ->orWhere('kode_alat', 'like', "%{$search}%");
            });
        }

        $alat = $query->latest()->paginate(15);

        // Ambil daftar kategori untuk filter
        $kategoris = Alat::distinct()->pluck('kategori');

        return view('super-admin.alat.index', compact('alat', 'kategoris'));
    }

    /**
     * Tampilkan form tambah alat
     */
    public function alatCreate()
    {
        return view('super-admin.alat.create');
    }

    /**
     * Simpan alat baru
     */
    public function alatStore(Request $request)
    {
        $request->validate([
            'kode_alat' => 'required|unique:alat',
            'nama_alat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string',
            'jumlah_total' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
            'lokasi_penyimpanan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['jumlah_tersedia'] = $request->jumlah_total;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('alat', 'public');
        }

        Alat::create($data);

        return redirect()->route('super-admin.alat.index')
            ->with('success', 'Alat berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail alat
     */
    public function alatShow(Alat $alat)
    {
        return view('super-admin.alat.show', compact('alat'));
    }

    /**
     * Tampilkan form edit alat
     */
    public function alatEdit(Alat $alat)
    {
        return view('super-admin.alat.edit', compact('alat'));
    }

    /**
     * Update alat
     */
    public function alatUpdate(Request $request, Alat $alat)
    {
        $request->validate([
            'kode_alat' => 'required|unique:alat,kode_alat,' . $alat->id,
            'nama_alat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string',
            'jumlah_total' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
            'lokasi_penyimpanan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($alat->foto) {
                Storage::disk('public')->delete($alat->foto);
            }
            $data['foto'] = $request->file('foto')->store('alat', 'public');
        }

        // Update jumlah tersedia jika jumlah total berubah
        if ($request->jumlah_total != $alat->jumlah_total) {
            $selisih = $request->jumlah_total - $alat->jumlah_total;
            $data['jumlah_tersedia'] = $alat->jumlah_tersedia + $selisih;
        }

        $alat->update($data);

        return redirect()->route('super-admin.alat.index')
            ->with('success', 'Data alat berhasil diupdate!');
    }

    /**
     * Hapus alat
     */
    public function alatDestroy(Alat $alat)
    {
        // Cek peminjaman aktif
        if ($alat->peminjaman()->whereIn('status', ['pending', 'disetujui', 'dipinjam'])->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus alat yang sedang dipinjam!');
        }

        if ($alat->foto) {
            Storage::disk('public')->delete($alat->foto);
        }

        $alat->delete();

        return redirect()->route('super-admin.alat.index')
            ->with('success', 'Alat berhasil dihapus!');
    }

    /**
     * Toggle status alat
     */
    public function alatToggleStatus(Alat $alat)
    {
        $alat->update([
            'status' => $alat->status === 'tersedia' ? 'tidak_tersedia' : 'tersedia'
        ]);

        return redirect()->back()
            ->with('success', 'Status alat berhasil diubah!');
    }

    // ==========================================
    // KELOLA PEMINJAMAN
    // ==========================================
    
    /**
     * Tampilkan semua peminjaman
     */
    public function peminjamanIndex(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat'])->latest();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('kode_peminjaman', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%')
                         ->orWhere('nim', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('alat', function($q2) use ($request) {
                      $q2->where('nama_alat', 'like', '%' . $request->search . '%')
                         ->orWhere('kode_alat', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $peminjaman = $query->paginate(20);
        $users = User::where('role', 'user')->get();

        return view('super-admin.peminjaman.index', compact('peminjaman', 'users'));
    }

    /**
     * Form input peminjaman baru
     */
    public function peminjamanCreate()
    {
        $users = User::where('role', 'user')
            ->orderBy('name')
            ->get();
        
        $alats = Alat::where('status', 'tersedia')
            ->where('jumlah_tersedia', '>', 0)
            ->orderBy('nama_alat')
            ->get();
        
        return view('super-admin.peminjaman.create', compact('users', 'alats'));
    }

    /**
     * Simpan peminjaman baru
     */
    public function peminjamanStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'alat_id' => 'required|exists:alat,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keperluan' => 'required|string|max:500',
        ], [
            'user_id.required' => 'User harus dipilih',
            'alat_id.required' => 'Alat harus dipilih',
            'jumlah_pinjam.required' => 'Jumlah pinjam harus diisi',
            'jumlah_pinjam.min' => 'Jumlah pinjam minimal 1',
            'tanggal_pinjam.required' => 'Tanggal pinjam harus diisi',
            'tanggal_kembali_rencana.required' => 'Tanggal rencana kembali harus diisi',
            'tanggal_kembali_rencana.after' => 'Tanggal kembali harus setelah tanggal pinjam',
            'keperluan.required' => 'Keperluan peminjaman harus diisi',
        ]);

        $user = User::findOrFail($request->user_id);
        $alat = Alat::findOrFail($request->alat_id);

        // Cek koin user
        if ($user->koin < 1) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'User tidak memiliki koin yang cukup! Koin tersisa: ' . $user->koin);
        }

        // Cek ketersediaan alat
        if ($alat->jumlah_tersedia < $request->jumlah_pinjam) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jumlah alat tidak mencukupi! Tersedia: ' . $alat->jumlah_tersedia . ' unit');
        }

        // Buat peminjaman
        Peminjaman::create([
            'kode_peminjaman' => Peminjaman::generateKodePeminjaman(),
            'user_id' => $request->user_id,
            'alat_id' => $request->alat_id,
            'jumlah_pinjam' => $request->jumlah_pinjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'keperluan' => $request->keperluan,
            'status' => 'dipinjam',
            'catatan_admin' => 'Diinput oleh Super Admin: ' . auth()->user()->name,
        ]);

        // Kurangi koin dan stok
        $user->kurangiKoin(1);
        $alat->decrement('jumlah_tersedia', $request->jumlah_pinjam);

        return redirect()->route('super-admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan! Koin user berkurang 1. Sisa koin: ' . $user->koin);
    }

    /**
     * Detail peminjaman
     */
    public function peminjamanShow(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'alat']);
        return view('super-admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Approve peminjaman
     */
    public function peminjamanApprove(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Peminjaman ini sudah diproses!');
        }

        if ($peminjaman->alat->jumlah_tersedia < $peminjaman->jumlah_pinjam) {
            return redirect()->back()
                ->with('error', 'Jumlah alat tidak mencukupi!');
        }

        $peminjaman->update([
            'status' => 'disetujui',
            'catatan_admin' => $request->catatan_admin,
        ]);

        $peminjaman->alat->decrement('jumlah_tersedia', $peminjaman->jumlah_pinjam);

        return redirect()->back()
            ->with('success', 'Peminjaman berhasil disetujui!');
    }

    /**
     * Reject peminjaman
     */
    public function peminjamanReject(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Peminjaman ini sudah diproses!');
        }

        $request->validate([
            'catatan_admin' => 'required|string',
        ], [
            'catatan_admin.required' => 'Alasan penolakan harus diisi',
        ]);

        $peminjaman->update([
            'status' => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->back()
            ->with('success', 'Peminjaman berhasil ditolak!');
    }

    /**
     * Process peminjaman (alat diambil)
     */
    public function peminjamanProcess(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'disetujui') {
            return redirect()->back()
                ->with('error', 'Peminjaman belum disetujui!');
        }

        $peminjaman->update([
            'status' => 'dipinjam',
        ]);

        return redirect()->back()
            ->with('success', 'Alat sudah diambil peminjam!');
    }

    /**
     * Return peminjaman
     */
    public function peminjamanReturn(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()
                ->with('error', 'Status peminjaman tidak valid!');
        }

        $request->validate([
            'kondisi_saat_kembali' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'catatan_pengembalian' => 'nullable|string',
        ]);

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali_aktual' => now(),
            'kondisi_saat_kembali' => $request->kondisi_saat_kembali,
            'catatan_pengembalian' => $request->catatan_pengembalian,
        ]);

        // Kembalikan stok kecuali hilang
        if ($request->kondisi_saat_kembali !== 'hilang') {
            $peminjaman->alat->increment('jumlah_tersedia', $peminjaman->jumlah_pinjam);
        } else {
            $peminjaman->alat->decrement('jumlah_total', $peminjaman->jumlah_pinjam);
        }

        // Kembalikan koin jika kondisi baik
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
    public function peminjamanDestroy(Peminjaman $peminjaman)
    {
        if (!in_array($peminjaman->status, ['ditolak', 'dikembalikan'])) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus peminjaman yang masih aktif!');
        }

        $peminjaman->delete();

        return redirect()->route('super-admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus!');
    }

    /**
     * Riwayat peminjaman (alias untuk peminjamanIndex)
     */
    public function riwayatPeminjaman(Request $request)
    {
        return $this->peminjamanIndex($request);
    }

    /**
     * Export peminjaman ke Excel
     */
    public function export(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('kode_peminjaman', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%')
                         ->orWhere('nim', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('alat', function($q2) use ($request) {
                      $q2->where('nama_alat', 'like', '%' . $request->search . '%')
                         ->orWhere('kode_alat', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->get();

        $filename = 'Riwayat_Peminjaman_' . date('Y-m-d_His') . '.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        return view('super-admin.peminjaman.export', compact('peminjaman'));
    }
    public function exportPDF(Request $request)
{
    $query = Peminjaman::with(['user', 'alat']);

    // Filter berdasarkan status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Search
    if ($request->has('search') && $request->search != '') {
        $query->where(function($q) use ($request) {
            $q->where('kode_peminjaman', 'like', '%' . $request->search . '%')
              ->orWhereHas('user', function($q2) use ($request) {
                  $q2->where('name', 'like', '%' . $request->search . '%')
                     ->orWhere('nim', 'like', '%' . $request->search . '%');
              })
              ->orWhereHas('alat', function($q2) use ($request) {
                  $q2->where('nama_alat', 'like', '%' . $request->search . '%')
                     ->orWhere('kode_alat', 'like', '%' . $request->search . '%');
              });
        });
    }

    $peminjaman = $query->orderBy('created_at', 'desc')->get();
    $tanggal = date('d F Y');
    
    // Return view PDF (akan di-print oleh browser)
    return view('super-admin.peminjaman.export-pdf', compact('peminjaman', 'tanggal'));
}







}