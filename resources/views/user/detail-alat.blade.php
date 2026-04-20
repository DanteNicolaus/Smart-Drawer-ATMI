@extends('layouts.user')

@section('title', 'Detail Alat - ' . $alat->nama_alat)

@push('styles')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Breadcrumb */
    .breadcrumb-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
        font-size: 14px;
        background: white;
        padding: 14px 20px;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        flex-wrap: wrap;
    }

    .breadcrumb-wrapper a {
        color: #7c4dff;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .breadcrumb-wrapper a:hover { color: #5e35b1; }
    .breadcrumb-wrapper span { color: #bbb; }
    .breadcrumb-wrapper .current { color: #555; }

    /* Detail Wrapper */
    .detail-wrapper {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 28px;
        background: white;
        padding: 36px;
        border-radius: 24px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
    }

    /* Image Section */
    .alat-image-section { position: relative; }

    .main-image {
        width: 100%;
        height: 360px;
        object-fit: cover;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .no-image-placeholder {
        width: 100%;
        height: 360px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 18px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .no-image-placeholder span { font-size: 72px; opacity: 0.25; }
    .no-image-placeholder p { color: #aaa; margin-top: 10px; font-size: 14px; }

    .status-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        padding: 9px 18px;
        border-radius: 14px;
        font-weight: 600;
        font-size: 13px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.14);
    }

    .status-badge.available   { background: linear-gradient(135deg, #81c784, #66bb6a); color: white; }
    .status-badge.unavailable { background: linear-gradient(135deg, #e57373, #ef5350); color: white; }

    /* Info Section */
    .alat-info-section {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .alat-title {
        font-size: 30px;
        color: #333;
        margin: 0;
        font-weight: 700;
        line-height: 1.2;
    }

    .alat-code { font-size: 15px; color: #aaa; margin: 0; }

    /* Info Box */
    .info-box-pinjam {
        background: linear-gradient(135deg, #fff9e6 0%, #ffecb3 50%);
        border-left: 4px solid #ffb74d;
        padding: 14px 16px;
        border-radius: 12px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .info-icon { font-size: 24px; flex-shrink: 0; }
    .info-text { color: #e65100; line-height: 1.5; font-size: 14px; }

    /* Specs */
    .specifications h3, .description h3 {
        font-size: 18px;
        color: #333;
        margin-bottom: 14px;
        font-weight: 600;
    }

    .spec-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .spec-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 15px;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.25s;
    }

    .spec-item:hover { transform: translateY(-2px); box-shadow: 0 4px 14px rgba(0,0,0,0.07); }

    .spec-label { font-size: 12px; color: #888; font-weight: 500; }
    .spec-value { font-size: 15px; font-weight: 600; color: #333; }
    .text-success { color: #66bb6a !important; }
    .text-danger  { color: #ef5350 !important; }

    /* Description */
    .description {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 18px;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .description p {
        color: #555;
        line-height: 1.8;
        font-size: 14px;
        margin: 0;
    }

    /* Action */
    .btn-back {
        display: inline-block;
        padding: 13px 28px;
        background: linear-gradient(135deg, #9e9e9e 0%, #757575 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(117, 117, 117, 0.3);
        font-size: 14px;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(117, 117, 117, 0.4);
        color: white;
    }

    /* =========== RESPONSIVE =========== */
    @media (max-width: 900px) {
        .detail-wrapper {
            grid-template-columns: 1fr;
            padding: 24px;
            gap: 22px;
        }

        .main-image,
        .no-image-placeholder {
            height: 260px;
        }
    }

    @media (max-width: 600px) {
        .container { padding: 16px 12px; }

        .detail-wrapper { padding: 18px; }

        .alat-title { font-size: 24px; }

        .spec-grid { grid-template-columns: 1fr 1fr; }

        .main-image,
        .no-image-placeholder { height: 220px; }
    }

    @media (max-width: 400px) {
        .spec-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="breadcrumb-wrapper">
        <a href="{{ route('user.dashboard') }}">🏠 Dashboard</a>
        <span>/</span>
        <a href="{{ route('user.katalog') }}">📦 Katalog</a>
        <span>/</span>
        <span class="current">{{ $alat->nama_alat }}</span>
    </div>

    <div class="detail-wrapper">
        <!-- Image -->
        <div class="alat-image-section">
            @if($alat->gambar)
                <img src="{{ asset('storage/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}" class="main-image">
            @else
                <div class="no-image-placeholder">
                    <span>📦</span>
                    <p>Tidak ada gambar</p>
                </div>
            @endif

            <div class="status-badge {{ $alat->jumlah_tersedia > 0 ? 'available' : 'unavailable' }}">
                {{ $alat->jumlah_tersedia > 0 ? '✔ Tersedia' : '✖ Tidak Tersedia' }}
            </div>
        </div>

        <!-- Detail -->
        <div class="alat-info-section">
            <div>
                <h1 class="alat-title">{{ $alat->nama_alat }}</h1>
                <p class="alat-code">Kode: {{ $alat->kode_alat }}</p>
            </div>

            <div class="info-box-pinjam">
                <div class="info-icon">💡</div>
                <div class="info-text">
                    <strong>Cara Meminjam:</strong> Datang ke laboratorium dan hubungi Admin Lab untuk meminjam alat ini.
                </div>
            </div>

            <div class="specifications">
                <h3>📊 Spesifikasi</h3>
                <div class="spec-grid">
                    <div class="spec-item">
                        <span class="spec-label">Kategori</span>
                        <span class="spec-value">{{ $alat->kategori }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Lokasi</span>
                        <span class="spec-value">{{ $alat->lokasi }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Total Unit</span>
                        <span class="spec-value">{{ $alat->jumlah_total }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Tersedia</span>
                        <span class="spec-value {{ $alat->jumlah_tersedia > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $alat->jumlah_tersedia }} unit
                        </span>
                    </div>
                </div>
            </div>

            <div class="description">
                <h3>📝 Deskripsi</h3>
                <p>{{ $alat->deskripsi }}</p>
            </div>

            <div>
                <a href="{{ route('user.katalog') }}" class="btn-back">← Kembali ke Katalog</a>
            </div>
        </div>
    </div>
</div>
@endsection