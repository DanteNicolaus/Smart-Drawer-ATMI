@extends('layouts.guest')

@section('title', 'Beranda - Smart Drawer ATMI')

@section('content')
<section class="hero">
    <div class="hero-content">
        <div class="hero-icon">📦</div>
        <h1>Sistem Peminjaman Alat</h1>
        <p class="subtitle">Politeknik ATMI Surakarta</p>
        <p class="description">Kelola peminjaman alat laboratorium dengan mudah dan efisien</p>

        <div class="feature-pills">
            <span class="pill">🔧 Berbagai Alat Tersedia</span>
            <span class="pill">📋 Riwayat Peminjaman</span>
            <span class="pill">⚡ Proses Cepat</span>
        </div>
    </div>
</section>

<style>
    html, body {
        height: 100%;
        overflow: hidden;
    }

    main {
        height: calc(100vh - 64px);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 2rem;
        text-align: center;
    }

    .hero-content {
        max-width: 700px;
        animation: fadeInUp 0.8s ease-out;
    }

    .hero-icon {
        font-size: 4rem;
        margin-bottom: 1.2rem;
        display: block;
        filter: drop-shadow(0 4px 12px rgba(37, 99, 235, 0.2));
    }

    .hero h1 {
        font-size: 2.8rem;
        color: #1d4ed8;
        margin-bottom: 0.6rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .subtitle {
        font-size: 1.3rem;
        color: #2563eb;
        margin-bottom: 1rem;
        font-weight: 500;
        opacity: 0.85;
    }

    .description {
        font-size: 1.05rem;
        color: #6b7280;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .feature-pills {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .pill {
        background: white;
        color: #2563eb;
        padding: 0.55rem 1.2rem;
        border-radius: 999px;
        font-size: 0.88rem;
        font-weight: 500;
        border: 1.5px solid #bfdbfe;
        box-shadow: 0 1px 6px rgba(37, 99, 235, 0.08);
        transition: all 0.2s ease;
    }

    .pill:hover {
        background: #eff6ff;
        border-color: #93c5fd;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(24px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2rem;
        }

        .subtitle {
            font-size: 1.1rem;
        }

        .description {
            font-size: 0.95rem;
        }

        .hero-icon {
            font-size: 3rem;
        }

        .feature-pills {
            gap: 0.5rem;
        }

        .pill {
            font-size: 0.82rem;
            padding: 0.45rem 1rem;
        }
    }

    @media (max-width: 480px) {
        .hero h1 {
            font-size: 1.7rem;
        }
    }
</style>
@endsection