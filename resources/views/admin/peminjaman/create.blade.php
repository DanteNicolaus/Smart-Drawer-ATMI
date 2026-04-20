@extends('layouts.admin')

@section('title', 'Input Peminjaman Baru')

@push('styles')
<style>
    .container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Header */
    .page-header { margin-bottom: 24px; }

    .header-top {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 4px;
    }

    .btn-back-sm {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: #667eea;
        border: 1.5px solid #e8eaf6;
        border-radius: 9px;
        text-decoration: none;
        font-size: 16px;
        flex-shrink: 0;
        transition: all 0.2s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .btn-back-sm:hover { background: #eef2ff; color: #5568d3; border-color: #c7d2fe; }

    .header-top h1 { font-size: 24px; color: #333; margin: 0; font-weight: 700; }

    .header-top p { color: #666; font-size: 14px; margin: 0; }

    /* Layout */
    .form-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 22px;
        align-items: start;
    }

    /* Main Card */
    .form-card {
        background: white;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .form-card-body { padding: 28px; }

    .section-title {
        font-size: 14px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 16px;
        margin-top: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .divider {
        border: none;
        border-top: 1px solid #f0f4f8;
        margin: 22px 0;
    }

    .form-group { margin-bottom: 18px; }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
        font-size: 14px;
    }

    .required { color: #dc2626; }

    .form-control, .form-select {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        background: #fafafa;
        color: #333;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.12);
    }

    .form-control.is-invalid, .form-select.is-invalid { border-color: #dc2626; }
    .invalid-feedback { color: #dc2626; font-size: 12px; margin-top: 5px; }
    .text-muted-sm { display: block; color: #94a3b8; font-size: 12px; margin-top: 5px; }

    textarea.form-control { resize: vertical; min-height: 110px; }

    /* Koin Info Alerts */
    .koin-alert {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 14px;
        margin-top: 10px;
        display: none;
    }

    .koin-alert.info    { background: #e3f2fd; color: #1565c0; border-left: 4px solid #2196f3; }
    .koin-alert.warning { background: #fff9e6; color: #b45309; border-left: 4px solid #f59e0b; }

    /* Actions */
    .form-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 4px; }

    .btn-submit {
        padding: 12px 28px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.25s;
        box-shadow: 0 4px 12px rgba(102,126,234,0.35);
    }

    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,0.45); }
    .btn-submit:disabled { opacity: 0.55; cursor: not-allowed; transform: none; }

    .btn-cancel {
        padding: 12px 24px;
        background: #f1f5f9;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-cancel:hover { background: #e2e8f0; color: #334155; }

    /* Sidebar Info Cards */
    .info-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.07);
        padding: 20px;
        margin-bottom: 16px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .info-card:last-child { margin-bottom: 0; }

    .info-card h6 {
        font-size: 14px;
        font-weight: 700;
        color: #333;
        margin-bottom: 12px;
    }

    .info-card ul { padding-left: 18px; margin: 0; }
    .info-card li { font-size: 13px; color: #64748b; margin-bottom: 7px; line-height: 1.5; }
    .info-card li:last-child { margin-bottom: 0; }

    .info-card p { font-size: 13px; color: #64748b; line-height: 1.6; margin: 0; }

    .info-card.info-bg   { background: linear-gradient(135deg, #e3f2fd, #bbdefb30); }
    .info-card.warn-bg   { background: linear-gradient(135deg, #fff9e6, #fffde730); }

    /* =========== RESPONSIVE =========== */
    @media (max-width: 900px) {
        .form-layout { grid-template-columns: 1fr; }
        .sidebar { order: -1; display: flex; gap: 16px; flex-wrap: wrap; }
        .info-card { flex: 1; min-width: 240px; margin-bottom: 0; }
    }

    @media (max-width: 640px) {
        .container { padding: 16px 12px; }
        .form-card-body { padding: 20px 16px; }
        .form-actions { flex-direction: column-reverse; }
        .btn-submit, .btn-cancel { width: 100%; text-align: center; }
        .sidebar { flex-direction: column; }
        .info-card { min-width: unset; }
    }

    @media (max-width: 480px) {
        .header-top h1 { font-size: 20px; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userSelect   = document.getElementById('user_id');
    const alatSelect   = document.getElementById('alat_id');
    const jumlahInput  = document.getElementById('jumlah_pinjam');
    const koinInfo     = document.getElementById('koinInfo');
    const koinValue    = document.getElementById('koinValue');
    const koinWarning  = document.getElementById('koinWarning');
    const infoTersedia = document.getElementById('infoTersedia');
    const btnSubmit    = document.getElementById('btnSubmit');

    userSelect.addEventListener('change', function() {
        const opt  = this.options[this.selectedIndex];
        const koin = opt.dataset.koin;
        if (this.value) {
            koinValue.textContent = koin;
            if (parseInt(koin) > 0) {
                koinInfo.style.display    = 'block';
                koinWarning.style.display = 'none';
                btnSubmit.disabled        = false;
            } else {
                koinInfo.style.display    = 'none';
                koinWarning.style.display = 'block';
                btnSubmit.disabled        = true;
            }
        } else {
            koinInfo.style.display    = 'none';
            koinWarning.style.display = 'none';
            btnSubmit.disabled        = false;
        }
    });

    alatSelect.addEventListener('change', function() {
        const opt      = this.options[this.selectedIndex];
        const tersedia = opt.dataset.tersedia;
        if (this.value) {
            jumlahInput.max       = tersedia;
            infoTersedia.textContent = 'Maksimal: ' + tersedia + ' unit';
        } else {
            infoTersedia.textContent = '';
        }
    });

    jumlahInput.addEventListener('input', function() {
        if (this.max && parseInt(this.value) > parseInt(this.max)) {
            this.value = this.max;
        }
    });
});
</script>
@endpush

@section('content')
<div class="container">
    <div class="page-header">
        <div class="header-top">
            <a href="{{ route('admin.peminjaman.index') }}" class="btn-back-sm">←</a>
            <div>
                <h1>📝 Input Peminjaman Baru</h1>
                <p>Tambahkan data peminjaman alat oleh user</p>
            </div>
        </div>
    </div>

    <div class="form-layout">
        <!-- Main Form -->
        <div class="form-card">
            <div class="form-card-body">
                <form action="{{ route('admin.peminjaman.store') }}" method="POST" id="formPeminjaman">
                    @csrf

                    <div class="section-title">👤 Data Peminjam</div>

                    <div class="form-group">
                        <label>Pilih User <span class="required">*</span></label>
                        <select name="user_id" id="user_id"
                                class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" data-koin="{{ $user->koin }}"
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->nim }}) — 🪙 {{ $user->koin }} Koin
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        <div id="koinInfo" class="koin-alert info">
                            <strong>🪙 Koin Tersedia:</strong> <span id="koinValue">0</span> koin
                        </div>
                        <div id="koinWarning" class="koin-alert warning">
                            <strong>⚠️ Peringatan:</strong> User ini tidak memiliki koin! Peminjaman tidak dapat diproses.
                        </div>
                    </div>

                    <hr class="divider">
                    <div class="section-title">🔧 Data Alat</div>

                    <div class="form-group">
                        <label>Pilih Alat <span class="required">*</span></label>
                        <select name="alat_id" id="alat_id"
                                class="form-select @error('alat_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Alat --</option>
                            @foreach($alats as $alat)
                            <option value="{{ $alat->id }}" data-tersedia="{{ $alat->jumlah_tersedia }}"
                                    {{ old('alat_id') == $alat->id ? 'selected' : '' }}>
                                {{ $alat->nama_alat }} ({{ $alat->kode_alat }}) — Tersedia: {{ $alat->jumlah_tersedia }} unit
                            </option>
                            @endforeach
                        </select>
                        @error('alat_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Jumlah Pinjam <span class="required">*</span></label>
                        <input type="number" name="jumlah_pinjam" id="jumlah_pinjam"
                               class="form-control @error('jumlah_pinjam') is-invalid @enderror"
                               value="{{ old('jumlah_pinjam', 1) }}" min="1" required>
                        @error('jumlah_pinjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <span class="text-muted-sm" id="infoTersedia"></span>
                    </div>

                    <hr class="divider">
                    <div class="section-title">📅 Tanggal Peminjaman</div>

                    <div class="form-group">
                        <label>Tanggal Pinjam <span class="required">*</span></label>
                        <input type="date" name="tanggal_pinjam"
                               class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                        @error('tanggal_pinjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Rencana Tanggal Kembali <span class="required">*</span></label>
                        <input type="date" name="tanggal_kembali_rencana"
                               class="form-control @error('tanggal_kembali_rencana') is-invalid @enderror"
                               value="{{ old('tanggal_kembali_rencana') }}" required>
                        @error('tanggal_kembali_rencana')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <hr class="divider">
                    <div class="section-title">📋 Detail Peminjaman</div>

                    <div class="form-group">
                        <label>Keperluan <span class="required">*</span></label>
                        <textarea name="keperluan"
                                  class="form-control @error('keperluan') is-invalid @enderror"
                                  rows="4" required
                                  placeholder="Jelaskan keperluan peminjaman alat...">{{ old('keperluan') }}</textarea>
                        @error('keperluan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit" id="btnSubmit">💾 Simpan Peminjaman</button>
                        <a href="{{ route('admin.peminjaman.index') }}" class="btn-cancel">Batal</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="info-card info-bg">
                <h6>ℹ️ Informasi Penting</h6>
                <ul>
                    <li>Pilih user yang akan meminjam alat</li>
                    <li>Pastikan user memiliki koin yang cukup</li>
                    <li>Setiap peminjaman mengurangi 1 koin user</li>
                    <li>Cek ketersediaan alat sebelum input</li>
                    <li>Data langsung masuk ke riwayat user</li>
                </ul>
            </div>
            <div class="info-card warn-bg">
                <h6>🪙 Sistem Koin</h6>
                <p>Setiap kali Admin Lab menginput peminjaman, sistem akan otomatis mengurangi 1 koin dari user. Pastikan user memiliki koin yang cukup.</p>
            </div>
        </div>
    </div>
</div>
@endsection