@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@push('styles')
<style>
    .container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 22px;
        gap: 14px;
        flex-wrap: wrap;
    }

    .page-header h2 { font-size: 24px; color: #333; margin-bottom: 5px; font-weight: 700; }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        list-style: none;
        padding: 0; margin: 0;
        flex-wrap: wrap;
    }

    .breadcrumb a { color: #667eea; text-decoration: none; }
    .breadcrumb a:hover { color: #5568d3; }
    .breadcrumb .sep { color: #bbb; }
    .breadcrumb .active { color: #64748b; }

    .btn-back {
        padding: 9px 18px;
        background: #f1f5f9;
        color: #334155;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-back:hover { background: #e2e8f0; }

    /* Layout */
    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 22px;
        align-items: start;
    }

    /* Cards */
    .detail-card {
        background: white;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 18px;
    }

    .detail-card:last-child { margin-bottom: 0; }

    .card-body { padding: 24px; }

    /* Status Section */
    .status-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .status-top h5 { font-size: 16px; color: #333; margin-bottom: 3px; font-weight: 600; }

    .status-top p { font-size: 13px; color: #94a3b8; margin: 0; }

    .badge-status {
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .badge-warning    { background: #fff3cd; color: #856404; }
    .badge-success    { background: #d4edda; color: #155724; }
    .badge-danger     { background: #f8d7da; color: #721c24; }
    .badge-info       { background: #d1ecf1; color: #0c5460; }
    .badge-secondary  { background: #e2e3e5; color: #383d41; }

    /* Timeline */
    .timeline { position: relative; padding: 10px 0 4px; }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px; top: 0; bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        padding-left: 48px;
        margin-bottom: 24px;
    }

    .timeline-item:last-child { margin-bottom: 0; }

    .timeline-marker {
        position: absolute;
        left: 8px; top: 1px;
        width: 16px; height: 16px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #e9ecef;
    }

    .timeline-item.completed .timeline-marker { box-shadow: 0 0 0 2px #667eea; }

    .bg-primary   { background: #667eea !important; }
    .bg-success   { background: #48bb78 !important; }
    .bg-info      { background: #4299e1 !important; }
    .bg-secondary { background: #94a3b8 !important; }
    .bg-light     { background: #e2e8f0 !important; }

    .timeline-item h6 { font-size: 14px; color: #333; margin-bottom: 3px; font-weight: 600; }
    .timeline-item small { font-size: 12px; color: #94a3b8; }

    /* Action Sections */
    .action-section {
        margin-top: 22px;
        padding-top: 22px;
        border-top: 1px solid #f0f4f8;
    }

    .action-section h6 { font-size: 14px; font-weight: 700; color: #333; margin-bottom: 14px; }

    .action-btns { display: flex; gap: 12px; flex-wrap: wrap; }

    .btn-approve, .btn-reject, .btn-process, .btn-return {
        flex: 1;
        min-width: 140px;
        padding: 12px 16px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-decoration: none;
    }

    .btn-approve { background: linear-gradient(135deg, #48bb78, #38a169); color: white; box-shadow: 0 4px 12px rgba(72,187,120,0.3); }
    .btn-reject  { background: linear-gradient(135deg, #fc8181, #f56565); color: white; box-shadow: 0 4px 12px rgba(245,101,101,0.3); }
    .btn-process { background: linear-gradient(135deg, #4299e1, #3182ce); color: white; box-shadow: 0 4px 12px rgba(66,153,225,0.3); width: 100%; }
    .btn-return  { background: linear-gradient(135deg, #667eea, #764ba2); color: white; box-shadow: 0 4px 12px rgba(102,126,234,0.3); width: 100%; }

    .btn-approve:hover, .btn-reject:hover, .btn-process:hover, .btn-return:hover {
        transform: translateY(-2px);
        color: white;
    }

    /* Info List */
    .info-list { display: flex; flex-direction: column; gap: 10px; }

    .info-item-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        background: #f8f9fa;
        border-radius: 9px;
        font-size: 14px;
    }

    .info-item-row i { width: 20px; text-align: center; color: #667eea; flex-shrink: 0; }

    /* Avatar */
    .avatar-circle {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        font-weight: 700;
        flex-shrink: 0;
    }

    /* Stat Items */
    .stat-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px;
        border-radius: 10px;
        background: #f8f9fa;
        margin-bottom: 10px;
    }

    .stat-item:last-child { margin-bottom: 0; }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon.blue   { background: #dbeafe; }
    .stat-icon.orange { background: #fff3e0; }
    .stat-icon.green  { background: #d4edda; }

    .stat-text h6 { font-size: 13px; color: #94a3b8; margin-bottom: 3px; }
    .stat-text p  { font-size: 16px; font-weight: 700; color: #333; margin: 0; }

    /* Rejection Alert */
    .alert-reject {
        padding: 14px 16px;
        background: #fef2f2;
        border-left: 4px solid #ef4444;
        border-radius: 10px;
        margin-top: 18px;
    }

    .alert-reject h6 { color: #b91c1c; font-size: 14px; margin-bottom: 6px; }
    .alert-reject p  { color: #7f1d1d; font-size: 14px; margin: 0; }

    /* Section Headers */
    .section-hdr {
        font-size: 16px;
        font-weight: 700;
        color: #333;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f4f8;
    }

    /* =========== RESPONSIVE =========== */
    @media (max-width: 900px) {
        .detail-layout { grid-template-columns: 1fr; }
        .sidebar { order: -1; display: flex; gap: 16px; flex-wrap: wrap; }
        .sidebar .detail-card { flex: 1; min-width: 250px; margin-bottom: 0; }
    }

    @media (max-width: 640px) {
        .container { padding: 16px 12px; }
        .card-body { padding: 18px 16px; }
        .action-btns { flex-direction: column; }
        .btn-approve, .btn-reject { min-width: unset; width: 100%; }
        .page-header { flex-direction: column; }
        .sidebar { flex-direction: column; }
        .sidebar .detail-card { min-width: unset; }
    }

    @media (max-width: 480px) {
        .page-header h2 { font-size: 20px; }
    }
</style>
@endpush

@push('scripts')
<script>
    setTimeout(function() {
        document.querySelectorAll('.auto-alert').forEach(function(el) {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(function() { el.remove(); }, 500);
        });
    }, 5000);
</script>
@endpush

@section('content')
<div class="container">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h2>📋 Detail Peminjaman</h2>
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="sep">/</li>
                <li><a href="{{ route('admin.peminjaman.index') }}">Peminjaman</a></li>
                <li class="sep">/</li>
                <li class="active">Detail #{{ $peminjaman->id }}</li>
            </ul>
        </div>
        <a href="{{ route('admin.peminjaman.index') }}" class="btn-back">← Kembali</a>
    </div>

    <!-- Session Alerts -->
    @if(session('success'))
    <div class="auto-alert" style="padding:12px 16px;background:#d4edda;color:#155724;border-left:4px solid #28a745;border-radius:10px;margin-bottom:18px;">
        ✅ {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="auto-alert" style="padding:12px 16px;background:#f8d7da;color:#721c24;border-left:4px solid #dc3545;border-radius:10px;margin-bottom:18px;">
        ❌ {{ session('error') }}
    </div>
    @endif

    <div class="detail-layout">
        <!-- Main Content -->
        <div>
            <!-- Status & Timeline Card -->
            <div class="detail-card">
                <div class="card-body">
                    <div class="status-top">
                        <div>
                            <h5>Status Peminjaman</h5>
                            <p>ID: #{{ $peminjaman->id }}</p>
                        </div>
                        @if($peminjaman->status == 'pending')
                            <span class="badge-status badge-info">📦 Sedang Dipinjam</span>
                        @elseif($peminjaman->status == 'dikembalikan')
                            <span class="badge-status badge-secondary">↩ Sudah Dikembalikan</span>
                        @endif
                    </div>

                    <!-- Timeline -->

                        <div class="timeline-item {{ in_array($peminjaman->status, ['dipinjam','dikembalikan']) ? 'completed' : '' }}">
                            <div class="timeline-marker {{ in_array($peminjaman->status, ['dipinjam','dikembalikan']) ? 'bg-info' : 'bg-secondary' }}"></div>
                            <h6>Alat Dipinjam</h6>
                            <small>📅 {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</small>
                        </div>

                        <div class="timeline-item {{ $peminjaman->status == 'dikembalikan' ? 'completed' : '' }}">
                            <div class="timeline-marker {{ $peminjaman->status == 'dikembalikan' ? 'bg-secondary' : 'bg-light' }}"></div>
                            <h6>Alat Dikembalikan</h6>
                            <small>
                                @if($peminjaman->tanggal_kembali_aktual)
                                    📅 {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_aktual)->format('d M Y') }}
                                @else
                                    Target: {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}
                                @endif
                            </small>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if($peminjaman->status == 'pending')
                    <div class="action-section">
                        <h6>Aksi Persetujuan</h6>
                        <div class="action-btns">
                            <button type="button" class="btn-approve" data-bs-toggle="modal" data-bs-target="#approveModal">
                                ✔ Setujui
                            </button>
                            <button type="button" class="btn-reject" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                ✖ Tolak
                            </button>
                        </div>
                    </div>
                    @endif

                    @if($peminjaman->status == 'disetujui')
                    <div class="action-section">
                        <h6>Aksi Peminjaman</h6>
                        <form action="{{ route('admin.peminjaman.process', $peminjaman) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit" class="btn-process"
                                    onclick="return confirm('Konfirmasi bahwa alat sudah diambil?')">
                                📦 Tandai Alat Sudah Diambil
                            </button>
                        </form>
                    </div>
                    @endif

                    @if($peminjaman->status == 'dipinjam')
                    <div class="action-section">
                        <h6>Aksi Pengembalian</h6>
                        <button type="button" class="btn-return" data-bs-toggle="modal" data-bs-target="#returnModal">
                            ↩ Proses Pengembalian Alat
                        </button>
                    </div>
                    @endif

                    @if($peminjaman->status == 'ditolak' && $peminjaman->catatan_admin)
                    <div class="alert-reject">
                        <h6>⚠ Alasan Penolakan</h6>
                        <p>{{ $peminjaman->catatan_admin }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Alat Info -->
            <div class="detail-card">
                <div class="card-body">
                    <h5 class="section-hdr">📦 Informasi Alat</h5>
                    <div class="stat-item">
                        <div class="stat-icon blue">📦</div>
                        <div class="stat-text">
                            <h6>Nama Alat</h6>
                            <p>{{ $peminjaman->alat->nama_alat }}</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon orange">🔢</div>
                        <div class="stat-text">
                            <h6>Jumlah Dipinjam</h6>
                            <p>{{ $peminjaman->jumlah_pinjam }} unit</p>
                        </div>
                    </div>
                    @if($peminjaman->keperluan)
                    <div class="stat-item">
                        <div class="stat-icon green">📝</div>
                        <div class="stat-text">
                            <h6>Keperluan</h6>
                            <p style="font-size:14px;font-weight:500;">{{ $peminjaman->keperluan }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pengembalian Info (if returned) -->
            @if($peminjaman->status == 'dikembalikan')
            <div class="detail-card">
                <div class="card-body">
                    <h5 class="section-hdr">↩ Info Pengembalian</h5>
                    @if($peminjaman->kondisi_saat_kembali)
                    <div class="stat-item">
                        <div class="stat-icon green">🔍</div>
                        <div class="stat-text">
                            <h6>Kondisi Saat Kembali</h6>
                            <p>{{ ucfirst($peminjaman->kondisi_saat_kembali) }}</p>
                        </div>
                    </div>
                    @endif
                    @if($peminjaman->catatan_pengembalian)
                    <div class="stat-item">
                        <div class="stat-icon blue">📌</div>
                        <div class="stat-text">
                            <h6>Catatan Pengembalian</h6>
                            <p style="font-size:14px;font-weight:500;">{{ $peminjaman->catatan_pengembalian }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Peminjam Card -->
            <div class="detail-card">
                <div class="card-body">
                    <h5 class="section-hdr">👤 Data Peminjam</h5>
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
                        <div class="avatar-circle">{{ strtoupper(substr($peminjaman->user->name, 0, 1)) }}</div>
                        <div>
                            <div style="font-size:16px;font-weight:700;color:#333;">{{ $peminjaman->user->name }}</div>
                            <div style="font-size:13px;color:#94a3b8;">{{ $peminjaman->user->nim ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="info-list">
                        @if($peminjaman->user->email)
                        <div class="info-item-row">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $peminjaman->user->email }}</span>
                        </div>
                        @endif
                        @if($peminjaman->user->no_hp ?? false)
                        <div class="info-item-row">
                            <i class="fas fa-phone"></i>
                            <span>{{ $peminjaman->user->no_hp }}</span>
                        </div>
                        @endif
                        @if($peminjaman->user->jurusan ?? false)
                        <div class="info-item-row">
                            <i class="fas fa-graduation-cap"></i>
                            <span>{{ $peminjaman->user->jurusan }}</span>
                        </div>
                        @endif
                        <div class="info-item-row">
                            <i class="fas fa-coins"></i>
                            <span>🪙 {{ $peminjaman->user->koin }} Koin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanggal Card -->
            <div class="detail-card">
                <div class="card-body">
                    <h5 class="section-hdr">📅 Tanggal</h5>
                    <div class="info-list">
                        <div class="info-item-row">
                            <i class="fas fa-calendar-plus"></i>
                            <div>
                                <div style="font-size:11px;color:#94a3b8;">Tanggal Pinjam</div>
                                <div style="font-weight:600;font-size:14px;">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</div>
                            </div>
                        </div>

                        @if($peminjaman->tanggal_kembali_aktual)
                        <div class="info-item-row">
                            <i class="fas fa-calendar-check"></i>
                            <div>
                                <div style="font-size:11px;color:#94a3b8;">Dikembalikan</div>
                                <div style="font-weight:600;font-size:14px;">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_aktual)->format('d M Y') }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-success bg-opacity-10">
                <h5 class="modal-title">✔ Setujui Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.peminjaman.approve', $peminjaman) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui peminjaman <strong>{{ $peminjaman->alat->nama_alat }}</strong> oleh <strong>{{ $peminjaman->user->name }}</strong>?</p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan (Opsional)</label>
                        <textarea class="form-control" name="catatan_admin" rows="3" placeholder="Catatan persetujuan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">✔ Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-danger bg-opacity-10">
                <h5 class="modal-title">✖ Tolak Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.peminjaman.reject', $peminjaman) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="catatan_admin" rows="4" required placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">✖ Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Return Modal -->
<div class="modal fade" id="returnModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary bg-opacity-10">
                <h5 class="modal-title">↩ Proses Pengembalian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.peminjaman.return', $peminjaman) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Kembali Aktual <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_kembali_aktual"
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kondisi Saat Kembali <span class="text-danger">*</span></label>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach(['baik' => '✔ Baik', 'rusak ringan' => '⚠ Rusak Ringan', 'rusak berat' => '🔴 Rusak Berat', 'hilang' => '❓ Hilang'] as $val => $label)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="kondisi_saat_kembali"
                                       id="kondisi_{{ Str::slug($val) }}" value="{{ $val }}"
                                       {{ $val == 'baik' ? 'required checked' : '' }}>
                                <label class="form-check-label" for="kondisi_{{ Str::slug($val) }}">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="alert alert-info py-2 small">
                        ℹ️ <strong>Catatan:</strong> Jika kondisi "Hilang", stok total akan dikurangi.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan Pengembalian (Opsional)</label>
                        <textarea class="form-control" name="catatan_pengembalian" rows="3" placeholder="Catatan kondisi atau kerusakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">💾 Simpan Pengembalian</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection