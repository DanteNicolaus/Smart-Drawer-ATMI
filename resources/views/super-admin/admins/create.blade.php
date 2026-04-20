@extends('layouts.super-admin')

@section('title', 'Tambah Admin Baru')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-user-plus"></i> Tambah Admin Baru
        </h1>
        <p class="text-muted mb-0">Tambahkan Admin Lab atau User Admin baru</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Admin</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('super-admin.admins.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                                   value="{{ old('no_hp') }}" required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" id="roleSelect" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin Lab</option>
                                <option value="user_admin" {{ old('role') == 'user_admin' ? 'selected' : '' }}>User Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Field Lab: hanya muncul jika role = Admin Lab --}}
                        <div class="mb-3" id="labField" style="{{ old('role') == 'admin' ? '' : 'display:none;' }}">
                            <label class="form-label">
                                Lab yang Dikelola <span class="text-danger">*</span>
                            </label>
                            <select name="lab_id" id="labSelect" class="form-select @error('lab_id') is-invalid @enderror">
                                <option value="">-- Pilih Lab --</option>
                                @foreach($labs as $lab)
                                    <option value="{{ $lab->id }}" {{ old('lab_id') == $lab->id ? 'selected' : '' }}>
                                        {{ $lab->kode_lab }} - {{ $lab->nama_lab }}
                                        ({{ $lab->lokasi ?? 'Lokasi belum diisi' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('lab_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                Admin Lab hanya bisa mengakses dan mengelola lab yang dipilih ini.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('super-admin.admins.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Admin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const roleSelect = document.getElementById('roleSelect');
    const labField   = document.getElementById('labField');
    const labSelect  = document.getElementById('labSelect');

    roleSelect.addEventListener('change', function () {
        if (this.value === 'admin') {
            labField.style.display = 'block';
            labSelect.setAttribute('required', 'required');
        } else {
            labField.style.display = 'none';
            labSelect.removeAttribute('required');
            labSelect.value = ''; // reset pilihan lab
        }
    });

    // Jalankan saat halaman load (untuk kasus old input setelah validasi gagal)
    if (roleSelect.value === 'admin') {
        labField.style.display = 'block';
        labSelect.setAttribute('required', 'required');
    }
</script>
@endsection