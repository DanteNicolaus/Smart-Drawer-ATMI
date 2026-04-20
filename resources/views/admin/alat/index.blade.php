@extends('layouts.admin')

@section('title', 'Daftar Alat')

@push('styles')
<style>
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        gap: 14px;
        flex-wrap: wrap;
    }

    .page-header h1 { font-size: 26px; color: #333; margin-bottom: 4px; font-weight: 700; }
    .page-header p  { color: #666; font-size: 14px; margin: 0; }

    .header-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .btn-add {
        padding: 11px 22px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        white-space: nowrap;
        transition: all 0.25s;
        flex-shrink: 0;
    }
    .btn-add:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,0.4); color: white; }

    .btn-laci {
        padding: 11px 22px;
        background: linear-gradient(135deg, #7c4dff, #b388ff);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        white-space: nowrap;
        transition: all 0.25s;
        flex-shrink: 0;
    }
    .btn-laci:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(124,77,255,0.4); color: white; }

    .filter-section {
        background: white;
        padding: 18px 20px;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        margin-bottom: 20px;
    }

    .filter-form { display: flex; gap: 10px; flex-wrap: wrap; }

    .filter-form input {
        flex: 1;
        min-width: 180px;
        padding: 11px 14px;
        border: 2px solid #e8eaf6;
        border-radius: 10px;
        font-size: 14px;
        transition: border-color 0.2s;
        font-family: inherit;
        background: #fafafa;
    }
    .filter-form input:focus { outline: none; border-color: #667eea; background: white; }

    .btn-search {
        padding: 11px 22px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        font-family: inherit;
        font-size: 14px;
        white-space: nowrap;
        transition: all 0.2s;
    }
    .btn-search:hover { background: #5568d3; }

    .table-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        overflow: hidden;
    }

    .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    table { width: 100%; border-collapse: collapse; min-width: 800px; }
    thead { background: #f8f9fa; }
    th, td { padding: 13px 14px; text-align: left; border-bottom: 1px solid #e9ecef; font-size: 14px; }
    th { font-weight: 600; color: #333; white-space: nowrap; }
    tbody tr:hover { background: #f8f9fa; }

    .foto-cell {
        width: 52px; height: 52px;
        border-radius: 8px;
        overflow: hidden;
        background: #f5f5f5;
        flex-shrink: 0;
    }
    .foto-cell img { width: 100%; height: 100%; object-fit: cover; }
    .no-foto { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 22px; }

    .badge-category {
        display: inline-block;
        padding: 4px 10px;
        background: #e7e7ff;
        color: #667eea;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-laci {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        background: #ede7f6;
        color: #5e35b1;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-no-laci {
        display: inline-block;
        padding: 4px 10px;
        background: #f1f5f9;
        color: #94a3b8;
        border-radius: 6px;
        font-size: 12px;
        font-style: italic;
    }

    .stok-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
    }
    .stok-badge.success { background: #d4edda; color: #155724; }
    .stok-badge.warning { background: #fff3cd; color: #856404; }

    .status-toggle {
        padding: 5px 12px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
    }
    .status-toggle.tersedia       { background: #d4edda; color: #155724; }
    .status-toggle.tidak_tersedia { background: #f8d7da; color: #721c24; }

    .action-buttons { display: flex; gap: 6px; align-items: center; }

    .btn-edit, .btn-delete {
        padding: 7px 11px;
        border: none;
        border-radius: 7px;
        cursor: pointer;
        font-size: 15px;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-edit  { background: #fff3cd; }
    .btn-edit:hover  { background: #ffc107; }
    .btn-delete { background: #f8d7da; }
    .btn-delete:hover { background: #dc3545; color: white; }

    .empty-state { text-align: center; padding: 50px 20px; }
    .empty-state h3 { color: #333; margin-bottom: 8px; font-size: 20px; }
    .empty-state p  { color: #666; margin-bottom: 20px; }

    .pagination-wrapper { margin-top: 20px; display: flex; justify-content: center; padding: 0 4px 4px; }

    @media (max-width: 768px) {
        .container { padding: 20px 14px; }
        .page-header h1 { font-size: 22px; }
        .filter-form { flex-direction: column; }
        .filter-form input { min-width: unset; }
        .btn-search { width: 100%; }
    }

    @media (max-width: 480px) {
        .container { padding: 16px 12px; }
        .page-header { flex-direction: column; align-items: flex-start; }
        .header-actions { width: 100%; }
        .btn-add, .btn-laci { width: 100%; text-align: center; }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="page-header">
        <div>
            <h1>📦 Daftar Alat</h1>
            <p>Kelola semua alat laboratorium</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.lab.index') }}" class="btn-tambah" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8);">🏫 Kelola Lab</a>
            <a href="{{ route('admin.laci.index') }}" class="btn-laci">🗄️ Kelola Laci</a>
            <a href="{{ route('admin.alat.create') }}" class="btn-add">+ Tambah Alat</a>
        </div>
    </div>

    <div class="filter-section">
        <form method="GET" class="filter-form">
            <input type="text" name="search" placeholder="🔎 Cari alat..." value="{{ request('search') }}">
            <button type="submit" class="btn-search">Cari</button>
        </form>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Kode</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Laci</th>
                        <th>Stok</th>
                        <th>Tersedia</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alat as $item)
                    <tr>
                        <td>
                            <div class="foto-cell">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_alat }}">
                                @else
                                    <div class="no-foto">📦</div>
                                @endif
                            </div>
                        </td>
                        <td>{{ $item->kode_alat }}</td>
                        <td><strong>{{ $item->nama_alat }}</strong></td>
                        <td><span class="badge-category">{{ $item->kategori }}</span></td>
                        <td>
                            @if($item->laci)
                                <span class="badge-laci">🗄️ {{ $item->laci->kode_laci }}</span>
                            @else
                                <span class="badge-no-laci">Belum dipilih</span>
                            @endif
                        </td>
                        <td>{{ $item->jumlah_total }}</td>
                        <td>
                            <span class="stok-badge {{ $item->jumlah_tersedia <= 3 ? 'warning' : 'success' }}">
                                {{ $item->jumlah_tersedia }}
                            </span>
                        </td>
                        <td>{{ ucfirst($item->kondisi) }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.alat.toggle-status', $item->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="status-toggle {{ $item->status }}">
                                    {{ $item->status === 'tersedia' ? '✔' : '✗' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.alat.edit', $item->id) }}" class="btn-edit" title="Edit">✏️</a>
                                <form method="POST" action="{{ route('admin.alat.destroy', $item->id) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus alat ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Hapus">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div style="font-size:48px;margin-bottom:14px;opacity:.4;">📦</div>
                                <h3>Belum ada alat</h3>
                                <p>Mulai tambahkan alat laboratorium pertama Anda</p>
                                <a href="{{ route('admin.alat.create') }}" class="btn-add">+ Tambah Alat</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($alat->hasPages())
    <div class="pagination-wrapper">{{ $alat->links() }}</div>
    @endif
</div>
@endsection