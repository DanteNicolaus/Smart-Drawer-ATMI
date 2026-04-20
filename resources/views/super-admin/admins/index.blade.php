@extends('layouts.super-admin')

@section('title', 'Kelola Admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-user-shield"></i> Kelola Admin
            </h1>
            <p class="text-muted mb-0">Kelola Admin Lab dan User Admin</p>
        </div>
        <a href="{{ route('super-admin.admins.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> Tambah Admin Baru
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('super-admin.admins.index') }}" class="row g-3">
                <div class="col-md-4">
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin Lab</option>
                        <option value="user_admin" {{ request('role') == 'user_admin' ? 'selected' : '' }}>User Admin</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="search" class="form-select" 
                           placeholder="Cari nama, email, atau no HP..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Admins Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3 bg-white border-bottom">
            <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                <i class="fas fa-list"></i> Daftar Admin ({{ $admins->total() }} admin)
            </h6>
        </div>
        <div class="card-body">
            @if($admins->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead style="background-color: #f9fafb;">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Role</th>
                                <th>Terdaftar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $index => $admin)
                            <tr>
                                <td>{{ $admins->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">
                                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                                        </div>
                                        <strong>{{ $admin->name }}</strong>
                                    </div>
                                </td>
                                <td><small>{{ $admin->email }}</small></td>
                                <td>{{ $admin->no_hp }}</td>
                                <td>
                                    @if($admin->role == 'admin')
                                        <span class="badge bg-success">Admin Lab</span>
                                    @else
                                        <span class="badge bg-info">User Admin</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $admin->created_at->diffForHumans() }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('super-admin.admins.edit', $admin) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $admin->id }}, '{{ $admin->name }}')" 
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <form id="delete-form-{{ $admin->id }}" 
                                          action="{{ route('super-admin.admins.destroy', $admin) }}" 
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

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $admins->firstItem() }} - {{ $admins->lastItem() }} dari {{ $admins->total() }} admin
                    </div>
                    <div>
                        {{ $admins->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-shield fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data admin</h5>
                    <p class="text-muted">
                        @if(request('search') || request('role'))
                            Tidak ada admin yang sesuai dengan filter yang dipilih.
                        @else
                            Belum ada admin yang terdaftar di sistem.
                        @endif
                    </p>
                    @if(request('search') || request('role'))
                        <a href="{{ route('super-admin.admins.index') }}" class="btn btn-primary">
                            <i class="fas fa-redo"></i> Reset Filter
                        </a>
                    @else
                        <a href="{{ route('super-admin.admins.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Admin Pertama
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(adminId, adminName) {
        if (confirm(`Apakah Anda yakin ingin menghapus admin "${adminName}"?\n\nData admin akan dihapus permanen.`)) {
            document.getElementById('delete-form-' + adminId).submit();
        }
    }
</script>
@endpush