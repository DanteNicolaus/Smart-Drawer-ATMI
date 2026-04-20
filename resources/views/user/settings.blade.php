@extends('layouts.user')

@section('title', 'Pengaturan')

@push('styles')
<style>
    .container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .page-header { margin-bottom: 26px; }

    .page-header h1 {
        font-size: 28px;
        color: #1e293b;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .page-header p { color: #64748b; font-size: 15px; }

    /* Grid */
    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 22px;
    }

    /* Cards */
    .settings-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #f0f4f8;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .card-header h2 {
        font-size: 18px;
        color: #1e293b;
        margin-bottom: 4px;
        font-weight: 600;
    }

    .card-header p { color: #64748b; font-size: 13px; margin: 0; }

    .card-body { padding: 24px; }

    /* Form Group */
    .form-group { margin-bottom: 20px; }

    .form-group label {
        display: block;
        color: #374151;
        font-weight: 600;
        margin-bottom: 7px;
        font-size: 14px;
    }

    .form-group input {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s;
        background: #fafafa;
        font-family: inherit;
        color: #333;
    }

    .form-group input:focus {
        outline: none;
        border-color: #7c4dff;
        background: white;
        box-shadow: 0 0 0 3px rgba(124, 77, 255, 0.1);
    }

    .disabled-input {
        background: #f1f5f9 !important;
        color: #94a3b8 !important;
        cursor: not-allowed;
    }

    .help-text { display: block; color: #94a3b8; font-size: 12px; margin-top: 5px; }
    .error-text { display: block; color: #dc2626; font-size: 12px; margin-top: 5px; }

    /* Buttons */
    .btn-primary-form, .btn-secondary-form {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 8px;
        font-family: inherit;
    }

    .btn-primary-form {
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.3);
    }

    .btn-primary-form:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 77, 255, 0.4);
    }

    .btn-secondary-form {
        background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .btn-secondary-form:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }

    /* Security Sections */
    .security-section {
        padding: 18px;
        background: #f8fafc;
        border-radius: 12px;
        margin-bottom: 18px;
        border: 1px solid #f0f4f8;
    }

    .security-section:last-child { margin-bottom: 0; }

    .security-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        gap: 12px;
    }

    .security-header h3 {
        font-size: 15px;
        color: #1e293b;
        margin-bottom: 3px;
        font-weight: 600;
    }

    .security-desc { color: #64748b; font-size: 13px; margin: 0; }

    /* Toggle Switch */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 26px;
        flex-shrink: 0;
    }

    .toggle-switch input { opacity: 0; width: 0; height: 0; }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background: #cbd5e1;
        transition: .3s;
        border-radius: 26px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background: white;
        transition: .3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    input:checked + .slider { background: linear-gradient(135deg, #7c4dff, #b388ff); }
    input:checked + .slider:before { transform: translateX(26px); }

    /* Alerts */
    .alert-warning-sm, .alert-info-sm {
        padding: 11px 14px;
        border-radius: 8px;
        font-size: 13px;
        margin-top: 10px;
        line-height: 1.5;
    }

    .alert-warning-sm { background: #fff9e6; color: #b45309; border-left: 4px solid #f59e0b; }
    .alert-info-sm    { background: #e3f2fd; color: #1565c0; border-left: 4px solid #2196f3; }

    /* =========== RESPONSIVE =========== */
    @media (max-width: 860px) {
        .settings-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 600px) {
        .container { padding: 16px 12px; }

        .page-header h1 { font-size: 22px; }

        .card-header, .card-body { padding: 18px; }

        .security-section { padding: 14px; }

        .security-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 400px) {
        .container { padding: 14px 10px; }
        .page-header h1 { font-size: 20px; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="page-header">
        <h1>⚙️ Pengaturan Akun</h1>
        <p>Kelola profil dan keamanan akun Anda</p>
    </div>

    <div class="settings-grid">
        <!-- Profile Settings -->
        <div class="settings-card">
            <div class="card-header">
                <h2>👤 Informasi Profil</h2>
                <p>Update informasi pribadi Anda</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.update-profile') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nama Lengkap *</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')<span class="error-text">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" id="nim" value="{{ $user->nim }}" disabled class="disabled-input">
                        <small class="help-text">NIM tidak dapat diubah</small>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" value="{{ $user->email }}" disabled class="disabled-input">
                        <small class="help-text">Email tidak dapat diubah</small>
                    </div>

                    <div class="form-group">
                        <label for="jurusan">Jurusan</label>
                        <input type="text" id="jurusan" name="jurusan"
                               value="{{ old('jurusan', $user->jurusan) }}"
                               placeholder="Contoh: Teknik Mesin">
                    </div>

                    <div class="form-group">
                        <label for="no_hp">No. HP</label>
                        <input type="text" id="no_hp" name="no_hp"
                               value="{{ old('no_hp', $user->no_hp) }}"
                               placeholder="Contoh: 08123456789">
                    </div>

                    <button type="submit" class="btn-primary-form">💾 Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="settings-card">
            <div class="card-header">
                <h2>🔐 Keamanan</h2>
                <p>Kelola password dan akses login</p>
            </div>
            <div class="card-body">

                <!-- Google Login Toggle -->
                <div class="security-section">
                    <div class="security-header">
                        <div>
                            <h3>Login dengan Google</h3>
                            <p class="security-desc">
                                @if($user->google_login_enabled)
                                    Aktif — login via Google atau NIM
                                @else
                                    Nonaktif — hanya login dengan NIM
                                @endif
                            </p>
                        </div>
                        <form method="POST" action="{{ route('user.toggle-google-login') }}" style="display:inline;">
                            @csrf
                            <label class="toggle-switch">
                                <input type="checkbox"
                                       {{ $user->google_login_enabled ? 'checked' : '' }}
                                       onchange="this.form.submit()">
                                <span class="slider"></span>
                            </label>
                        </form>
                    </div>

                    @if(!$user->nim)
                    <div class="alert-warning-sm">⚠️ Anda harus memiliki NIM untuk mengatur login Google</div>
                    @endif

                    @if(!$user->google_login_enabled)
                    <div class="alert-info-sm">
                        ℹ️ <strong>Login Google Dinonaktifkan</strong><br>
                        Jika akun Google hilang, Anda masih bisa login dengan NIM dan password.
                    </div>
                    @endif
                </div>

                <!-- Change Password -->
                <div class="security-section">
                    <h3>Ubah Password</h3>
                    <p class="security-desc" style="margin-bottom: 16px;">Pastikan password Anda kuat dan aman</p>

                    <form method="POST" action="{{ route('user.update-password') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password">Password Lama *</label>
                            <input type="password" id="current_password" name="current_password"
                                   required placeholder="Masukkan password lama">
                            @error('current_password')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password">Password Baru *</label>
                            <input type="password" id="new_password" name="new_password"
                                   required placeholder="Minimal 6 karakter">
                            @error('new_password')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">Konfirmasi Password Baru *</label>
                            <input type="password" id="new_password_confirmation"
                                   name="new_password_confirmation"
                                   required placeholder="Ketik ulang password baru">
                        </div>

                        <button type="submit" class="btn-secondary-form">🔑 Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection