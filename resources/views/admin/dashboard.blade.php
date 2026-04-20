@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .page-header { margin-bottom: 28px; }

    .page-header h1 {
        font-size: 28px;
        color: #333;
        margin-bottom: 6px;
        font-weight: 700;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: white;
        padding: 22px;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        transition: transform 0.25s, box-shadow 0.25s;
    }

    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.11); }

    .stat-card.purple { border-left: 5px solid #667eea; }
    .stat-card.orange { border-left: 5px solid #f6ad55; }
    .stat-card.green  { border-left: 5px solid #48bb78; }
    .stat-card.blue   { border-left: 5px solid #4299e1; }

    .stat-label { color: #666; font-size: 13px; margin-bottom: 8px; font-weight: 500; }

    .stat-value { font-size: 32px; font-weight: 700; color: #333; line-height: 1; }

    /* Two Column */
    .two-column {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    /* Section Cards */
    .section-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        padding: 22px;
        margin-bottom: 20px;
    }

    .section-card.urgent { border-top: 4px solid #f6ad55; }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        gap: 10px;
        flex-wrap: wrap;
    }

    .section-header h2 { font-size: 18px; color: #333; font-weight: 700; margin: 0; }

    .badge-count {
        background: #f6ad55;
        color: white;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Approval / Active Items */
    .approval-item, .active-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px;
        border-radius: 10px;
        background: #f8f9fa;
        margin-bottom: 10px;
        gap: 12px;
        transition: background 0.2s;
    }

    .approval-item:hover, .active-item:hover { background: #f0f4ff; }
    .approval-item:last-child, .active-item:last-child { margin-bottom: 0; }

    .approval-info h4, .active-info h4 {
        font-size: 15px;
        color: #333;
        margin-bottom: 3px;
        font-weight: 600;
    }

    .peminjam { font-size: 13px; color: #666; margin-bottom: 3px; }
    .detail   { font-size: 12px; color: #999; margin: 0; }

    .btn-detail-small {
        padding: 6px 14px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        flex-shrink: 0;
        transition: all 0.2s;
    }

    .btn-detail-small:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(102,126,234,0.4); color: white; }

    /* Badges inside lists */
    .meta { display: flex; align-items: center; gap: 8px; margin-top: 5px; flex-wrap: wrap; }

    .badge {
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-warning  { background: #fff3cd; color: #856404; }
    .badge-success  { background: #d4edda; color: #155724; }
    .badge-info     { background: #d1ecf1; color: #0c5460; }
    .badge-danger   { background: #f8d7da; color: #721c24; }
    .badge-primary  { background: #cce5ff; color: #004085; }

    .date { font-size: 12px; color: #999; }

    .btn-arrow {
        font-size: 18px;
        color: #667eea;
        text-decoration: none;
        flex-shrink: 0;
        padding: 4px 8px;
        border-radius: 6px;
        transition: background 0.2s;
    }

    .btn-arrow:hover { background: #eef2ff; }

    .empty-text { text-align: center; color: #bbb; padding: 24px; font-style: italic; font-size: 14px; }

    /* Full-width section at bottom */
    .full-section { grid-column: 1 / -1; }

    /* Table */
    .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    .dashboard-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .dashboard-table thead { background: #f8f9fa; }
    .dashboard-table th {
        padding: 12px 14px;
        text-align: left;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #333;
        white-space: nowrap;
    }
    .dashboard-table td {
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }
    .dashboard-table tbody tr:hover { background: #f8f9fa; }

    .btn-table {
        padding: 6px 14px;
        background: #667eea;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        display: inline-block;
        transition: all 0.2s;
    }

    .btn-table:hover { background: #5568d3; color: white; transform: translateY(-1px); }

    .link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: color 0.2s;
    }

    .link:hover { color: #5568d3; }

    /* =========== RESPONSIVE =========== */
    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 960px) {
        .two-column { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .dashboard-container { padding: 16px 12px; }

        .page-header h1 { font-size: 22px; }

        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }

        .stat-value { font-size: 26px; }

        .section-card { padding: 16px; }

        .approval-item, .active-item { flex-direction: column; align-items: flex-start; }

        .btn-detail-small { align-self: flex-end; }

        .btn-arrow { align-self: flex-end; }

        .dashboard-table { font-size: 12px; }
        .dashboard-table th, .dashboard-table td { padding: 9px 8px; }
    }

    @media (max-width: 400px) {
        .stats-grid { grid-template-columns: 1fr; }
        .stat-card { padding: 16px; }
        .stat-value { font-size: 28px; }
    }
</style>
@endpush

@push('scripts')
<script>
    setInterval(async function() {
        try {
            const response = await fetch('{{ route("admin.dashboard.data") }}');
            const data = await response.json();
            document.getElementById('totalPeminjaman').textContent = data.totalPeminjaman;
            document.getElementById('sedangDipinjam').textContent  = data.sedangDipinjam;
            document.getElementById('sudahDikembalikan').textContent = data.sudahDikembalikan;
            document.getElementById('alatTersedia').textContent    = data.alatTersedia;
        } catch (e) {}
    }, 30000);
</script>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="page-header">
        <h1> Dashboard Admin</h1>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card purple">
            <div class="stat-label">Total Peminjaman</div>
            <div class="stat-value" id="totalPeminjaman">{{ $totalPeminjaman }}</div>
        </div>
        <div class="stat-card orange">
            <div class="stat-label">Sedang Dipinjam</div>
            <div class="stat-value" id="sedangDipinjam">{{ $sedangDipinjam }}</div>
        </div>
        <div class="stat-card green">
            <div class="stat-label">Sudah Dikembalikan</div>
            <div class="stat-value" id="sudahDikembalikan">{{ $sudahDikembalikan }}</div>
        </div>
        <div class="stat-card blue">
            <div class="stat-label">Alat Tersedia</div>
            <div class="stat-value" id="alatTersedia">{{ $alatTersedia }}</div>
        </div>
    </div>

    <!-- Two Column -->
    <div class="two-column">
        <div class="left-column">
            @if($pendingApproval->count() > 0)
            <div class="section-card urgent">
                <div class="section-header">
                    <h2>🔔 Perlu Persetujuan</h2>
                    <span class="badge-count">{{ $pendingApproval->count() }}</span>
                </div>
                <div class="approval-list">
                    @foreach($pendingApproval as $p)
                    <div class="approval-item">
                        <div class="approval-info">
                            <h4>{{ $p->alat->nama_alat }}</h4>
                            <p class="peminjam">👤 {{ $p->user->name }}{{ $p->user->nim ? ' ('.$p->user->nim.')' : '' }}</p>
                            <p class="detail">📦 {{ $p->jumlah_pinjam }} unit | 📅 {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</p>
                        </div>
                        <a href="{{ route('admin.peminjaman.show', $p->id) }}" class="btn-detail-small">Detail</a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="section-card">
                <div class="section-header">
                    <h2>📍 Peminjaman Aktif</h2>
                </div>
                @if($peminjamanAktif->count() > 0)
                <div class="peminjaman-active-list">
                    @foreach($peminjamanAktif as $p)
                    <div class="active-item">
                        <div class="active-info">
                            <h4>{{ $p->alat->nama_alat }}</h4>
                            <p class="peminjam">{{ $p->user->name }}</p>
                            <div class="meta">
                                @if($p->status == 'pending')
                                    <span class="badge badge-warning">Menunggu Persetujuan</span>
                                @elseif($p->status == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($p->status == 'dipinjam')
                                    <span class="badge badge-info">Sedang Dipinjam</span>
                                @elseif($p->status == 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-primary">{{ ucfirst($p->status) }}</span>
                                @endif
                                <span class="date">{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.peminjaman.show', $p->id) }}" class="btn-arrow">→</a>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="empty-text">Tidak ada peminjaman aktif</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Peminjaman Terakhir -->
    <div class="section-card">
        <div class="section-header">
            <h2>🕐 Peminjaman Terakhir</h2>
            <a href="{{ route('admin.peminjaman.index') }}" class="link">Lihat Semua →</a>
        </div>
        <div class="table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Peminjam</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamanTerakhir as $p)
                    <tr>
                        <td>#{{ $p->id }}</td>
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->alat->nama_alat }}</td>
                        <td>{{ $p->jumlah_pinjam }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d/m/Y') }}</td>
                        <td>
                            @if($p->status == 'pending')     <span class="badge badge-warning">Pending</span>
                            @elseif($p->status == 'disetujui') <span class="badge badge-success">Disetujui</span>
                            @elseif($p->status == 'dipinjam')  <span class="badge badge-info">Dipinjam</span>
                            @elseif($p->status == 'ditolak')   <span class="badge badge-danger">Ditolak</span>
                            @elseif($p->status == 'dikembalikan') <span class="badge badge-primary">Dikembalikan</span>
                            @else <span class="badge badge-primary">{{ ucfirst($p->status) }}</span>
                            @endif
                        </td>
                        <td><a href="{{ route('admin.peminjaman.show', $p->id) }}" class="btn-table">Detail</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="empty-text">Tidak ada data peminjaman</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection