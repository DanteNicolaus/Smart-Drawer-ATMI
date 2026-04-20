@extends('layouts.user')

@section('title', 'Form Peminjaman')

@push('styles')
<style>
    .container {
        max-width: 960px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .back-link { margin-bottom: 18px; }

    .back-link a {
        color: #7c4dff;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        background: white;
        border-radius: 12px;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        font-size: 14px;
    }

    .back-link a:hover {
        background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.2);
    }

    /* Container */
    .form-container {
        background: white;
        border-radius: 22px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    /* Alat Preview */
    .alat-preview {
        background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
        padding: 28px;
        display: flex;
        gap: 24px;
        align-items: center;
        flex-wrap: wrap;
    }

    .preview-image {
        width: 120px;
        height: 120px;
        border-radius: 16px;
        overflow: hidden;
        background: rgba(255,255,255,0.35);
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-image img { width: 100%; height: 100%; object-fit: cover; }

    .no-image { font-size: 44px; }

    .preview-info { flex: 1; min-width: 200px; }

    .preview-info h2 {
        font-size: 24px;
        margin-bottom: 5px;
        font-weight: 700;
        color: #4527a0;
    }

    .kode { opacity: 0.8; margin-bottom: 16px; font-size: 13px; color: #6a1b9a; }

    .info-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        background: rgba(255,255,255,0.45);
        padding: 10px 14px;
        border-radius: 10px;
        min-width: 90px;
    }

    .info-item .label { font-size: 11px; opacity: 0.8; margin-bottom: 3px; color: #6a1b9a; }
    .info-item .value { font-size: 14px; font-weight: 600; color: #4527a0; }

    /* Form Section */
    .form-section { padding: 36px; }

    .form-section h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .subtitle { color: #666; margin-bottom: 28px; font-size: 14px; }

    .alert-error {
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 22px;
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 50%);
        color: #c62828;
        border-left: 4px solid #ef5350;
        font-size: 14px;
    }

    .form-group { margin-bottom: 24px; }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    label {
        display: block;
        color: #333;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 14px;
    }

    input[type="number"],
    input[type="date"],
    textarea {
        width: 100%;
        padding: 12px 14px;
        border: 2px solid #e8eaf6;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.25s ease;
        font-family: inherit;
        background: #fafafa;
        color: #333;
    }

    input:focus, textarea:focus {
        outline: none;
        border-color: #7c4dff;
        box-shadow: 0 0 0 3px rgba(124, 77, 255, 0.1);
        background: white;
    }

    small { display: block; color: #aaa; font-size: 12px; margin-top: 5px; }

    .error-message { color: #ef5350; font-size: 12px; margin-top: 5px; }

    .info-box {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 50%);
        padding: 20px;
        border-radius: 14px;
        border-left: 4px solid #42a5f5;
        margin-bottom: 28px;
    }

    .info-box h4 { color: #1976d2; margin-bottom: 12px; font-size: 15px; font-weight: 600; }
    .info-box ul { margin-left: 18px; color: #01579b; }
    .info-box li { margin-bottom: 8px; line-height: 1.5; font-size: 14px; }

    .form-actions {
        display: flex;
        gap: 14px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .btn-cancel, .btn-submit {
        padding: 13px 28px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .btn-cancel {
        background: #f5f5f5;
        color: #666;
        border: 2px solid #e0e0e0;
    }

    .btn-cancel:hover { background: #eee; transform: translateY(-1px); }

    .btn-submit {
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 77, 255, 0.4);
    }

    /* =========== RESPONSIVE =========== */
    @media (max-width: 640px) {
        .container { padding: 16px 12px; }

        .alat-preview { padding: 20px; }

        .preview-image { width: 90px; height: 90px; }

        .preview-info h2 { font-size: 20px; }

        .form-section { padding: 24px 18px; }

        .form-row { grid-template-columns: 1fr; }

        .form-actions { flex-direction: column-reverse; }

        .btn-cancel, .btn-submit { width: 100%; text-align: center; }
    }

    @media (max-width: 400px) {
        .alat-preview { flex-direction: column; }
        .preview-image { width: 100px; height: 100px; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="back-link">
        <a href="{{ route('user.katalog') }}">← Kembali ke Katalog</a>
    </div>

    <div class="form-container">
        <div class="alat-preview">
            <div class="preview-image">
                @if($alat->foto)
                    <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}">
                @else
                    <div class="no-image">📦</div>
                @endif
            </div>
            <div class="preview-info">
                <h2>{{ $alat->nama_alat }}</h2>
                <p class="kode">Kode: {{ $alat->kode_alat }}</p>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="label">Kategori</span>
                        <span class="value">{{ $alat->kategori }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Tersedia</span>
                        <span class="value">{{ $alat->jumlah_tersedia }} unit</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Kondisi</span>
                        <span class="value">{{ ucfirst($alat->kondisi) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h1>📝 Form Peminjaman Alat</h1>
            <p class="subtitle">Silakan lengkapi form di bawah ini untuk mengajukan peminjaman</p>

            @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('user.alat.store-pinjam', $alat->id) }}">
                @csrf

                <div class="form-group">
                    <label for="jumlah_pinjam">Jumlah Pinjam *</label>
                    <input type="number" id="jumlah_pinjam" name="jumlah_pinjam"
                           min="1" max="{{ $alat->jumlah_tersedia }}"
                           value="{{ old('jumlah_pinjam', 1) }}" required>
                    <small>Maksimal {{ $alat->jumlah_tersedia }} unit</small>
                    @error('jumlah_pinjam')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggal_pinjam">Tanggal Pinjam *</label>
                        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}" required>
                        @error('tanggal_pinjam')<div class="error-message">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="tanggal_kembali_rencana">Rencana Pengembalian *</label>
                        <input type="date" id="tanggal_kembali_rencana" name="tanggal_kembali_rencana"
                               value="{{ old('tanggal_kembali_rencana') }}"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        @error('tanggal_kembali_rencana')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="keperluan">Keperluan Peminjaman *</label>
                    <textarea id="keperluan" name="keperluan" rows="5"
                              placeholder="Jelaskan keperluan peminjaman alat ini..."
                              required>{{ old('keperluan') }}</textarea>
                    <small>Maksimal 500 karakter</small>
                    @error('keperluan')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="info-box">
                    <h4>ℹ️ Informasi Penting</h4>
                    <ul>
                        <li>Pastikan data yang Anda masukkan sudah benar</li>
                        <li>Peminjaman akan diproses oleh admin dalam 1×24 jam</li>
                        <li>Anda akan menerima notifikasi setelah peminjaman disetujui</li>
                        <li>Harap mengembalikan alat sesuai jadwal yang ditentukan</li>
                        <li>Kerusakan atau kehilangan alat menjadi tanggung jawab peminjam</li>
                    </ul>
                </div>

                <div class="form-actions">
                    <a href="{{ route('user.katalog') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Ajukan Peminjaman</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection