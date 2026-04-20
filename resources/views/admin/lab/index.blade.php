@extends('layouts.admin')
@section('title', 'Kelola Lab')

@push('styles')
<style>
    .container { max-width: 1100px; margin: 0 auto; padding: 30px 20px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
    .page-header h4 { font-size: 22px; font-weight: 700; color: #1e293b; margin: 0; }
    .page-header p  { color: #64748b; font-size: 14px; margin: 4px 0 0; }
    .alert-success { padding: 12px 16px; background: #dcfce7; color: #166534; border-left: 4px solid #22c55e; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
    .alert-error   { padding: 12px 16px; background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
    .alert-warning { padding: 12px 16px; background: #fef9c3; color: #854d0e; border-left: 4px solid #eab308; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }

    .lab-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
    .lab-card-header { background: linear-gradient(135deg, #7c4dff, #b388ff); padding: 24px 28px; color: white; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
    .lab-card-header h5 { margin: 0; font-size: 20px; font-weight: 700; }
    .lab-card-header p  { margin: 4px 0 0; font-size: 13px; opacity: 0.85; }
    .lab-card-body { padding: 28px; }

    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 24px; }
    .info-item label { font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px; }
    .info-item span  { font-size: 15px; color: #1e293b; font-weight: 500; }

    .badge-aktif    { padding: 4px 12px; background: #dcfce7; color: #16a34a; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-nonaktif { padding: 4px 12px; background: #fee2e2; color: #dc2626; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .kode-lab { font-weight: 700; color: #7c4dff; font-family: monospace; font-size: 15px; }
    .laci-count { background: #ede7f6; color: #5e35b1; padding: 3px 10px; border-radius: 12px; font-size: 13px; font-weight: 600; }

    .btn-edit { padding: 10px 20px; background: #fef3c7; color: #d97706; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: inline-block; }
    .btn-edit:hover { background: #fde68a; color: #b45309; }

    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
    .empty-state .empty-icon { font-size: 56px; margin-bottom: 12px; opacity: 0.4; }
    .empty-state p { font-size: 15px; }
</style>
@endpush

@section('content')
<div class="container">
    <div class="page-header">
        <div>
            <h4>🏫 Lab Saya</h4>
            <p>Informasi laboratorium yang Anda kelola</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">❌ {{ session('error') }}</div>
    @endif
    @if(session('warning'))
        <div class="alert-warning">⚠️ {{ session('warning') }}</div>
    @endif

    @if(!$lab)
        {{-- Admin belum di-assign ke lab --}}
        <div class="lab-card">
            <div class="empty-state">
                <div class="empty-icon">🏫</div>
                <p><strong>Anda belum di-assign ke lab manapun.</strong></p>
                <p style="font-size:13px; margin-top:8px;">Hubungi Super Admin untuk mendapatkan akses lab.</p>
            </div>
        </div>
    @else
        {{-- Tampilkan info lab milik admin ini --}}
        <div class="lab-card">
            <div class="lab-card-header">
                <div>
                    <h5>🏫 {{ $lab->nama_lab }}</h5>
                    <p>{{ $lab->lokasi ?? 'Lokasi belum diisi' }}</p>
                </div>
                <a href="{{ route('admin.lab.edit', $lab) }}" class="btn-edit">✏️ Edit Info Lab</a>
            </div>
            <div class="lab-card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <label>Kode Lab</label>
                        <span class="kode-lab">{{ $lab->kode_lab }}</span>
                    </div>
                    <div class="info-item">
                        <label>Nama Lab</label>
                        <span>{{ $lab->nama_lab }}</span>
                    </div>
                    <div class="info-item">
                        <label>Lokasi</label>
                        <span>{{ $lab->lokasi ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Jumlah Laci</label>
                        <span class="laci-count">{{ $lab->lacis_count ?? $lab->lacis()->count() }} laci</span>
                    </div>
                    <div class="info-item">
                        <label>Status</label>
                        <span>
                            @if($lab->status === 'aktif')
                                <span class="badge-aktif">Aktif</span>
                            @else
                                <span class="badge-nonaktif">Nonaktif</span>
                            @endif
                        </span>
                    </div>
                </div>

                @if($lab->deskripsi)
                <div style="border-top: 1px solid #f1f5f9; padding-top: 20px;">
                    <label style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Deskripsi</label>
                    <p style="font-size: 14px; color: #475569; line-height: 1.6; margin: 0;">{{ $lab->deskripsi }}</p>
                </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection