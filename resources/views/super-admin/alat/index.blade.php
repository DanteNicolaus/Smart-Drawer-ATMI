@extends('layouts.super-admin')
@section('title', 'Daftar Alat')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-box"></i> Daftar Alat</h1>
            <p class="text-muted mb-0">Kelola semua alat laboratorium</p>
        </div>
        <a href="{{ route('super-admin.alat.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> Tambah Alat
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('super-admin.alat.index') }}" class="row g-3">
                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak_tersedia" {{ request('status') == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari alat..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Alat Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3 bg-white border-bottom">
            <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                <i class="fas fa-list"></i> Data Alat ({{ $alat->total() }} alat)
            </h6>
        </div>
        <div class="card-body">
            @if($alat->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead style="background-color: #f9fafb;">
                            <tr>
                                <th>Foto</th>
                                <th>Kode</th>
                                <th>Nama Alat</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Tersedia</th>
                                <th>Kondisi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alat as $item)
                            <tr>
                                <td>
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_alat }}" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div style="width: 50px; height: 50px; background: #f5f5f5; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-box fa-lg text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><code>{{ $item->kode_alat }}</code></td>
                                <td><strong>{{ $item->nama_alat }}</strong></td>
                                <td><span class="badge bg-info">{{ $item->kategori }}</span></td>
                                <td>{{ $item->jumlah_total }}</td>
                                <td>
                                    <span class="badge {{ $item->jumlah_tersedia <= 3 ? 'bg-warning text-dark' : 'bg-success' }}">
                                        {{ $item->jumlah_tersedia }}
                                    </span>
                                </td>
                                <td>{{ ucfirst(str_replace('_', ' ', $item->kondisi)) }}</td>
                                <td>
                                    <form method="POST" action="{{ route('super-admin.alat.toggle-status', $item->id) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $item->status === 'tersedia' ? 'btn-success' : 'btn-danger' }}">
                                            {{ $item->status === 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('super-admin.alat.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('super-admin.alat.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmDeleteAlat({{ $item->id }}, '{{ $item->nama_alat }}')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-alat-form-{{ $item->id }}" action="{{ route('super-admin.alat.destroy', $item->id) }}" 
                                          method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $alat->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data alat</h5>
                    <a href="{{ route('super-admin.alat.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Alat Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDeleteAlat(alatId, alatName) {
        if (confirm(`Apakah Anda yakin ingin menghapus alat "${alatName}"?`)) {
            document.getElementById('delete-alat-form-' + alatId).submit();
        }
    }
</script>
@endpush