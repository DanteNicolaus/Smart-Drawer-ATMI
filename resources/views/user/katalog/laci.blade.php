@extends('layouts.user')
@section('title', 'Pilih Laci - ' . $lab->nama_lab)
@push('styles')
<style>
    .container { max-width: 1100px; margin: 0 auto; padding: 30px 20px; }
    .breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-size: 14px; color: #888; }
    .breadcrumb a { color: #7c4dff; text-decoration: none; font-weight: 600; }
    .breadcrumb a:hover { text-decoration: underline; }
    .steps { display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 32px; }
    .step { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; }
    .step-circle { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; }
    .step.done .step-circle   { background: #4caf50; color: white; }
    .step.done .step-label    { color: #4caf50; }
    .step.active .step-circle { background: linear-gradient(135deg, #7c4dff, #b388ff); color: white; }
    .step.active .step-label  { color: #7c4dff; }
    .step.inactive .step-circle { background: #e0e0e0; color: #aaa; }
    .step.inactive .step-label  { color: #aaa; }
    .step-line { width: 50px; height: 2px; background: #e0e0e0; border-radius: 2px; }
    .step-line.done { background: #4caf50; }
    .lab-banner { background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%); border-radius: 18px; padding: 20px 24px; color: white; margin-bottom: 24px; box-shadow: 0 6px 20px rgba(124,77,255,0.3); }
    .lab-banner h2 { font-size: 20px; font-weight: 700; margin: 0 0 4px; }
    .lab-banner p  { margin: 0; opacity: 0.85; font-size: 13px; }
    .laci-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
    .laci-card { background: white; border-radius: 20px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 2px solid transparent; cursor: pointer; text-decoration: none; display: block; transition: all 0.3s ease; position: relative; overflow: hidden; }
    .laci-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #7c4dff, #b388ff); transform: scaleX(0); transition: transform 0.3s ease; }
    .laci-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(124,77,255,0.15); border-color: #b388ff; text-decoration: none; }
    .laci-card:hover::before { transform: scaleX(1); }
    .laci-icon { font-size: 48px; margin-bottom: 14px; display: block; }
    .laci-kode { font-size: 12px; color: #999; font-weight: 600; text-transform: uppercase; margin-bottom: 6px; }
    .laci-nama { font-size: 17px; font-weight: 700; color: #333; margin-bottom: 6px; }
    .laci-lokasi { font-size: 13px; color: #888; margin-bottom: 14px; }
    .laci-stats { display: flex; gap: 10px; }
    .stat-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .stat-total { background: #ede7f6; color: #5e35b1; }
    .stat-tersedia { background: #e8f5e9; color: #2e7d32; }
    .laci-arrow { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); font-size: 20px; color: #ccc; transition: all 0.3s; }
    .laci-card:hover .laci-arrow { color: #7c4dff; transform: translateY(-50%) translateX(4px); }
    .empty-state { text-align: center; padding: 70px 20px; background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
    .empty-icon { font-size: 72px; margin-bottom: 16px; opacity: 0.4; }
    .empty-state h3 { font-size: 22px; color: #333; margin-bottom: 8px; }
    .empty-state p { color: #666; }
</style>
@endpush

@section('content')
<div class="container">
    <div class="breadcrumb">
        <a href="{{ route('user.katalog') }}">🏫 Katalog</a>
        <span>›</span>
        <span style="color:#333; font-weight:600;">{{ $lab->nama_lab }}</span>
    </div>

    <div class="steps">
        <div class="step done">
            <div class="step-circle">✓</div>
            <span class="step-label">Pilih Lab</span>
        </div>
        <div class="step-line done"></div>
        <div class="step active">
            <div class="step-circle">2</div>
            <span class="step-label">Pilih Laci</span>
        </div>
        <div class="step-line"></div>
        <div class="step inactive">
            <div class="step-circle">3</div>
            <span class="step-label">Lihat Alat</span>
        </div>
        <div class="step-line"></div>
        <div class="step inactive">
            <div class="step-circle">4</div>
            <span class="step-label">Detail & Pinjam</span>
        </div>
    </div>

    <div class="lab-banner">
        <h2>🏫 {{ $lab->nama_lab }}</h2>
        <p>{{ $lab->kode_lab }} @if($lab->lokasi) • 📍 {{ $lab->lokasi }} @endif</p>
    </div>

    @if($lacis->count() > 0)
        <div class="laci-grid">
            @foreach($lacis as $laci)
            <a href="{{ route('user.katalog.laci', [$lab->id, $laci->id]) }}" class="laci-card">
                <span class="laci-icon">🗄️</span>
                <div class="laci-kode">{{ $laci->kode_laci }}</div>
                <div class="laci-nama">{{ $laci->nama_laci }}</div>
                @if($laci->lokasi)
                <div class="laci-lokasi">📍 {{ $laci->lokasi }}</div>
                @endif
                <div class="laci-stats">
                    <span class="stat-badge stat-total">{{ $laci->alat_count }} alat</span>
                    <span class="stat-badge stat-tersedia">{{ $laci->jumlahAlatTersedia() }} tersedia</span>
                </div>
                <span class="laci-arrow">→</span>
            </a>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🗄️</div>
            <h3>Belum Ada Laci</h3>
            <p>Lab ini belum memiliki laci penyimpanan</p>
        </div>
    @endif
</div>
@endsection