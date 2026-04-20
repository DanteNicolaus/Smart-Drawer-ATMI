@extends('layouts.user')
@section('title', 'Pilih Lab')
@push('styles')
<style>
    .container { max-width: 1100px; margin: 0 auto; padding: 30px 20px; }
    .page-header { margin-bottom: 28px; text-align: center; }
    .page-header h1 { font-size: 28px; color: #333; font-weight: 700; margin-bottom: 8px; }
    .page-header p  { color: #666; font-size: 15px; }
    .steps { display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 32px; }
    .step { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; }
    .step-circle { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; }
    .step.active .step-circle  { background: linear-gradient(135deg, #7c4dff, #b388ff); color: white; }
    .step.active .step-label   { color: #7c4dff; }
    .step.inactive .step-circle { background: #e0e0e0; color: #aaa; }
    .step.inactive .step-label  { color: #aaa; }
    .step-line { width: 50px; height: 2px; background: #e0e0e0; border-radius: 2px; }
    .lab-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
    .lab-card { background: white; border-radius: 20px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 2px solid transparent; cursor: pointer; text-decoration: none; display: block; transition: all 0.3s ease; position: relative; overflow: hidden; }
    .lab-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(135deg, #7c4dff, #b388ff); transform: scaleX(0); transition: transform 0.3s ease; }
    .lab-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(124,77,255,0.15); border-color: #b388ff; text-decoration: none; }
    .lab-card:hover::before { transform: scaleX(1); }
    .lab-icon { font-size: 48px; margin-bottom: 14px; display: block; }
    .lab-kode { font-size: 12px; color: #999; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .lab-nama { font-size: 17px; font-weight: 700; color: #333; margin-bottom: 6px; }
    .lab-lokasi { font-size: 13px; color: #888; margin-bottom: 14px; }
    .lab-stats { display: flex; gap: 10px; flex-wrap: wrap; }
    .stat-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .stat-laci { background: #ede7f6; color: #5e35b1; }
    .stat-tersedia { background: #e8f5e9; color: #2e7d32; }
    .lab-arrow { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); font-size: 20px; color: #ccc; transition: all 0.3s; }
    .lab-card:hover .lab-arrow { color: #7c4dff; transform: translateY(-50%) translateX(4px); }
    .empty-state { text-align: center; padding: 70px 20px; background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
    .empty-icon { font-size: 72px; margin-bottom: 16px; opacity: 0.4; }
    .empty-state h3 { font-size: 22px; color: #333; margin-bottom: 8px; }
    .empty-state p { color: #666; }
</style>
@endpush

@section('content')
<div class="container">
    <div class="page-header">
        <h1>🏫 Katalog Alat</h1>
        <p>Pilih laboratorium terlebih dahulu untuk melihat alat yang tersedia</p>
    </div>

    <div class="steps">
        <div class="step active">
            <div class="step-circle">1</div>
            <span class="step-label">Pilih Lab</span>
        </div>
        <div class="step-line"></div>
        <div class="step inactive">
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

    @if($labs->count() > 0)
        <div class="lab-grid">
            @foreach($labs as $lab)
            <a href="{{ route('user.katalog.lab', $lab->id) }}" class="lab-card">
                <span class="lab-icon">🏫</span>
                <div class="lab-kode">{{ $lab->kode_lab }}</div>
                <div class="lab-nama">{{ $lab->nama_lab }}</div>
                @if($lab->lokasi)
                <div class="lab-lokasi">📍 {{ $lab->lokasi }}</div>
                @endif
                <div class="lab-stats">
                    <span class="stat-badge stat-laci">{{ $lab->lacis->count() }} laci</span>
                    <span class="stat-badge stat-tersedia">{{ $lab->jumlahAlatTersedia() }} alat tersedia</span>
                </div>
                <span class="lab-arrow">→</span>
            </a>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🏫</div>
            <h3>Belum Ada Lab</h3>
            <p>Admin belum menambahkan laboratorium</p>
        </div>
    @endif
</div>
@endsection