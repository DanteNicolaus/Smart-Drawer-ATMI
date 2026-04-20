@extends('layouts.super-admin')

@section('title', 'Input Peminjaman Baru - Super Admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="mb-4">
        <div class="d-flex align-items-center mb-2">
            <a href="{{ route('super-admin.peminjaman.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 mb-0">📝 Input Peminjaman Baru</h1>
                <p class="text-muted mb-0">Tambahkan data peminjaman alat oleh user</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('super-admin.peminjaman.store') }}" method="POST" id="formPeminjaman">
                        @csrf

                        <h6 class="mb-3">👤 Data Peminjam</h6>

                        <!-- Pilih User -->
                        <div class="mb-3">
                            <label class="form-label">Pilih User <span class="text-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" data-koin="{{ $user->koin }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->nim }}) - 🪙 {{ $user->koin }} Koin
                                </option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Info Koin User -->
                            <div id="koinInfo" class="alert alert-info mt-2" style="display: none;">
                                <strong>🪙 Koin Tersedia:</strong> <span id="koinValue">0</span> koin
                            </div>
                            <div id="koinWarning" class="alert alert-warning mt-2" style="display: none;">
                                <strong>⚠️ Peringatan:</strong> User ini tidak memiliki koin! Peminjaman tidak dapat diproses.
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3">🔧 Data Alat</h6>

                        <!-- Pilih Alat -->
                        <div class="mb-3">
                            <label class="form-label">Pilih Alat <span class="text-danger">*</span></label>
                            <select name="alat_id" id="alat_id" class="form-select @error('alat_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Alat --</option>
                                @foreach($alats as $alat)
                                <option value="{{ $alat->id }}" data-tersedia="{{ $alat->jumlah_tersedia }}" {{ old('alat_id') == $alat->id ? 'selected' : '' }}>
                                    {{ $alat->nama_alat }} ({{ $alat->kode_alat }}) - Tersedia: {{ $alat->jumlah_tersedia }} unit
                                </option>
                                @endforeach
                            </select>
                            @error('alat_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Pinjam -->
                        <div class="mb-3">
                            <label class="form-label">Jumlah Pinjam <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_pinjam" id="jumlah_pinjam" 
                                   class="form-control @error('jumlah_pinjam') is-invalid @enderror" 
                                   value="{{ old('jumlah_pinjam', 1) }}" min="1" required>
                            @error('jumlah_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted" id="infoTersedia"></small>
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3">📅 Tanggal Peminjaman</h6>

                        <!-- Tanggal Pinjam -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pinjam" 
                                   class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                                   value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                            @error('tanggal_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr class="my-4">

                        <h6 class="mb-3">📋 Detail Peminjaman</h6>

                        <!-- Keperluan -->
                        <div class="mb-4">
                            <label class="form-label">Keperluan <span class="text-danger">*</span></label>
                            <textarea name="keperluan" class="form-control @error('keperluan') is-invalid @enderror" 
                                      rows="4" required placeholder="Jelaskan keperluan peminjaman alat...">{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="btnSubmit">
                                <i class="fas fa-save me-2"></i>Simpan Peminjaman
                            </button>
                            <a href="{{ route('super-admin.peminjaman.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3 bg-info bg-opacity-10">
                <div class="card-body">
                    <h6 class="mb-3">ℹ️ Informasi Penting</h6>
                    <ul class="mb-0 small text-muted">
                        <li class="mb-2">Pilih user yang akan meminjam alat</li>
                        <li class="mb-2">Pastikan user memiliki koin yang cukup</li>
                        <li class="mb-2">Setiap peminjaman akan mengurangi 1 koin user</li>
                        <li class="mb-2">Cek ketersediaan alat sebelum input</li>
                        <li>Data akan langsung masuk ke riwayat user</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                <div class="card-body">
                    <h6 class="mb-2">🪙 Sistem Koin</h6>
                    <p class="small text-muted mb-0">
                        Setiap kali Super Admin menginput peminjaman, sistem akan otomatis mengurangi 1 koin dari user. 
                        Pastikan user memiliki koin yang cukup sebelum menginput peminjaman.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('user_id');
    const alatSelect = document.getElementById('alat_id');
    const jumlahInput = document.getElementById('jumlah_pinjam');
    const koinInfo = document.getElementById('koinInfo');
    const koinValue = document.getElementById('koinValue');
    const koinWarning = document.getElementById('koinWarning');
    const infoTersedia = document.getElementById('infoTersedia');
    const btnSubmit = document.getElementById('btnSubmit');

    // Event listener untuk user select
    userSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const koin = selectedOption.dataset.koin;
        
        if (this.value) {
            koinValue.textContent = koin;
            
            if (parseInt(koin) > 0) {
                koinInfo.style.display = 'block';
                koinWarning.style.display = 'none';
                btnSubmit.disabled = false;
            } else {
                koinInfo.style.display = 'none';
                koinWarning.style.display = 'block';
                btnSubmit.disabled = true;
            }
        } else {
            koinInfo.style.display = 'none';
            koinWarning.style.display = 'none';
            btnSubmit.disabled = false;
        }
    });

    // Event listener untuk alat select
    alatSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const tersedia = selectedOption.dataset.tersedia;
        
        if (this.value) {
            jumlahInput.max = tersedia;
            infoTersedia.textContent = `Maksimal: ${tersedia} unit`;
        } else {
            infoTersedia.textContent = '';
        }
    });

    // Validasi jumlah pinjam
    jumlahInput.addEventListener('input', function() {
        const max = parseInt(this.max);
        const value = parseInt(this.value);
        
        if (value > max) {
            this.value = max;
        }
    });
});
</script>
@endsection