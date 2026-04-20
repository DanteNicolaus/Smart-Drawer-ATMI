@extends('layouts.admin')

@section('title', 'Daftar Peminjaman')

@push('styles')
<style>
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-header h1 { font-size: 26px; color: #333; margin-bottom: 4px; font-weight: 700; }
    .page-header p  { color: #666; font-size: 14px; margin: 0; }

    /* Header Actions */
    .header-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    /* Export Buttons */
    .export-group {
        display: flex;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .btn-export {
        padding: 10px 18px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: none;
        white-space: nowrap;
    }

    .btn-export.pdf   { background: linear-gradient(135deg, #ef5350, #e53935); }
    .btn-export.excel { background: linear-gradient(135deg, #66bb6a, #43a047); }
    .btn-export.pdf:hover   { background: linear-gradient(135deg, #c62828, #b71c1c); color: white; }
    .btn-export.excel:hover { background: linear-gradient(135deg, #2e7d32, #1b5e20); color: white; }

    .btn-input {
        padding: 10px 20px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.25s;
        box-shadow: 0 3px 12px rgba(102,126,234,0.35);
    }

    .btn-input:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,0.45); color: white; }

    /* Filter Card */
    .filter-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        padding: 18px 20px;
        margin-bottom: 20px;
    }

    .filter-form { display: flex; gap: 10px; flex-wrap: wrap; }

    .form-select {
        padding: 10px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        background: #fafafa;
        color: #333;
        transition: border-color 0.2s;
        min-width: 180px;
    }

    .form-select:focus { outline: none; border-color: #667eea; background: white; }

    .btn-filter {
        padding: 10px 20px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        font-family: inherit;
        font-size: 14px;
        white-space: nowrap;
        transition: background 0.2s;
    }

    .btn-filter:hover { background: #5568d3; }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        overflow: hidden;
    }

    .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    table { width: 100%; border-collapse: collapse; min-width: 700px; }

    thead { background: #f8f9fa; }

    th, td {
        padding: 13px 14px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
        font-size: 14px;
    }

    th { font-weight: 600; color: #333; white-space: nowrap; font-size: 12px; text-transform: uppercase; letter-spacing: 0.4px; }

    tbody tr:hover { background: #f8f9fa; }

    .kode-badge {
        display: inline-block;
        padding: 3px 10px;
        background: #e7e7ff;
        color: #5e35b1;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-warning    { background: #fff3cd; color: #856404; }
    .badge-info       { background: #d1ecf1; color: #0c5460; }
    .badge-danger     { background: #f8d7da; color: #721c24; }
    .badge-primary    { background: #cce5ff; color: #004085; }
    .badge-success    { background: #d4edda; color: #155724; }
    .badge-secondary  { background: #e2e3e5; color: #383d41; }

    .btn-detail-link {
        padding: 6px 14px;
        background: #667eea;
        color: white;
        text-decoration: none;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        display: inline-block;
        transition: all 0.2s;
    }

    .btn-detail-link:hover { background: #5568d3; color: white; transform: translateY(-1px); }

    /* Empty State */
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state h5 { font-size: 18px; color: #333; margin-bottom: 8px; }
    .empty-state p  { color: #666; margin-bottom: 20px; }

    /* Pagination */
    .pagination-wrapper { padding: 16px 20px; display: flex; justify-content: center; }

    /* =========== RESPONSIVE =========== */
    @media (max-width: 900px) {
        .page-header { flex-direction: column; }
        .header-actions { width: 100%; }
        .export-group { flex: 1; }
        .btn-export { flex: 1; justify-content: center; }
        .btn-input { width: 100%; justify-content: center; }
    }

    @media (max-width: 640px) {
        .container { padding: 16px 12px; }
        .page-header h1 { font-size: 22px; }
        .filter-form { flex-direction: column; }
        .form-select { min-width: unset; }
        .btn-filter { width: 100%; }
    }

    @media (max-width: 480px) {
        .container { padding: 14px 10px; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="page-header">
        <div>
            <h1>📋 Daftar Peminjaman</h1>
            <p>Kelola semua peminjaman alat laboratorium</p>
        </div>
        <div class="header-actions">
            <div class="export-group">
                <a href="{{ route('admin.peminjaman.export-pdf') }}{{ request()->has('status') ? '?status='.request('status') : '' }}"
                   class="btn-export pdf" target="_blank">
                    📄 PDF
                </a>
                <a href="{{ route('admin.peminjaman.export-excel') }}{{ request()->has('status') ? '?status='.request('status') : '' }}"
                   class="btn-export excel">
                    📊 Excel
                </a>
            </div>
            <a href="{{ route('admin.peminjaman.create') }}" class="btn-input">
                ➕ Input Peminjaman
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.peminjaman.index') }}" class="filter-form">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="dipinjam"     {{ request('status') == 'dipinjam'      ? 'selected' : '' }}>Sedang Dipinjam</option>
                <option value="dikembalikan" {{ request('status') == 'dikembalikan'  ? 'selected' : '' }}>Dikembalikan</option>
            </select>
            <button type="submit" class="btn-filter">Filter</button>
        </form>
    </div>

    <!-- Table -->
    <div class="table-card">
        @if($peminjaman->count() > 0)
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Peminjam</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $p)
                    <tr>
                        <td><span class="kode-badge">{{ $p->kode_peminjaman }}</span></td>
                        <td>
                            <strong>{{ $p->user->name }}</strong><br>
                            <small style="color:#94a3b8;">{{ $p->user->nim }}</small>
                        </td>
                        <td>
                            <strong>{{ $p->alat->nama_alat }}</strong><br>
                            <small style="color:#94a3b8;">{{ $p->alat->kode_alat }}</small>
                        </td>
                        <td>{{ $p->jumlah_pinjam }} unit</td>
                        <td>{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                        <td>{{ $p->tanggal_kembali_rencana->format('d M Y') }}</td>
                        <td>
                            @if($p->status == 'pending')          <span class="badge badge-warning">Pending</span>
                            @elseif($p->status == 'disetujui')    <span class="badge badge-info">Disetujui</span>
                            @elseif($p->status == 'ditolak')      <span class="badge badge-danger">Ditolak</span>
                            @elseif($p->status == 'dipinjam')     <span class="badge badge-primary">Dipinjam</span>
                            @elseif($p->status == 'dikembalikan') <span class="badge badge-success">Dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.peminjaman.show', $p->id) }}" class="btn-detail-link">👁 Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">{{ $peminjaman->links() }}</div>
        @else
        <div class="empty-state">
            <div style="font-size:56px;margin-bottom:16px;opacity:.35;">📋</div>
            <h5>Tidak Ada Data Peminjaman</h5>
            <p>Belum ada peminjaman yang tercatat dalam sistem</p>
            <a href="{{ route('admin.peminjaman.create') }}" class="btn-input" style="display:inline-flex;">
                ➕ Input Peminjaman Pertama
            </a>
        </div>
        @endif
    </div>
</div>
@endsection