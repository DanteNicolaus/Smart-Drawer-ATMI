@extends('layouts.super-admin')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-clipboard-list"></i> Kelola Peminjaman
            </h1>
            <p class="text-muted mb-0">Kelola semua peminjaman alat laboratorium</p>
        </div>
        <div>
            <a href="{{ route('super-admin.peminjaman.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle"></i> Input Peminjaman Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('super-admin.peminjaman.index') }}" class="row g-3">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari kode peminjaman, nama user, atau alat..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Peminjaman -->
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                <i class="fas fa-list"></i> Data Peminjaman ({{ $peminjaman->total() }} peminjaman)
            </h6>
            @if($peminjaman->count() > 0)
            <div class="btn-group">
                {{-- Tombol Export PDF - BARU! --}}
                <a href="{{ route('super-admin.peminjaman.export-pdf', request()->query()) }}" 
                   class="btn btn-sm btn-danger"
                   target="_blank"
                   title="Export ke PDF dengan Kop Kampus">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                
                {{-- Tombol Download Excel yang sudah ada --}}
                <a href="{{ route('super-admin.peminjaman.export', request()->query()) }}" 
                   class="btn btn-sm btn-success">
                    <i class="fas fa-download"></i> Download Excel
                </a>
            </div>
            @endif
        </div>
        <div class="card-body">
            @if($peminjaman->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead style="background-color: #f9fafb;">
                            <tr>
                                <th>Kode</th>
                                <th>Peminjam</th>
                                <th>Alat</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjaman as $p)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $p->kode_peminjaman }}</span></td>
                                <td>
                                    <strong>{{ $p->user->name }}</strong><br>
                                    <small class="text-muted">{{ $p->user->nim }}</small>
                                </td>
                                <td>
                                    <strong>{{ $p->alat->nama_alat }}</strong><br>
                                    <small class="text-muted">{{ $p->alat->kode_alat }}</small>
                                </td>
                                <td>{{ $p->jumlah_pinjam }} unit</td>
                                <td>{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                                <td>{{ $p->tanggal_kembali_rencana->format('d M Y') }}</td>
                                <td>
                                    @if($p->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($p->status == 'disetujui')
                                        <span class="badge bg-info">Disetujui</span>
                                    @elseif($p->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif($p->status == 'dipinjam')
                                        <span class="badge bg-primary">Sedang Dipinjam</span>
                                    @elseif($p->status == 'dikembalikan')
                                        <span class="badge bg-success">Dikembalikan</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('super-admin.peminjaman.show', $p->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $peminjaman->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5>Tidak Ada Data Peminjaman</h5>
                    <p class="text-muted">Belum ada peminjaman yang tercatat dalam sistem</p>
                    <a href="{{ route('super-admin.peminjaman.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus"></i> Input Peminjaman Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection