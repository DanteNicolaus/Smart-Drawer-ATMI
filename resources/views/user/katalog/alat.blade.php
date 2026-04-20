@extends('layouts.user')

@section('title', 'Katalog - ' . $laci->nama_laci)

@push('styles')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Breadcrumb / back */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        color: #888;
    }
    .breadcrumb a { color: #7c4dff; text-decoration: none; font-weight: 600; }
    .breadcrumb a:hover { text-decoration: underline; }

    /* Page Header */
    .page-header { margin-bottom: 28px; text-align: center; }
    .page-header h1 { font-size: 28px; color: #333; font-weight: 700; margin-bottom: 8px; }
    .page-header p  { color: #666; font-size: 15px; }

    /* Step Indicator */
    .steps {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 24px;
    }
    .step { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; }
    .step-circle { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; }
    .step.done   .step-circle { background: #4caf50; color: white; }
    .step.done   .step-label  { color: #4caf50; }
    .step.active .step-circle  { background: linear-gradient(135deg, #7c4dff, #b388ff); color: white; }
    .step.active .step-label   { color: #7c4dff; }
    .step.inactive .step-circle { background: #e0e0e0; color: #aaa; }
    .step.inactive .step-label  { color: #aaa; }
    .step-line { width: 50px; height: 2px; background: #e0e0e0; border-radius: 2px; }
    .step-line.done { background: #4caf50; }

    /* Laci Info Banner */
    .laci-banner {
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        border-radius: 18px;
        padding: 20px 24px;
        color: white;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 6px 20px rgba(124,77,255,0.3);
    }
    .laci-banner-left h2 { font-size: 20px; font-weight: 700; margin: 0 0 4px; }
    .laci-banner-left p  { margin: 0; opacity: 0.85; font-size: 13px; }
    .laci-banner-right   { text-align: right; }
    .laci-banner-right .stat { font-size: 28px; font-weight: 800; }
    .laci-banner-right .stat-label { font-size: 12px; opacity: 0.8; }

    /* Filter */
    .filter-section {
        background: white;
        padding: 20px;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        margin-bottom: 28px;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .filter-form { display: flex; gap: 12px; flex-wrap: wrap; }
    .f-search  { flex: 2; min-width: 200px; }
    .f-kategori{ flex: 1; min-width: 150px; }
    .f-btn     { flex-shrink: 0; }

    .form-control, .form-select {
        width: 100%;
        border-radius: 12px;
        border: 2px solid #e8eaf6;
        padding: 11px 15px;
        font-size: 14px;
        transition: all 0.25s;
        background: #fafafa;
        font-family: inherit;
        color: #333;
        box-sizing: border-box;
    }
    .form-control:focus, .form-select:focus {
        border-color: #7c4dff;
        box-shadow: 0 0 0 3px rgba(124,77,255,0.1);
        outline: none;
        background: white;
    }

    .btn-filter {
        padding: 11px 24px;
        background: linear-gradient(135deg, #7c4dff, #b388ff);
        border: none;
        border-radius: 12px;
        font-weight: 600;
        color: white;
        cursor: pointer;
        font-family: inherit;
        font-size: 14px;
        white-space: nowrap;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(124,77,255,0.3);
    }
    .btn-filter:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(124,77,255,0.4); }

    /* Alat Grid */
    .alat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 22px;
        margin-bottom: 28px;
    }

    .alat-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
    }
    .alat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(135deg, #7c4dff, #b388ff);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    .alat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(124,77,255,0.15); border-color: #b388ff; }
    .alat-card:hover::before { transform: scaleX(1); }

    .alat-image {
        position: relative;
        height: 190px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .alat-image img { width: 100%; height: 100%; object-fit: cover; }
    .no-image { font-size: 60px; opacity: 0.3; }

    .badge-available, .badge-unavailable {
        position: absolute;
        top: 10px; right: 10px;
        padding: 5px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    }
    .badge-available   { background: linear-gradient(135deg, #81c784, #66bb6a); color: white; }
    .badge-unavailable { background: linear-gradient(135deg, #e57373, #ef5350); color: white; }

    .alat-content { padding: 20px; }
    .alat-content h3 { font-size: 18px; color: #333; margin-bottom: 4px; font-weight: 600; }
    .kode-alat { font-size: 12px; color: #999; margin-bottom: 14px; }

    .alat-info {
        padding: 12px;
        background: linear-gradient(135deg, #f8f9fa, #fff);
        border-radius: 10px;
        margin-bottom: 12px;
    }
    .info-item { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 6px; }
    .info-item:last-child { margin-bottom: 0; }
    .info-item .label { color: #666; }
    .info-item .value { color: #333; font-weight: 600; }

    /* Stat badges (dari index) */
    .alat-stats { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
    .stat-badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .stat-tersedia { background: #e8f5e9; color: #2e7d32; }
    .stat-habis    { background: #fce4ec; color: #c62828; }
    .stat-kategori { background: #ede7f6; color: #5e35b1; }

    .btn-detail {
        display: block;
        width: 100%;
        padding: 11px 0;
        background: linear-gradient(135deg, #7c4dff, #b388ff);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(124,77,255,0.3);
        box-sizing: border-box;
    }
    .btn-detail:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(124,77,255,0.4); color: white; }

    /* Arrow (dari index) */
    .alat-arrow {
        position: absolute;
        right: 16px; top: 16px;
        font-size: 18px; color: #ccc;
        transition: all 0.3s;
    }
    .alat-card:hover .alat-arrow { color: #7c4dff; transform: translateX(4px); }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 70px 20px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    .empty-icon { font-size: 72px; margin-bottom: 16px; opacity: 0.4; }
    .empty-state h3 { font-size: 22px; color: #333; margin-bottom: 8px; }
    .empty-state p  { color: #666; margin-bottom: 26px; }

    .btn-reset {
        display: inline-block;
        padding: 12px 28px;
        background: linear-gradient(135deg, #7c4dff, #b388ff);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(124,77,255,0.3);
    }
    .btn-reset:hover { transform: translateY(-2px); color: white; }

    .pagination-wrapper { display: flex; justify-content: center; margin-top: 26px; }

    @media (max-width: 768px) {
        .laci-banner { flex-direction: column; gap: 12px; }
        .laci-banner-right { text-align: left; }
        .filter-form { flex-direction: column; }
        .f-search, .f-kategori, .f-btn { flex: unset; width: 100%; }
        .alat-grid { grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); }
        .steps { flex-wrap: wrap; gap: 6px; }
        .step-line { width: 24px; }
    }
    @media (max-width: 480px) {
        .alat-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="container">

    <!-- Breadcrumb (lengkap: Katalog > Lab > Laci) -->
    <div class="breadcrumb">
        <a href="{{ route('user.katalog') }}">🏫 Katalog</a>
        <span>›</span>
        <a href="{{ route('user.katalog.lab', $lab->id) }}">{{ $lab->nama_lab }}</a>
        <span>›</span>
        <span style="color:#333; font-weight:600;">{{ $laci->nama_laci }}</span>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <h1>📦 Alat di {{ $laci->nama_laci }}</h1>
        <p>{{ $lab->nama_lab }} — pilih alat yang ingin kamu pinjam</p>
    </div>

    <!-- Step Indicator (4 langkah, konsisten dengan index) -->
    <div class="steps">
        <div class="step done">
            <div class="step-circle">✓</div>
            <span class="step-label">Pilih Lab</span>
        </div>
        <div class="step-line done"></div>
        <div class="step done">
            <div class="step-circle">✓</div>
            <span class="step-label">Pilih Laci</span>
        </div>
        <div class="step-line done"></div>
        <div class="step active">
            <div class="step-circle">3</div>
            <span class="step-label">Lihat Alat</span>
        </div>
        <div class="step-line"></div>
        <div class="step inactive">
            <div class="step-circle">4</div>
            <span class="step-label">Detail & Pinjam</span>
        </div>
    </div>

    <!-- Laci Banner -->
    <div class="laci-banner">
        <div class="laci-banner-left">
            <h2>🗄️ {{ $laci->nama_laci }}</h2>
            <p>
                {{ $laci->kode_laci }}
                @if($laci->lokasi) • 📍 {{ $laci->lokasi }} @endif
                • 🏫 {{ $lab->nama_lab }}
            </p>
            @if($laci->deskripsi)
            <p style="margin-top: 4px; font-size: 13px;">{{ $laci->deskripsi }}</p>
            @endif
        </div>
        <div class="laci-banner-right">
            <div class="stat">{{ $alat->total() }}</div>
            <div class="stat-label">Total Alat</div>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-section">
        <form method="GET" action="{{ route('user.katalog.laci', [$lab->id, $laci->id]) }}" class="filter-form">
            <div class="f-search">
                <input type="text" name="search" class="form-control"
                       placeholder="🔎 Cari nama alat atau kode..."
                       value="{{ request('search') }}">
            </div>
            <div class="f-kategori">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                        {{ $kat }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="f-btn">
                <button type="submit" class="btn-filter">Filter</button>
            </div>
        </form>
    </div>

    <!-- Alat Grid -->
    @if($alat->count() > 0)
        <div class="alat-grid">
            @foreach($alat as $item)
            <div class="alat-card">
                <span class="alat-arrow">→</span>

                <div class="alat-image">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}"
                             alt="{{ $item->nama_alat }}"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <div class="no-image" style="display:none;">📦</div>
                    @else
                        <div class="no-image">📦</div>
                    @endif

                    @if($item->jumlah_tersedia > 0)
                        <span class="badge-available">Tersedia</span>
                    @else
                        <span class="badge-unavailable">Habis</span>
                    @endif
                </div>

                <div class="alat-content">
                    <h3>{{ $item->nama_alat }}</h3>
                    <p class="kode-alat">{{ $item->kode_alat }}</p>

                    <!-- Stat Badges (dari index) -->
                    <div class="alat-stats">
                        <span class="stat-badge stat-kategori">{{ $item->kategori }}</span>
                        @if($item->jumlah_tersedia > 0)
                            <span class="stat-badge stat-tersedia">{{ $item->jumlah_tersedia }} tersedia</span>
                        @else
                            <span class="stat-badge stat-habis">Stok habis</span>
                        @endif
                    </div>

                    <div class="alat-info">
                        <div class="info-item">
                            <span class="label">Kategori:</span>
                            <span class="value">{{ $item->kategori }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Tersedia:</span>
                            <span class="value">{{ $item->jumlah_tersedia }} / {{ $item->jumlah_total }} unit</span>
                        </div>
                    </div>

                    <a href="{{ route('user.alat.detail', $item->id) }}" class="btn-detail">
                        👁️ Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $alat->appends(request()->query())->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🔍</div>
            <h3>Tidak Ada Alat</h3>
            <p>Tidak ada alat yang sesuai dengan pencarian di laci ini</p>
            <a href="{{ route('user.katalog.laci', [$lab->id, $laci->id]) }}" class="btn-reset">Reset Filter</a>
        </div>
    @endif
</div>
@endsection