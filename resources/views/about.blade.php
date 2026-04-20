@extends('layouts.guest')

@section('title', 'Tentang - Smart Drawer ATMI')

@section('content')
<div class="about-wrapper">

    {{-- Kolom Kiri --}}
    <div class="left-col">
        <div class="brand-badge">📦 Smart Drawer ATMI</div>
        <h1>Tentang <span>Sistem Kami</span></h1>
        <p class="tagline">Solusi digital peminjaman alat laboratorium untuk Politeknik ATMI Surakarta.</p>

        <div class="info-block">
            <div class="info-icon">🏛️</div>
            <div>
                <strong>Profil ATMI</strong>
                <p>Politeknik ATMI Surakarta adalah institusi pendidikan vokasi terkemuka yang berfokus pada teknologi manufaktur dan rekayasa industri, berdiri sejak 1968.</p>
            </div>
        </div>

        <div class="info-block">
            <div class="info-icon">🎯</div>
            <div>
                <strong>Visi & Misi</strong>
                <p>Menjadi politeknik unggulan yang menghasilkan lulusan kompeten, berkarakter, dan siap bersaing di industri global.</p>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan --}}
    <div class="right-col">

        <div class="card">
            <div class="card-header">⚙️ Tentang Smart Drawer</div>
            <p>Smart Drawer adalah sistem manajemen peminjaman alat laboratorium berbasis web yang dirancang untuk mempermudah proses peminjaman, pengembalian, dan pemantauan alat secara real-time di lingkungan Politeknik ATMI Surakarta.</p>
        </div>

        <div class="card">
            <div class="card-header">👨‍💻 Tim Pengembang</div>
            <div class="team-grid">
                <div class="team-item">
                    <div class="avatar">A</div>
                    <div>
                        <span class="team-name">Angela Tiara Dwi Hapsari</span>
                        <span class="team-role">Electrical Design & Wiring</span>
                    </div>
                </div>
                <div class="team-item">
                    <div class="avatar">B</div>
                    <div>
                        <span class="team-name">Bonifasius Dimas Pranowo</span>
                        <span class="team-role">Frontend & Backend Developer</span>
                    </div>
                </div>
                <div class="team-item">
                    <div class="avatar">C</div>
                    <div>
                        <span class="team-name">Nicolaus Dante Dian Adyatma</span>
                        <span class="team-role">Frontend & Backend Developer</span>
                    </div>
                </div>
                <div class="team-item">
                    <div class="avatar">D</div>
                    <div>
                        <span class="team-name">Ridho Aiyon Subondo</span>
                        <span class="team-role">Mechanical & Design Drawer</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    html, body { height: 100%; overflow: hidden; }

    main {
        height: calc(100vh - 64px);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 1.5rem 2rem;
    }

    .about-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2.5rem;
        width: 100%;
        max-width: 1100px;
        animation: fadeInUp 0.7s ease-out;
    }

    /* Left Column */
    .left-col {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 1rem;
    }

    .brand-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #eff6ff;
        color: #2563eb;
        border: 1.5px solid #bfdbfe;
        padding: 0.35rem 1rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 600;
        width: fit-content;
    }

    .left-col h1 {
        font-size: 2.2rem;
        color: #1e3a8a;
        font-weight: 700;
        line-height: 1.2;
        margin: 0;
    }

    .left-col h1 span { color: #2563eb; }

    .tagline {
        color: #6b7280;
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    .info-block {
        display: flex;
        gap: 0.9rem;
        align-items: flex-start;
        background: white;
        border: 1.5px solid #e0e7ff;
        border-radius: 12px;
        padding: 1rem 1.2rem;
        box-shadow: 0 1px 6px rgba(37, 99, 235, 0.06);
    }

    .info-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
        margin-top: 0.1rem;
    }

    .info-block strong {
        display: block;
        color: #1d4ed8;
        font-size: 0.92rem;
        font-weight: 600;
        margin-bottom: 0.3rem;
    }

    .info-block p {
        color: #6b7280;
        font-size: 0.88rem;
        line-height: 1.6;
        margin: 0;
    }

    /* Right Column */
    .right-col {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 1rem;
    }

    .card {
        background: white;
        border: 1.5px solid #e0e7ff;
        border-radius: 14px;
        padding: 1.2rem 1.4rem;
        box-shadow: 0 2px 10px rgba(37, 99, 235, 0.07);
    }

    .card-header {
        font-weight: 600;
        color: #1d4ed8;
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
        padding-bottom: 0.6rem;
        border-bottom: 1.5px solid #e0e7ff;
    }

    .card p {
        color: #6b7280;
        font-size: 0.88rem;
        line-height: 1.7;
        margin: 0;
    }

    /* Team Grid */
    .team-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .team-item {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        background: #f8faff;
        border: 1px solid #e0e7ff;
        border-radius: 10px;
        padding: 0.6rem 0.8rem;
    }

    .avatar {
        width: 34px;
        height: 34px;
        background: linear-gradient(135deg, #2563eb, #60a5fa);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .team-name {
        display: block;
        color: #1e3a8a;
        font-size: 0.82rem;
        font-weight: 600;
        line-height: 1.3;
    }

    .team-role {
        display: block;
        color: #9ca3af;
        font-size: 0.75rem;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        html, body { overflow: auto; }
        main { height: auto; padding: 1.5rem 1rem; }
        .about-wrapper { grid-template-columns: 1fr; gap: 1.5rem; }
        .left-col h1 { font-size: 1.7rem; }
        .team-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection