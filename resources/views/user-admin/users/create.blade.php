@extends('layouts.user-admin')

@section('title', 'Tambah User Baru')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="page-header mb-4">
        <div>
            <h1 class="h3 mb-2">
                <i class="fas fa-user-plus"></i> Tambah User Baru
            </h1>
            <p class="text-muted mb-0">Tambahkan user baru ke sistem Smart Drawer ATMI</p>
        </div>
        <a href="{{ route('user-admin.users.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Error -->
    @if($errors->any())
    <div class="alert-error-list">
        <div class="alert-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="alert-content">
            <strong>Terdapat kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Form Section -->
    <div class="row">
        <!-- Form Card -->
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-header">
                    <h6>
                        <i class="fas fa-edit"></i> Form Data User
                    </h6>
                </div>
                <div class="form-body">
                    <form action="{{ route('user-admin.users.store') }}" method="POST">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="form-group">
                            <label for="name">
                                Nama Lengkap <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-input @error('name') error @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}" 
                                placeholder="Contoh: Muhammad Aziz"
                                required
                            >
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NIM -->
                        <div class="form-group">
                            <label for="nim">
                                NIM <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-input @error('nim') error @enderror" 
                                id="nim" 
                                name="nim" 
                                value="{{ old('nim') }}" 
                                placeholder="Contoh: 2200018322"
                                required
                            >
                            @error('nim')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">NIM harus unik dan belum terdaftar</small>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">
                                Email <span class="required">*</span>
                            </label>
                            <input 
                                type="email" 
                                class="form-input @error('email') error @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                placeholder="Contoh: aziz@student.atmi.ac.id"
                                required
                            >
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Email harus unik dan belum terdaftar</small>
                        </div>

                        <!-- Jurusan -->
                        <div class="form-group">
                            <label for="jurusan">
                                Jurusan <span class="required">*</span>
                            </label>
                            <select 
                                class="form-select @error('jurusan') error @enderror" 
                                id="jurusan" 
                                name="jurusan"
                                required
                            >
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="Teknik Mesin Industri" {{ old('jurusan') == 'Teknik Mesin Industri' ? 'selected' : '' }}>Teknik Mesin Industri</option>
                                <option value="Teknik Mekatronika" {{ old('jurusan') == 'Teknik Mekatronika' ? 'selected' : '' }}>Teknik Mekatronika</option>
                                <option value="Teknik Perancangan Manufaktur" {{ old('jurusan') == 'Teknik Perancangan Manufaktur' ? 'selected' : '' }}>Teknik Perancangan Manufaktur</option>
                                <option value="Rekayasa Teknologi Manufaktur" {{ old('jurusan') == 'Rekayasa Teknologi Manufaktur' ? 'selected' : '' }}>Rekayasa Teknologi Manufaktur</option>
                                <option value="Teknologi Rekayasa Mekatronika" {{ old('jurusan') == 'Teknologi Rekayasa Mekatronika' ? 'selected' : '' }}>Teknologi Rekayasa Mekatronika</option>
                                <option value="Perancangan Manufaktur" {{ old('jurusan') == 'Perancangan Manufaktur' ? 'selected' : '' }}>Perancangan Manufaktur</option>
                            </select>
                            @error('jurusan')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No HP -->
                        <div class="form-group">
                            <label for="no_hp">
                                No HP (Opsional)
                            </label>
                            <input 
                                type="text" 
                                class="form-input @error('no_hp') error @enderror" 
                                id="no_hp" 
                                name="no_hp" 
                                value="{{ old('no_hp') }}" 
                                placeholder="Contoh: 081234567890"
                            >
                            @error('no_hp')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">
                                Password <span class="required">*</span>
                            </label>
                            <input 
                                type="password" 
                                class="form-input @error('password') error @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="Minimal 8 karakter"
                                required
                            >
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Password minimal 8 karakter</small>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="form-group">
                            <label for="password_confirmation">
                                Konfirmasi Password <span class="required">*</span>
                            </label>
                            <input 
                                type="password" 
                                class="form-input" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Ketik ulang password"
                                required
                            >
                            <small class="form-hint">Harus sama dengan password di atas</small>
                        </div>

                        <hr class="form-divider">

                        <!-- Buttons -->
                        <div class="form-actions">
                            <a href="{{ route('user-admin.users.index') }}" class="btn-cancel">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i> Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

            <!-- Warning Card -->
            <div class="warning-card">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h6>Perhatian!</h6>
                <p>
                    Pastikan data yang diinput sudah benar sebelum menyimpan. 
                    Data user dapat diedit kembali jika diperlukan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        min-height: 100vh;
    }

    .container-fluid {
        padding: 30px 20px;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h1 {
        color: #333;
        font-weight: 700;
        font-size: 28px;
    }

    .page-header p {
        color: #666;
        font-size: 15px;
    }

    .btn-back {
        padding: 12px 24px;
        background: white;
        color: #666;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid #e8eaf6;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
        border-color: #7c4dff;
        color: #7c4dff;
    }

    /* Alert Error List */
    .alert-error-list {
        display: flex;
        gap: 16px;
        padding: 20px 24px;
        border-radius: 16px;
        margin-bottom: 24px;
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
        color: #c62828;
        box-shadow: 0 4px 16px rgba(239, 83, 80, 0.15);
    }

    .alert-error-list .alert-icon {
        font-size: 24px;
    }

    .alert-error-list ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
    }

    .alert-error-list li {
        margin-bottom: 4px;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }

    .form-header {
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        padding: 20px 28px;
    }

    .form-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 16px;
    }

    .form-body {
        padding: 32px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    label {
        display: block;
        color: #333;
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .required {
        color: #ef5350;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e8eaf6;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
        font-family: inherit;
        background: white;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #7c4dff;
        box-shadow: 0 0 0 3px rgba(124, 77, 255, 0.1);
    }

    .form-input.error, .form-select.error {
        border-color: #ef5350;
    }

    .form-hint {
        display: block;
        color: #999;
        font-size: 12px;
        margin-top: 6px;
    }

    .error-message {
        color: #ef5350;
        font-size: 12px;
        margin-top: 6px;
        font-weight: 500;
    }

    .form-divider {
        border: none;
        border-top: 2px solid #f0f0f0;
        margin: 32px 0;
    }

    .info-box {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 50%);
        padding: 16px 20px;
        border-radius: 12px;
        color: #1976d2;
        font-size: 14px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-box i {
        font-size: 20px;
    }

    .form-actions {
        display: flex;
        gap: 16px;
        justify-content: flex-end;
    }

    .btn-cancel, .btn-submit {
        padding: 14px 32px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel {
        background: #f5f5f5;
        color: #666;
        border: 2px solid #e0e0e0;
    }

    .btn-cancel:hover {
        background: #eeeeee;
        color: #333;
    }

    .btn-submit {
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 77, 255, 0.4);
    }

    /* Info Card */
    .info-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .info-card.blue {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 50%);
    }

    .info-header {
        padding: 20px 24px;
        border-bottom: 2px solid rgba(255,255,255,0.5);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-header i {
        font-size: 20px;
        color: #1976d2;
    }

    .info-header h6 {
        margin: 0;
        font-weight: 600;
        color: #1976d2;
        font-size: 15px;
    }

    .info-body {
        padding: 24px;
    }

    .info-title {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 12px;
    }

    .info-list {
        margin: 0;
        padding-left: 20px;
        font-size: 13px;
        color: #555;
    }

    .info-list li {
        margin-bottom: 8px;
        line-height: 1.6;
    }

    /* Warning Card */
    .warning-card {
        background: linear-gradient(135deg, #fff9e6 0%, #ffecb3 50%);
        border-radius: 20px;
        padding: 28px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }

    .warning-icon {
        font-size: 48px;
        color: #f57f17;
        margin-bottom: 16px;
    }

    .warning-card h6 {
        font-weight: 600;
        color: #f57f17;
        margin-bottom: 12px;
        font-size: 16px;
    }

    .warning-card p {
        font-size: 13px;
        color: #555;
        line-height: 1.6;
        margin: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-format NIM (hanya angka)
    document.getElementById('nim').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Auto-format No HP (hanya angka)
    document.getElementById('no_hp').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Validasi password confirmation
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmation = document.getElementById('password_confirmation').value;
        
        if (password !== confirmation) {
            e.preventDefault();
            alert('Password dan Konfirmasi Password tidak sama!');
            document.getElementById('password_confirmation').focus();
        }
    });
</script>
@endpush