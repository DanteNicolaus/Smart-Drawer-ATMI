@extends('layouts.admin')

@section('title', 'Tambah Alat Baru')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 animate-fade-in">
                <!-- Header -->
                <div class="card-header bg-gradient-primary text-white py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Alat Baru
                        </h4>
                        <a href="{{ route('admin.alat.index') }}" class="btn btn-light btn-sm px-3">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <!-- Progress Indicator -->
                    <div class="progress-indicator mb-4">
                        <div class="d-flex justify-content-between">
                            <div class="step active" data-step="1">
                                <div class="step-circle"><i class="fas fa-info-circle"></i></div>
                                <small class="step-label">Info Dasar</small>
                            </div>
                            <div class="step-line"></div>
                            <div class="step" data-step="2">
                                <div class="step-circle"><i class="fas fa-tags"></i></div>
                                <small class="step-label">Kategori</small>
                            </div>
                            <div class="step-line"></div>
                            <div class="step" data-step="3">
                                <div class="step-circle"><i class="fas fa-warehouse"></i></div>
                                <small class="step-label">Stok & Laci</small>
                            </div>
                            <div class="step-line"></div>
                            <div class="step" data-step="4">
                                <div class="step-circle"><i class="fas fa-camera"></i></div>
                                <small class="step-label">Media</small>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data" id="alatForm">
                        @csrf

                        <!-- Informasi Dasar -->
                        <div class="form-section mb-5" data-section="1">
                            <div class="section-header mb-4">
                                <h5 class="text-primary mb-1 fw-bold">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                </h5>
                                <p class="text-muted small mb-0">Data identitas dan nama alat</p>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="kode_alat" class="form-label fw-bold">
                                        Kode Alat <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-barcode text-primary"></i>
                                        </span>
                                        <input type="text"
                                               class="form-control border-start-0 @error('kode_alat') is-invalid @enderror"
                                               id="kode_alat" name="kode_alat"
                                               value="{{ old('kode_alat') }}"
                                               placeholder="Contoh: ALT-001"
                                               required data-validation="required">
                                        @error('kode_alat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted d-flex align-items-center mt-2">
                                        <i class="fas fa-info-circle me-1"></i>Kode unik untuk identifikasi alat
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label for="nama_alat" class="form-label fw-bold">
                                        Nama Alat <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-box text-primary"></i>
                                        </span>
                                        <input type="text"
                                               class="form-control border-start-0 @error('nama_alat') is-invalid @enderror"
                                               id="nama_alat" name="nama_alat"
                                               value="{{ old('nama_alat') }}"
                                               placeholder="Contoh: Mikroskop Digital"
                                               required data-validation="required">
                                        @error('nama_alat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kategori dan Kondisi -->
                        <div class="form-section mb-5" data-section="2">
                            <div class="section-header mb-4">
                                <h5 class="text-primary mb-1 fw-bold">
                                    <i class="fas fa-tags me-2"></i>Kategori & Kondisi
                                </h5>
                                <p class="text-muted small mb-0">Klasifikasi dan status kondisi alat</p>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="kategori" class="form-label fw-bold">
                                        Kategori <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-layer-group text-primary"></i>
                                        </span>
                                        <select class="form-select border-start-0 @error('kategori') is-invalid @enderror"
                                                id="kategori" name="kategori" required data-validation="required">
                                            <option value="">-- Pilih Kategori --</option>
                                            <option value="Perkakas_tangan" {{ old('kategori') == 'Perkakas_tangan' ? 'selected' : '' }}>Perkakas tangan</option>
                                            <option value="Toolbox"         {{ old('kategori') == 'Toolbox'         ? 'selected' : '' }}>Toolbox</option>
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Kondisi <span class="text-danger">*</span></label>
                                    <div class="kondisi-select">
                                        <div class="row g-3">
                                            <div class="col-4">
                                                <input type="radio" class="btn-check" name="kondisi" id="kondisi_baik" value="baik" {{ old('kondisi') == 'baik' ? 'checked' : '' }} required>
                                                <label class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" for="kondisi_baik">
                                                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                                                    <span class="fw-bold">Baik</span>
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <input type="radio" class="btn-check" name="kondisi" id="kondisi_rusak_ringan" value="rusak ringan" {{ old('kondisi') == 'rusak ringan' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" for="kondisi_rusak_ringan">
                                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                                    <span class="fw-bold">Rusak Ringan</span>
                                                </label>
                                            </div>
                                            <div class="col-4">
                                                <input type="radio" class="btn-check" name="kondisi" id="kondisi_rusak_berat" value="rusak berat" {{ old('kondisi') == 'rusak berat' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" for="kondisi_rusak_berat">
                                                    <i class="fas fa-times-circle fa-2x mb-2"></i>
                                                    <span class="fw-bold">Rusak Berat</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('kondisi')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Stok dan Laci -->
                        <div class="form-section mb-5" data-section="3">
                            <div class="section-header mb-4">
                                <h5 class="text-primary mb-1 fw-bold">
                                    <i class="fas fa-warehouse me-2"></i>Stok & Laci Penyimpanan
                                </h5>
                                <p class="text-muted small mb-0">Informasi ketersediaan dan penempatan alat di laci</p>
                            </div>
                            <div class="row g-4">
                                <!-- Jumlah Total -->
                                <div class="col-md-6">
                                    <label for="jumlah_total" class="form-label fw-bold">
                                        Jumlah Total <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-cubes text-primary"></i>
                                        </span>
                                        <input type="number"
                                               class="form-control border-start-0 border-end-0 @error('jumlah_total') is-invalid @enderror"
                                               id="jumlah_total" name="jumlah_total"
                                               value="{{ old('jumlah_total', 1) }}"
                                               min="1" placeholder="0" required data-validation="required">
                                        <span class="input-group-text bg-light">
                                            <span class="badge bg-primary">Unit</span>
                                        </span>
                                        @error('jumlah_total')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Pilih Laci -->
                                <div class="col-md-6">
                                    <label for="laci_id" class="form-label fw-bold">
                                        Laci Penyimpanan
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                        </span>
                                        <select class="form-select border-start-0 @error('laci_id') is-invalid @enderror"
                                                id="laci_id" name="laci_id">
                                            <option value="">-- Pilih Laci --</option>
                                            @foreach($lacis as $laci)
                                            <option value="{{ $laci->id }}" {{ old('laci_id') == $laci->id ? 'selected' : '' }}>
                                                {{ $laci->kode_laci }} - {{ $laci->nama_laci }}
                                                @if($laci->lokasi)({{ $laci->lokasi }})@endif
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('laci_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted d-flex align-items-center mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Pilih laci tempat alat disimpan.
                                        <a href="{{ route('admin.laci.create') }}" target="_blank" class="ms-1">+ Tambah laci baru</a>
                                    </small>
                                    @if($lacis->isEmpty())
                                    <div class="alert alert-warning mt-2 p-2 small">
                                        ⚠️ Belum ada laci. <a href="{{ route('admin.laci.create') }}">Tambah laci terlebih dahulu</a>.
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi & Media -->
                        <div class="form-section mb-5" data-section="4">
                            <div class="section-header mb-4">
                                <h5 class="text-primary mb-1 fw-bold">
                                    <i class="fas fa-align-left me-2"></i>Deskripsi & Media
                                </h5>
                                <p class="text-muted small mb-0">Detail informasi dan dokumentasi visual</p>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-bold">Deskripsi Detail Alat</label>
                                <div class="position-relative">
                                    <textarea class="form-control form-control-lg @error('deskripsi') is-invalid @enderror"
                                              id="deskripsi" name="deskripsi" rows="6"
                                              style="resize: vertical;"
                                              placeholder="Masukkan deskripsi detail mengenai alat, spesifikasi teknis, cara penggunaan, dll."
                                              maxlength="1000">{{ old('deskripsi') }}</textarea>
                                    <small class="text-muted position-absolute" style="bottom: 10px; right: 15px;">
                                        <span id="charCount">0</span>/1000
                                    </small>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Foto -->
                            <div>
                                <label class="form-label fw-bold">
                                    <i class="fas fa-camera me-2"></i>Upload Foto Alat
                                </label>
                                <div class="upload-container">
                                    <div class="upload-area border-2 border-dashed rounded-3 p-5 text-center position-relative"
                                         id="uploadArea" onclick="document.getElementById('foto').click()">
                                        <div class="upload-content">
                                            <div class="upload-icon mb-3">
                                                <i class="fas fa-cloud-upload-alt fa-4x text-primary"></i>
                                            </div>
                                            <h6 class="mb-2">Drag & Drop atau Klik untuk Upload</h6>
                                            <p class="text-muted mb-3">Pilih foto alat dari komputer Anda</p>
                                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                <span class="badge bg-light text-dark"><i class="fas fa-file-image me-1"></i>JPG, PNG</span>
                                                <span class="badge bg-light text-dark"><i class="fas fa-weight me-1"></i>Max 2MB</span>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="file" class="d-none @error('foto') is-invalid @enderror"
                                           id="foto" name="foto" accept="image/jpeg,image/png,image/jpg">
                                    @error('foto')
                                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                    @enderror

                                    <div class="mt-4" id="imagePreview" style="display: none;">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <span class="text-muted small">
                                                        <i class="fas fa-check-circle text-success me-1"></i>Preview Foto
                                                    </span>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()">
                                                        <i class="fas fa-times me-1"></i>Hapus
                                                    </button>
                                                </div>
                                                <div class="text-center">
                                                    <img id="preview" src="" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: contain;">
                                                </div>
                                                <div class="mt-3 p-2 bg-light rounded">
                                                    <small class="text-muted d-flex justify-content-between">
                                                        <span id="fileName"></span>
                                                        <span id="fileSize"></span>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.alat.index') }}" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Simpan Alat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes fadeIn { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.5s ease-out; }
    .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .card { border-radius: 20px; overflow: hidden; }
    .progress-indicator { position: relative; padding: 20px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; margin-bottom: 30px; }
    .progress-indicator .step { text-align: center; position: relative; z-index: 2; }
    .progress-indicator .step-circle { width: 50px; height: 50px; border-radius: 50%; background: white; border: 3px solid #dee2e6; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; transition: all 0.3s ease; color: #6c757d; font-size: 18px; }
    .progress-indicator .step.active .step-circle { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-color: #667eea; color: white; box-shadow: 0 4px 15px rgba(102,126,234,0.4); transform: scale(1.1); }
    .progress-indicator .step-label { display: block; color: #6c757d; font-weight: 500; }
    .progress-indicator .step.active .step-label { color: #667eea; font-weight: 600; }
    .progress-indicator .step-line { flex: 1; height: 3px; background: #dee2e6; align-self: center; margin: 0 -10px; margin-bottom: 33px; position: relative; z-index: 1; }
    .section-header { padding-bottom: 15px; border-bottom: 2px solid #e9ecef; }
    .form-control:focus, .form-select:focus { border-color: #667eea; box-shadow: 0 0 0 0.25rem rgba(102,126,234,0.15); }
    .upload-area { cursor: pointer; transition: all 0.3s ease; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-color: #dee2e6 !important; min-height: 250px; display: flex; align-items: center; justify-content: center; }
    .upload-area:hover { background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); border-color: #667eea !important; transform: translateY(-3px); }
    .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; }
    .btn-primary:hover { background: linear-gradient(135deg, #5568d3 0%, #65408b 100%); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,0.4); }
    #charCount { font-weight: 600; color: #667eea; }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            if (!['image/jpeg','image/jpg','image/png'].includes(file.type)) {
                alert('Format file tidak valid. Gunakan JPG atau PNG.');
                document.getElementById('foto').value = '';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                document.getElementById('foto').value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(2) + ' KB';
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('uploadArea').style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        document.getElementById('foto').value = '';
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('uploadArea').style.display = 'flex';
        document.getElementById('preview').src = '';
    }

    document.getElementById('deskripsi').addEventListener('input', function() {
        const count = this.value.length;
        document.getElementById('charCount').textContent = count;
        document.getElementById('charCount').classList.toggle('text-danger', count > 900);
    });

    document.getElementById('foto').addEventListener('change', previewImage);

    const uploadArea = document.getElementById('uploadArea');
    ['dragenter','dragover','dragleave','drop'].forEach(e => uploadArea.addEventListener(e, ev => { ev.preventDefault(); ev.stopPropagation(); }));
    ['dragenter','dragover'].forEach(e => uploadArea.addEventListener(e, () => uploadArea.classList.add('dragover')));
    ['dragleave','drop'].forEach(e => uploadArea.addEventListener(e, () => uploadArea.classList.remove('dragover')));
    uploadArea.addEventListener('drop', function(e) {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('foto').files = files;
            previewImage({ target: { files: files } });
        }
    });

    document.getElementById('alatForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    });

    document.querySelectorAll('[data-validation="required"]').forEach(input => {
        input.addEventListener('blur', function() {
            this.classList.toggle('is-invalid', this.value.trim() === '');
            if (this.value.trim() !== '') this.classList.add('is-valid');
        });
    });
</script>
@endpush
@endsection