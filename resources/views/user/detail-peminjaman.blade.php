@extends('layouts.user')

@section('title', 'Detail Peminjaman')

@push('styles')
<style>
    .container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 11px 22px;
        background: white;
        color: #7c4dff;
        text-decoration: none;
        border-radius: 12px;
        border: 2px solid #e8eaf6;
        font-weight: 600;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 22px;
        font-size: 14px;
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
        border-color: #7c4dff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.2);
        color: #5e35b1;
    }

    /* Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 22px;
    }

    /* Main Card */
    .detail-card {
        background: white;
        border-radius: 22px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .detail-header {
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        padding: 24px 28px;
    }

    .detail-header h2 { margin: 0; font-size: 22px; font-weight: 600; }

    .detail-body { padding: 28px; }

    /* Status Section */
    .status-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 24px;
        margin-bottom: 24px;
        border-bottom: 2px solid #f3f4f6;
        gap: 12px;
        flex-wrap: wrap;
    }

    .label-text { color: #aaa; font-size: 13px; margin-bottom: 5px; font-weight: 500; }

    .kode-text {
        font-size: 24px;
        color: #7c4dff;
        margin: 0;
        font-weight: 700;
        word-break: break-all;
    }

    .badge-large {
        padding: 10px 20px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        white-space: nowrap;
        flex-shrink: 0;
    }

    .badge-pending      { background: linear-gradient(135deg, #ffecb3, #ffe082); color: #f57f17; }
    .badge-disetujui   { background: linear-gradient(135deg, #b3e5fc, #81d4fa); color: #01579b; }
    .badge-ditolak     { background: linear-gradient(135deg, #ffcdd2, #ef9a9a); color: #b71c1c; }
    .badge-dipinjam    { background: linear-gradient(135deg, #bbdefb, #90caf9); color: #0d47a1; }
    .badge-dikembalikan { background: linear-gradient(135deg, #c8e6c9, #a5d6a7); color: #1b5e20; }

    /* Section */
    .section { margin-bottom: 28px; }

    .section-title {
        font-size: 17px;
        color: #333;
        margin-bottom: 14px;
        font-weight: 600;
    }

    .info-grid-detail {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .info-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 16px;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.25s;
    }

    .info-box:hover { transform: translateY(-2px); box-shadow: 0 4px 14px rgba(0,0,0,0.07); }

    .info-label {
        display: block;
        font-size: 11px;
        color: #aaa;
        margin-bottom: 6px;
        font-weight: 500;
    }

    .info-value {
        font-size: 15px;
        color: #333;
        font-weight: 600;
        margin: 0;
    }

    .info-value.highlight { color: #7c4dff; }

    /* Content Boxes */
    .content-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 18px;
        border-radius: 12px;
        border-left: 4px solid #7c4dff;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .content-box p { margin: 0; color: #444; line-height: 1.7; font-size: 14px; }

    .info-box-bg {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 50%);
        border-left-color: #42a5f5;
    }

    .danger-box {
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 50%);
        border-left-color: #ef5350;
    }

    /* Help Card */
    .help-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        padding: 28px 22px;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.05);
        height: fit-content;
    }

    .help-icon { font-size: 44px; margin-bottom: 14px; }

    .help-card h4 { font-size: 17px; color: #333; margin-bottom: 10px; font-weight: 600; }

    .help-card p { color: #666; font-size: 13px; margin-bottom: 20px; line-height: 1.5; }

    .btn-help {
        display: inline-block;
        padding: 11px 24px;
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.3);
    }

    .btn-help:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 77, 255, 0.4);
        color: white;
    }

    /* =========== RESPONSIVE =========== */
    @media (max-width: 900px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .sidebar { order: -1; }

        .help-card {
            display: flex;
            align-items: center;
            gap: 16px;
            text-align: left;
            padding: 20px;
        }

        .help-icon { margin-bottom: 0; font-size: 36px; flex-shrink: 0; }
        .help-card h4, .help-card p { margin-bottom: 6px; }
    }

    @media (max-width: 600px) {
        .container { padding: 16px 12px; }

        .detail-body { padding: 20px 16px; }

        .info-grid-detail { grid-template-columns: 1fr; }

        .kode-text { font-size: 18px; }

        .status-section { flex-direction: column; align-items: flex-start; }

        .help-card { flex-direction: column; text-align: center; }
        .help-card p { margin-bottom: 14px; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <a href="{{ route('user.riwayat') }}" class="btn-back">← Kembali ke Riwayat</a>

    <div class="detail-grid">
        <!-- Main Content -->
        <div class="main-content">
            <div class="detail-card">
                <div class="detail-header">
                    <h2>📋 Detail Peminjaman</h2>
                </div>
                <div class="detail-body">
                    <!-- Kode & Status -->
                    <div class="status-section">
                        <div>
                            <p class="label-text">Kode Peminjaman</p>
                            <h1 class="kode-text">{{ $peminjaman->kode_peminjaman }}</h1>
                        </div>
                        <span class="badge-large badge-{{ $peminjaman->status }}">
                            {{ $peminjaman->statusLabel }}
                        </span>
                    </div>

                    <!-- Informasi Alat -->
                    <div class="section">
                        <h3 class="section-title">📦 Informasi Alat</h3>
                        <div class="info-grid-detail">
                            <div class="info-box">
                                <span class="info-label">Nama Alat</span>
                                <p class="info-value">{{ $peminjaman->alat->nama_alat }}</p>
                            </div>
                            <div class="info-box">
                                <span class="info-label">Kode Alat</span>
                                <p class="info-value">{{ $peminjaman->alat->kode_alat }}</p>
                            </div>
                            <div class="info-box">
                                <span class="info-label">Kategori</span>
                                <p class="info-value">{{ $peminjaman->alat->kategori ?? '-' }}</p>
                            </div>
                            <div class="info-box">
                                <span class="info-label">Jumlah Dipinjam</span>
                                <p class="info-value highlight">{{ $peminjaman->jumlah_pinjam }} unit</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Waktu -->
                    <div class="section">
                        <h3 class="section-title">📅 Informasi Waktu</h3>
                        <div class="info-grid-detail">
                            <div class="info-box">
                                <span class="info-label">Tanggal Pinjam</span>
                                <p class="info-value">📅 {{ $peminjaman->tanggal_pinjam->format('d F Y') }}</p>
                            </div>
                            @if($peminjaman->tanggal_kembali_aktual)
                            <div class="info-box">
                                <span class="info-label">Tanggal Kembali Aktual</span>
                                <p class="info-value">✅ {{ $peminjaman->tanggal_kembali_aktual->format('d F Y') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Keperluan -->
                    <div class="section">
                        <h3 class="section-title">📝 Keperluan</h3>
                        <div class="content-box">
                            <p>{{ $peminjaman->keperluan ?? '-' }}</p>
                        </div>
                    </div>

                    @if($peminjaman->kondisi_saat_kembali)
                    <div class="section">
                        <h3 class="section-title">🔍 Kondisi Saat Kembali</h3>
                        <div class="content-box info-box-bg">
                            <p>{{ $peminjaman->kondisi_saat_kembali }}</p>
                        </div>
                    </div>
                    @endif

                    @if($peminjaman->catatan_admin)
                    <div class="section">
                        <h3 class="section-title">💬 Catatan Admin</h3>
                        <div class="content-box {{ $peminjaman->status == 'ditolak' ? 'danger-box' : 'info-box-bg' }}">
                            <p><strong>ℹ️</strong> {{ $peminjaman->catatan_admin }}</p>
                        </div>
                    </div>
                    @endif

                    @if($peminjaman->catatan_pengembalian)
                    <div class="section">
                        <h3 class="section-title">📌 Catatan Pengembalian</h3>
                        <div class="content-box">
                            <p>{{ $peminjaman->catatan_pengembalian }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="help-card">
                <div class="help-icon">ℹ️</div>
                <div>
                    <h4>Butuh Bantuan?</h4>
                    <p>Hubungi admin jika ada pertanyaan tentang peminjaman Anda</p>
                    <a href="{{ route('user.dashboard') }}" class="btn-help">📧 Hubungi Admin</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection