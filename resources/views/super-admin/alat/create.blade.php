@extends('layouts.super-admin')

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
                        <a href="{{ route('super-admin.alat.index') }}" class="btn btn-light btn-sm px-3">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <!-- Progress Indicator -->
                    <div class="progress-indicator mb-4">
                        <div class="d-flex justify-content-between">
                            <div class="step active" data-step="1">
                                <div class="step-circle">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <small class="step-label">Info Dasar</small>
                            </div>
                            <div class="step-line"></div>
                            <div class="step" data-step="2">
                                <div class="step-circle">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <small class="step-label">Kategori</small>
                            </div>
                            <div class="step-line"></div>
                            <div class="step" data-step="3">
                                <div class="step-circle">
                                    <i class="fas fa-warehouse"></i>
                                </div>
                                <small class="step-label">Stok</small>
                            </div>
                            <div class="step-line"></div>
                            <div class="step" data-step="4">
                                <div class="step-circle">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <small class="step-label">Media</small>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('super-admin.alat.store') }}" method="POST" enctype="multipart/form-data" id="alatForm">
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
                                <!-- Kode Alat -->
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
                                               id="kode_alat" 
                                               name="kode_alat" 
                                               value="{{ old('kode_alat') }}" 
                                               placeholder="Contoh: ALT-001"
                                               required
                                               data-validation="required">
                                        @error('kode_alat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted d-flex align-items-center mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Kode unik untuk identifikasi alat
                                    </small>
                                </div>

                                <!-- Nama Alat -->
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
                                               id="nama_alat" 
                                               name="nama_alat" 
                                               value="{{ old('nama_alat') }}" 
                                               placeholder="Contoh: Mikroskop Digital"
                                               required
                                               data-validation="required">
                                        @error('nama_alat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted d-flex align-items-center mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Nama lengkap alat yang akan ditambahkan
                                    </small>
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
                                <!-- Kategori -->
                                <div class="col-md-6">
                                    <label for="kategori" class="form-label fw-bold">
                                        Kategori <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-layer-group text-primary"></i>
                                        </span>
                                        <select class="form-select border-start-0 @error('kategori') is-invalid @enderror" 
                                                id="kategori" 
                                                name="kategori" 
                                                required
                                                data-validation="required">
                                            <option value="">-- Pilih Kategori --</option>
                                            <option value="Perkakas_tangan" {{ old('kategori') == 'Perkakas_tangan' ? 'selected' : '' }}>
                                                Perkakas tangan
                                            </option>
                                            <option value="Toolbox" {{ old('kategori') == 'Toolbox' ? 'selected' : '' }}>
                                                Toolbox
                                            </option>
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kondisi -->
                                <div class="col-md-6">
                                    <label for="kondisi" class="form-label fw-bold">
                                        Kondisi <span class="text-danger">*</span>
                                    </label>
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

                        <!-- Stok dan Lokasi -->
                        <div class="form-section mb-5" data-section="3">
                            <div class="section-header mb-4">
                                <h5 class="text-primary mb-1 fw-bold">
                                    <i class="fas fa-warehouse me-2"></i>Stok & Lokasi
                                </h5>
                                <p class="text-muted small mb-0">Informasi ketersediaan dan penempatan alat</p>
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
                                               id="jumlah_total" 
                                               name="jumlah_total" 
                                               value="{{ old('jumlah_total', 1) }}" 
                                               min="1"
                                               placeholder="0"
                                               required
                                               data-validation="required">
                                        <span class="input-group-text bg-light">
                                            <span class="badge bg-primary">Unit</span>
                                        </span>
                                        @error('jumlah_total')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted d-flex align-items-center mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Jumlah total unit alat yang tersedia
                                    </small>
                                </div>

                                <!-- Lokasi Penyimpanan -->
                                <div class="col-md-6">
                                    <label for="lokasi_penyimpanan" class="form-label fw-bold">
                                        Lokasi Penyimpanan
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                        </span>
                                        <select 
                                            class="form-control border-start-0 @error('lokasi_penyimpanan') is-invalid @enderror"
                                            id="lokasi_penyimpanan"
                                            name="lokasi_penyimpanan">

                                            <option value="">-- Pilih Lokasi Penyimpanan --</option>

                                            <option value="Drawer 1 laci 1" {{ old('lokasi_penyimpanan') == 'Drawer 1 laci 1' ? 'selected' : '' }}>
                                                Drawer 1 laci 1
                                            </option>
                                            <option value="Drawer 1 laci 2" {{ old('lokasi_penyimpanan') == 'Drawer 1 laci 2' ? 'selected' : '' }}>
                                                Drawer 1 laci 2
                                            </option>
                                            <option value="Drawer 1 laci 3" {{ old('lokasi_penyimpanan') == 'Drawer 1 laci 3' ? 'selected' : '' }}>
                                                Drawer 1 laci 3
                                            </option>
                                            <option value="Drawer 1 laci 4" {{ old('lokasi_penyimpanan') == 'Drawer 1 laci 4' ? 'selected' : '' }}>
                                                Drawer 1 laci 4
                                            </option>
                                        </select>
                                        @error('lokasi_penyimpanan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted d-flex align-items-center mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Tempat penyimpanan alat di laboratorium
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-section mb-5" data-section="4">
                            <div class="section-header mb-4">
                                <h5 class="text-primary mb-1 fw-bold">
                                    <i class="fas fa-align-left me-2"></i>Deskripsi & Media
                                </h5>
                                <p class="text-muted small mb-0">Detail informasi dan dokumentasi visual</p>
                            </div>
                            
                            <!-- Deskripsi -->
                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-bold">
                                    Deskripsi Detail Alat
                                </label>
                                <div class="position-relative">
                                    <textarea class="form-control form-control-lg @error('deskripsi') is-invalid @enderror" 
                                              id="deskripsi" 
                                              name="deskripsi" 
                                              rows="6" 
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
                                         id="uploadArea"
                                         onclick="document.getElementById('foto').click()">
                                        <div class="upload-content">
                                            <div class="upload-icon mb-3">
                                                <i class="fas fa-cloud-upload-alt fa-4x text-primary"></i>
                                            </div>
                                            <h6 class="mb-2">Drag & Drop atau Klik untuk Upload</h6>
                                            <p class="text-muted mb-3">Pilih foto alat dari komputer Anda</p>
                                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-file-image me-1"></i>JPG, PNG
                                                </span>
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-weight me-1"></i>Max 2MB
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input type="file" 
                                           class="d-none @error('foto') is-invalid @enderror" 
                                           id="foto" 
                                           name="foto"
                                           accept="image/jpeg,image/png,image/jpg">
                                    @error('foto')
                                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Preview Image -->
                                    <div class="mt-4" id="imagePreview" style="display: none;">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <span class="text-muted small">
                                                        <i class="fas fa-check-circle text-success me-1"></i>
                                                        Preview Foto
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

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('super-admin.alat.index') }}" class="btn btn-light btn-lg px-4">
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
    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    /* Gradient Background */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    /* Card Styling */
    .card {
        border-radius: 20px;
        overflow: hidden;
    }

    /* Progress Indicator */
    .progress-indicator {
        position: relative;
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        margin-bottom: 30px;
    }

    .progress-indicator .step {
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .progress-indicator .step-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: white;
        border: 3px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        transition: all 0.3s ease;
        color: #6c757d;
        font-size: 18px;
    }

    .progress-indicator .step.active .step-circle {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        transform: scale(1.1);
    }

    .progress-indicator .step-label {
        display: block;
        color: #6c757d;
        font-weight: 500;
    }

    .progress-indicator .step.active .step-label {
        color: #667eea;
        font-weight: 600;
    }

    .progress-indicator .step-line {
        flex: 1;
        height: 3px;
        background: #dee2e6;
        align-self: center;
        margin: 0 -10px;
        margin-bottom: 33px;
        position: relative;
        z-index: 1;
    }

    /* Section Headers */
    .section-header {
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
    }

    /* Form Controls */
    .input-group-text {
        border-color: #dee2e6;
        background: #f8f9fa;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
    }

    .input-group:focus-within .input-group-text {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .input-group:focus-within .input-group-text i {
        color: #667eea !important;
    }

    /* Radio Button Cards */
    .kondisi-select .btn-outline-success:hover,
    .kondisi-select .btn-outline-warning:hover,
    .kondisi-select .btn-outline-danger:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .kondisi-select .btn-check:checked + .btn {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    /* Upload Area */
    .upload-area {
        cursor: pointer;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-color: #dee2e6 !important;
        min-height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .upload-area:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        border-color: #667eea !important;
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.15);
    }

    .upload-area:hover .upload-icon i {
        transform: scale(1.1);
        color: #667eea !important;
    }

    .upload-icon i {
        transition: all 0.3s ease;
    }

    /* Drag and Drop */
    .upload-area.dragover {
        background: rgba(102, 126, 234, 0.1);
        border-color: #667eea !important;
        transform: scale(1.02);
    }

    /* Image Preview */
    #imagePreview {
        animation: fadeIn 0.5s ease-out;
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #5568d3 0%, #65408b 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-light:hover {
        background: #e2e6ea;
        transform: translateY(-2px);
    }

    /* Character Counter */
    #charCount {
        font-weight: 600;
        color: #667eea;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .progress-indicator .step-label {
            font-size: 10px;
        }

        .progress-indicator .step-circle {
            width: 40px;
            height: 40px;
            font-size: 14px;
        }

        .progress-indicator .step-line {
            margin-bottom: 28px;
        }
    }

    /* Loading State */
    .btn-primary.loading {
        position: relative;
        color: transparent;
    }

    .btn-primary.loading::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 3px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spinner 0.6s linear infinite;
    }

    @keyframes spinner {
        to {
            transform: rotate(360deg);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Image Preview with validation
    function previewImage(event) {
        const file = event.target.files[0];
        
        if (file) {
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak valid. Gunakan JPG, JPEG, atau PNG.');
                document.getElementById('foto').value = '';
                return;
            }
            
            // Validate file size (2MB)
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

    // Character counter
    document.getElementById('deskripsi').addEventListener('input', function() {
        const count = this.value.length;
        document.getElementById('charCount').textContent = count;
        
        if (count > 900) {
            document.getElementById('charCount').classList.add('text-danger');
        } else {
            document.getElementById('charCount').classList.remove('text-danger');
        }
    });

    // File input change event
    document.getElementById('foto').addEventListener('change', previewImage);

    // Drag and drop functionality
    const uploadArea = document.getElementById('uploadArea');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.add('dragover');
        }, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.remove('dragover');
        }, false);
    });
    
    uploadArea.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            document.getElementById('foto').files = files;
            previewImage({ target: { files: files } });
        }
    });

    // Form submission with loading state
    document.getElementById('alatForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    });

    // Progress indicator update based on scroll
    const sections = document.querySelectorAll('.form-section');
    const steps = document.querySelectorAll('.step');
    
    window.addEventListener('scroll', function() {
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (pageYOffset >= (sectionTop - 200)) {
                current = section.getAttribute('data-section');
            }
        });
        
        steps.forEach(step => {
            step.classList.remove('active');
            if (step.getAttribute('data-step') === current) {
                step.classList.add('active');
            }
        });
    });

    // Real-time validation feedback
    document.querySelectorAll('[data-validation="required"]').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });

    // Auto-save to localStorage (optional)
    const formInputs = document.querySelectorAll('#alatForm input, #alatForm select, #alatForm textarea');
    
    // Load saved data
    formInputs.forEach(input => {
        const savedValue = localStorage.getItem('alat_' + input.name);
        if (savedValue && input.type !== 'file') {
            if (input.type === 'radio') {
                if (input.value === savedValue) {
                    input.checked = true;
                }
            } else {
                input.value = savedValue;
            }
        }
    });
    
    // Save data on change
    formInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.type !== 'file') {
                localStorage.setItem('alat_' + this.name, this.value);
            }
        });
    });
    
    // Clear localStorage on successful submit
    document.getElementById('alatForm').addEventListener('submit', function() {
        formInputs.forEach(input => {
            localStorage.removeItem('alat_' + input.name);
        });
    });

    // Smooth scroll to first error
    @if ($errors->any())
        window.addEventListener('load', function() {
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        });
    @endif
</script>
@endpush
@endsection