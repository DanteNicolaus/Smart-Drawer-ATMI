@extends('layouts.super-admin')
@section('title', 'Edit Alat')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Alat
                    </h5>
                    <a href="{{ route('super-admin.alat.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('super-admin.alat.update', $alat) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kode Alat -->
                            <div class="col-md-6 mb-3">
                                <label for="kode_alat" class="form-label">
                                    Kode Alat <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('kode_alat') is-invalid @enderror" 
                                       id="kode_alat" 
                                       name="kode_alat" 
                                       value="{{ old('kode_alat', $alat->kode_alat) }}" 
                                       required>
                                @error('kode_alat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama Alat -->
                            <div class="col-md-6 mb-3">
                                <label for="nama_alat" class="form-label">
                                    Nama Alat <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama_alat') is-invalid @enderror" 
                                       id="nama_alat" 
                                       name="nama_alat" 
                                       value="{{ old('nama_alat', $alat->nama_alat) }}" 
                                       required>
                                @error('nama_alat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Kategori -->
                            <div class="col-md-6 mb-3">
                                <label for="kategori" class="form-label">
                                    Kategori <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('kategori') is-invalid @enderror" 
                                        id="kategori" 
                                        name="kategori" 
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pengukuran" {{ old('kategori', $alat->kategori) == 'Pengukuran' ? 'selected' : '' }}>Pengukuran</option>
                                    <option value="Perkakas_tangan" {{ old('kategori', $alat->kategori) == 'Perkakas_tangan' ? 'selected' : '' }}>Perkakas tangan</option>
                                    <option value="Toolbox" {{ old('kategori', $alat->kategori) == 'Toolbox' ? 'selected' : '' }}>Toolbox</option>

                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kondisi -->
                            <div class="col-md-6 mb-3">
                                <label for="kondisi" class="form-label">
                                    Kondisi <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('kondisi') is-invalid @enderror" 
                                        id="kondisi" 
                                        name="kondisi" 
                                        required>
                                    <option value="">Pilih Kondisi</option>
                                    <option value="baik" {{ old('kondisi', $alat->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="rusak ringan" {{ old('kondisi', $alat->kondisi) == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="rusak berat" {{ old('kondisi', $alat->kondisi) == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Jumlah Total -->
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_total" class="form-label">
                                    Jumlah Total <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('jumlah_total') is-invalid @enderror" 
                                       id="jumlah_total" 
                                       name="jumlah_total" 
                                       value="{{ old('jumlah_total', $alat->jumlah_total) }}" 
                                       min="1"
                                       required>
                                @error('jumlah_total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Jumlah tersedia saat ini: {{ $alat->jumlah_tersedia }}</small>
                            </div>

                            <!-- Lokasi Penyimpanan -->
                            <div class="col-md-6 mb-3">
                                <label for="lokasi_penyimpanan" class="form-label">
                                    Lokasi Penyimpanan
                                </label>
                                <select 
                                    class="form-control @error('lokasi_penyimpanan') is-invalid @enderror"
                                    id="lokasi_penyimpanan"
                                    name="lokasi_penyimpanan">

                                    <option value="">-- Pilih Lokasi Penyimpanan --</option>

                                    <option value="Drawer 1 laci 1" {{ old('lokasi_penyimpanan', $alat->lokasi_penyimpanan) == 'Drawer 1 laci 1' ? 'selected' : '' }}>
                                        Drawer 1 laci 1
                                    </option>
                                    <option value="Drawer 1 laci 2" {{ old('lokasi_penyimpanan', $alat->lokasi_penyimpanan) == 'Drawer 1 laci 2' ? 'selected' : '' }}>
                                        Drawer 1 laci 2
                                    </option>
                                    <option value="Drawer 1 laci 3" {{ old('lokasi_penyimpanan', $alat->lokasi_penyimpanan) == 'Drawer 1 laci 3' ? 'selected' : '' }}>
                                        Drawer 1 laci 3
                                    </option>
                                    <option value="Drawer 1 laci 4" {{ old('lokasi_penyimpanan', $alat->lokasi_penyimpanan) == 'Drawer 1 laci 4' ? 'selected' : '' }}>
                                        Drawer 1 laci 4
                                    </option>
                                </select>
                                @error('lokasi_penyimpanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Foto -->
                        <div class="mb-4">
                            <label for="foto" class="form-label">Foto Alat</label>
                            
                            @if($alat->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $alat->foto) }}" 
                                     alt="{{ $alat->nama_alat }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px;">
                                <p class="text-muted small mt-1">Foto saat ini</p>
                            </div>
                            @endif

                            <input type="file" 
                                   class="form-control @error('foto') is-invalid @enderror" 
                                   id="foto" 
                                   name="foto"
                                   accept="image/jpeg,image/png,image/jpg"
                                   onchange="previewImage(event)">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                            
                            <!-- Preview New Image -->
                            <div class="mt-3" id="imagePreview" style="display: none;">
                                <p class="text-muted small">Preview foto baru:</p>
                                <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('super-admin.alat.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-1"></i>Update Alat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection