@extends('layouts.admin')
@section('title', 'Kelola Laci')

@push('styles')
<style>
    .container { max-width: 1100px; margin: 0 auto; padding: 30px 20px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
    .page-header h4 { font-size: 22px; font-weight: 700; color: #1e293b; margin: 0; }
    .page-header p  { color: #64748b; font-size: 14px; margin: 4px 0 0; }
    .btn-tambah { padding: 11px 22px; background: linear-gradient(135deg, #7c4dff, #b388ff); color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 12px rgba(124,77,255,0.3); white-space: nowrap; }
    .btn-tambah:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(124,77,255,0.4); color: white; }
    .alert-success { padding: 12px 16px; background: #dcfce7; color: #166534; border-left: 4px solid #22c55e; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
    .alert-error   { padding: 12px 16px; background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }

    .lab-info-bar { background: linear-gradient(135deg, #ede7f6, #f3e8ff); border: 1px solid #d8b4fe; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px; font-size: 14px; color: #5e35b1; display: flex; align-items: center; gap: 8px; }

    .table-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); overflow: hidden; border: 1px solid rgba(0,0,0,0.05); }
    table { width: 100%; border-collapse: collapse; }
    thead { background: linear-gradient(135deg, #f8f9ff, #f0f0ff); }
    thead th { padding: 14px 16px; text-align: left; font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; }
    tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    tbody td { padding: 14px 16px; font-size: 14px; color: #334155; vertical-align: middle; }
    .badge-aktif    { padding: 4px 12px; background: #dcfce7; color: #16a34a; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-nonaktif { padding: 4px 12px; background: #fee2e2; color: #dc2626; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .action-btns { display: flex; gap: 8px; }
    .btn-edit  { padding: 7px 14px; background: #fef3c7; color: #d97706; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
    .btn-edit:hover  { background: #fde68a; color: #b45309; }
    .btn-hapus { padding: 7px 14px; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit; transition: all 0.2s; }
    .btn-hapus:hover { background: #fecaca; color: #b91c1c; }
    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
    .empty-state .empty-icon { font-size: 56px; margin-bottom: 12px; opacity: 0.4; }
    .empty-state p { font-size: 15px; }
    .kode-laci { font-weight: 700; color: #7c4dff; font-family: monospace; font-size: 13px; }
    .alat-count { background: #ede7f6; color: #5e35b1; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; }
    @media (max-width: 768px) { .table-card { overflow-x: auto; } table { min-width: 600px; } }
</style>
@endpush

@section('content')
<div class="container">
    <div class="page-header">
        <div>
            <h4>🗄️ Kelola Laci</h4>
            <p>Manajemen laci penyimpanan alat laboratorium</p>
        </div>
        <a href="{{ route('admin.laci.create') }}" class="btn-tambah">+ Tambah Laci</a>
    </div>

    {{-- Info lab yang sedang dikelola admin --}}
    @if(auth()->user()->lab)
        <div class="lab-info-bar">
            🏫 <strong>Lab Anda:</strong> {{ auth()->user()->lab->kode_lab }} — {{ auth()->user()->lab->nama_lab }}
            &nbsp;|&nbsp; Laci di bawah ini hanya dari lab ini.
        </div>
    @endif

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">❌ {{ session('error') }}</div>
    @endif

    <div class="table-card">
        @if($lacis->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Laci</th>
                    <th>Nama Laci</th>
                    <th>Lokasi</th>
                    <th>Jumlah Alat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lacis as $i => $laci)
                <tr>
                    <td>{{ $lacis->firstItem() + $i }}</td>
                    <td><span class="kode-laci">{{ $laci->kode_laci }}</span></td>
                    <td><strong>{{ $laci->nama_laci }}</strong></td>
                    <td>{{ $laci->lokasi ?? '-' }}</td>
                    <td><span class="alat-count">{{ $laci->alat_count ?? $laci->alat()->count() }} alat</span></td>
                    <td>
                        @if($laci->status === 'aktif')
                            <span class="badge-aktif">Aktif</span>
                        @else
                            <span class="badge-nonaktif">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.laci.edit', $laci) }}" class="btn-edit">✏️ Edit</a>
                            <form action="{{ route('admin.laci.destroy', $laci) }}" method="POST"
                                  onsubmit="return confirm('Hapus laci {{ $laci->nama_laci }}? Alat di laci ini tidak akan terhapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-hapus">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding: 16px; display: flex; justify-content: center;">
            {{ $lacis->links() }}
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon">🗄️</div>
            <p>Belum ada laci di lab Anda. Klik <strong>Tambah Laci</strong> untuk mulai.</p>
        </div>
        @endif
    </div>
</div>
@endsection