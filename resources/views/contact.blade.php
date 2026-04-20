@extends('layouts.guest')

@section('title', 'Kontak - Smart Drawer ATMI')

@section('content')
<div class="contact-wrapper">

    {{-- Kolom Kiri: Info Kontak --}}
    <div class="left-col">
        <div class="brand-badge">📬 Hubungi Kami</div>
        <h1>Kontak & <span>Dukungan</span></h1>
        <p class="tagline">Ada pertanyaan atau kendala? Jangan ragu untuk menghubungi kami.</p>

        <div class="contact-list">
            <div class="contact-item">
                <div class="contact-icon">📍</div>
                <div>
                    <strong>Alamat</strong>
                    <p>Jl. Adi Sucipto No.KM 9.5, Blukukan Dua, Blulukan, Kec. Colomadu, Kabupaten Karanganyar, Jawa Tengah 57174</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">📞</div>
                <div>
                    <strong>Telepon / WhatsApp</strong>
                    <p>
                        <a href="tel:+62271634971">(0271) 634971</a><br>
                        <a href="https://wa.me/6281234567890" target="_blank">+62 812-3456-7890</a>
                    </p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">✉️</div>
                <div>
                    <strong>Email</strong>
                    <p><a href="mailto:https://www.atmi.ac.id/">https://www.atmi.ac.id/</a></p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">🕐</div>
                <div>
                    <strong>Jam Operasional</strong>
                    <p>Senin – Jumat: 08.00 – 17.00 WIB</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Form --}}
    <div class="right-col">
        <div class="form-card">
            <div class="form-header">
                <div class="form-header-icon">📝</div>
                <div>
                    <h2>Kirim Pesan</h2>
                    <p>Isi formulir dan kami akan segera merespons.</p>
                </div>
            </div>

            <div class="form-divider"></div>

            <p class="form-desc">
                Gunakan formulir Google Form berikut untuk mengirimkan pertanyaan, saran, atau laporan kendala kepada tim Smart Drawer ATMI.
            </p>

            <div class="form-features">
                <div class="feature-row">
                    <span class="check">✓</span>
                    <span>Respons dalam 1×24 jam kerja</span>
                </div>
                <div class="feature-row">
                    <span class="check">✓</span>
                    <span>Formulir aman & terverifikasi</span>
                </div>
                <div class="feature-row">
                    <span class="check">✓</span>
                    <span>Bisa melampirkan screenshot</span>
                </div>
            </div>

            {{-- Ganti URL di bawah dengan link Google Form Anda --}}
            <a href="https://forms.gle/FGTv6HTKBn8itm8B6" target="_blank" class="btn-gform">
                <span class="btn-icon">📋</span>
                Buka Google Form
                <span class="btn-arrow">→</span>
            </a>

            <p class="form-note">
                * Pastikan Anda login dengan akun Google sebelum mengisi formulir.
            </p>
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

    .contact-wrapper {
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

    .contact-list {
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
    }

    .contact-item {
        display: flex;
        gap: 0.9rem;
        align-items: flex-start;
        background: white;
        border: 1.5px solid #e0e7ff;
        border-radius: 12px;
        padding: 0.85rem 1.1rem;
        box-shadow: 0 1px 6px rgba(37, 99, 235, 0.05);
        transition: border-color dock 0.2s;
    }

    .contact-item:hover {
        border-color: #93c5fd;
    }

    .contact-icon {
        font-size: 1.3rem;
        flex-shrink: 0;
        margin-top: 0.1rem;
    }

    .contact-item strong {
        display: block;
        color: #1d4ed8;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.2rem;
    }

    .contact-item p {
        color: #6b7280;
        font-size: 0.85rem;
        line-height: 1.6;
        margin: 0;
    }

    .contact-item a {
        color: #2563eb;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .contact-item a:hover { text-decoration: underline; }

    /* Right Column */
    .right-col {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-card {
        background: white;
        border: 1.5px solid #e0e7ff;
        border-radius: 16px;
        padding: 1.6rem 1.8rem;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.08);
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        margin-bottom: 1rem;
    }

    .form-header-icon {
        font-size: 2rem;
        background: #eff6ff;
        border-radius: 10px;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .form-header h2 {
        color: #1e3a8a;
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0 0 0.15rem 0;
    }

    .form-header p {
        color: #9ca3af;
        font-size: 0.83rem;
        margin: 0;
    }

    .form-divider {
        height: 1.5px;
        background: #e0e7ff;
        margin-bottom: 1rem;
    }

    .form-desc {
        color: #6b7280;
        font-size: 0.88rem;
        line-height: 1.7;
        margin: 0 0 1rem 0;
    }

    .form-features {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        margin-bottom: 1.4rem;
    }

    .feature-row {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        font-size: 0.85rem;
        color: #4b5563;
    }

    .check {
        width: 20px;
        height: 20px;
        background: #dcfce7;
        color: #16a34a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .btn-gform {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        text-decoration: none;
        padding: 0.85rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        transition: all 0.25s ease;
        margin-bottom: 0.8rem;
    }

    .btn-gform:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4);
    }

    .btn-icon { font-size: 1.1rem; }

    .btn-arrow {
        margin-left: auto;
        font-size: 1.1rem;
        transition: transform 0.2s;
    }

    .btn-gform:hover .btn-arrow { transform: translateX(4px); }

    .form-note {
        color: #9ca3af;
        font-size: 0.78rem;
        text-align: center;
        margin: 0;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        html, body { overflow: auto; }
        main { height: auto; padding: 1.5rem 1rem; }
        .contact-wrapper { grid-template-columns: 1fr; gap: 1.5rem; }
        .left-col h1 { font-size: 1.7rem; }
        .form-card { padding: 1.2rem; }
    }
</style>
@endsection