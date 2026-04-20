@extends('layouts.user')

@section('title', 'Dashboard User')

@push('styles')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
        color: #5e35b1;
        padding: 40px;
        border-radius: 24px;
        margin-bottom: 30px;
        box-shadow: 0 8px 32px rgba(94, 53, 177, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.8);
    }

    .welcome-content h1 {
        font-size: 28px;
        margin-bottom: 8px;
        font-weight: 700;
        color: #4527a0;
        line-height: 1.3;
    }

    .welcome-content > p {
        font-size: 15px;
        opacity: 0.8;
        margin-bottom: 20px;
        color: #6a1b9a;
    }

    /* Koin Display */
    .koin-display {
        background: rgba(255,255,255,0.45);
        backdrop-filter: blur(10px);
        padding: 20px;
        border-radius: 16px;
        margin-top: 16px;
        border: 1px solid rgba(255, 255, 255, 0.6);
    }

    .koin-badge {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 14px;
    }

    .koin-icon { font-size: 40px; }

    .koin-label {
        font-size: 13px;
        opacity: 0.8;
        margin-bottom: 4px;
        color: #6a1b9a;
    }

    .koin-value {
        font-size: 28px;
        font-weight: 700;
        color: #4527a0;
        line-height: 1;
    }

    .koin-progress {
        height: 10px;
        background: rgba(94, 53, 177, 0.2);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .koin-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #7c4dff, #b388ff);
        border-radius: 10px;
    }

    .koin-hint {
        display: block;
        text-align: center;
        opacity: 0.7;
        color: #6a1b9a;
        font-size: 13px;
    }

    /* Alert */
    .alert {
        border-radius: 14px;
        border: none;
        padding: 14px 18px;
        margin-bottom: 20px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.07);
        font-size: 14px;
    }

    .alert-warning { background: #fff9e6; color: #b45309; }
    .alert-info    { background: #e3f2fd; color: #1565c0; }

    /* Quick Actions */
    .quick-actions h2,
    .active-section h2 {
        font-size: 22px;
        color: #333;
        margin-bottom: 18px;
        font-weight: 700;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 18px;
        margin-bottom: 36px;
    }

    .action-card {
        background: white;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        display: block;
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        color: inherit;
    }

    .action-icon-wrapper {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        box-shadow: 0 4px 12px rgba(94, 53, 177, 0.1);
    }

    .action-icon { font-size: 28px; }

    .action-card h3 {
        font-size: 18px;
        color: #333;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .action-card p {
        color: #666;
        line-height: 1.5;
        font-size: 14px;
        margin: 0;
    }

    /* Peminjaman Aktif */
    .peminjaman-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 18px;
    }

    .peminjaman-card {
        background: white;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .peminjaman-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(0,0,0,0.1);
    }

    .peminjaman-header {
        padding: 18px 20px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .peminjaman-header h3 {
        font-size: 16px;
        color: #333;
        margin-bottom: 4px;
        font-weight: 600;
    }

    .kode { font-size: 12px; color: #999; }

    .badge {
        padding: 5px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .badge-warning { background: #fff9e6; color: #f59e0b; }
    .badge-info    { background: #e3f2fd; color: #1976d2; }
    .badge-primary { background: #e8eaf6; color: #5e35b1; }

    .peminjaman-body { padding: 18px 20px; }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .info-row .label { color: #666; }
    .info-row .value { color: #333; font-weight: 600; }

    .peminjaman-footer {
        padding: 14px 20px;
        background: #fafafa;
        text-align: center;
    }

    .btn-detail {
        display: inline-block;
        padding: 10px 24px;
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.3);
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 77, 255, 0.4);
        color: white;
    }

    /* =========== RESPONSIVE =========== */
    @media (max-width: 768px) {
        .container { padding: 20px 14px; }

        .welcome-banner { padding: 28px 20px; border-radius: 18px; }

        .welcome-content h1 { font-size: 22px; }

        .koin-icon { font-size: 32px; }
        .koin-value { font-size: 24px; }

        .actions-grid {
            grid-template-columns: 1fr;
        }

        .action-card {
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .action-icon-wrapper {
            margin-bottom: 0;
            flex-shrink: 0;
        }

        .peminjaman-list {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .container { padding: 16px 12px; }

        .welcome-banner { padding: 22px 16px; }

        .welcome-content h1 { font-size: 19px; }

        .quick-actions h2,
        .active-section h2 { font-size: 18px; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <h1> Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p>Selamat datang di sistem peminjaman alat Smart Drawer ATMI</p>

            <div class="koin-display">
                <div class="koin-badge">
                    <span class="koin-icon">🪙</span>
                    <div class="koin-info">
                        <div class="koin-label">Koin Tersedia</div>
                        <div class="koin-value">{{ auth()->user()->koin }} / 10</div>
                    </div>
                </div>
                <div class="koin-progress">
                    <div class="koin-progress-bar" style="width: {{ auth()->user()->getPersentaseKoin() }}%"></div>
                </div>
                <small class="koin-hint">💡 1 Koin = 1 Peminjaman</small>
            </div>
        </div>
    </div>

    <!-- Alert Koin -->
    @if(auth()->user()->koin == 0)
    <div class="alert alert-warning" role="alert">
        <strong>⚠️ Koin Anda Habis!</strong> Hubungi Admin Lab jika ingin melakukan peminjaman.
    </div>
    @elseif(auth()->user()->koin <= 2)
    <div class="alert alert-info" role="alert">
        <strong>ℹ️ Koin Hampir Habis!</strong> Anda hanya memiliki {{ auth()->user()->koin }} koin tersisa.
    </div>
    @endif

    <!-- Peminjaman Aktif -->
    @if($peminjamanAktif->count() > 0)
    <div class="active-section">
        <h2>Peminjaman Aktif</h2>
        <div class="peminjaman-list">
            @foreach($peminjamanAktif as $p)
            <div class="peminjaman-card">
                <div class="peminjaman-header">
                    <div>
                        <h3>{{ $p->alat->nama_alat }}</h3>
                        <p class="kode">{{ $p->kode_peminjaman }}</p>
                    </div>
                    <span class="badge badge-{{ $p->status_badge }}">{{ $p->status_label }}</span>
                </div>
                <div class="peminjaman-body">
                    <div class="info-row">
                        <span class="label">Jumlah:</span>
                        <span class="value">{{ $p->jumlah_pinjam }} unit</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Tanggal Pinjam:</span>
                        <span class="value">{{ $p->tanggal_pinjam->format('d M Y') }}</span>
                    </div>
                </div>
                <div class="peminjaman-footer">
                    <a href="{{ route('user.peminjaman.detail', $p->id) }}" class="btn-detail">Lihat Detail</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection