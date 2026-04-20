@extends('layouts.super-admin')

@section('title', 'Kelola User')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-users"></i> Kelola User
            </h1>
            <p class="text-muted mb-0">Daftar semua user yang terdaftar di sistem</p>
        </div>
        <a href="{{ route('super-admin.users.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> Tambah User
        </a>
    </div>

    <!-- Filter & Search Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('super-admin.users.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari nama, NIM, email, atau jurusan...">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="jurusan" onchange="this.form.submit()">
                            <option value="">-- Semua Jurusan --</option>
                            @foreach($jurusans as $jur)
                                <option value="{{ $jur }}" {{ request('jurusan') == $jur ? 'selected' : '' }}>{{ $jur }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('super-admin.users.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-redo"></i> Reset Filter
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header py-3 bg-white border-bottom">
            <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                <i class="fas fa-list"></i> Daftar User ({{ $users->total() }} user)
            </h6>
        </div>
        <div class="card-body">
            @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background-color: #f9fafb;">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Jurusan</th>
                            <th>Email</th>
                            <th>Koin</th>
                            <th>Terdaftar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td><code>{{ $user->nim }}</code></td>
                            <td><span class="badge bg-info">{{ $user->jurusan }}</span></td>
                            <td><small>{{ $user->email }}</small></td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-coins"></i> {{ $user->koin }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $user->created_at ? $user->created_at->diffForHumans() : 'N/A' }}
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('super-admin.users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('super-admin.users.destroy', $user) }}" 
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

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user
                </div>
                <div>{{ $users->appends(request()->query())->links() }}</div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada data user</h5>
                <a href="{{ route('super-admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah User Pertama
                </a>
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
    function confirmDelete(userId, userName) {
        if (confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?`)) {
            document.getElementById('delete-form-' + userId).submit();
        }
    }
</script>
@endpush