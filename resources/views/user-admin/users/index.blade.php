@extends('layouts.user-admin')

@section('title', 'Kelola User')

@section('content')
<div class="container-fluid px-4">
   
<!-- Header -->
<div class="page-header mb-4">
    <div>
        <h1 class="h3 mb-2">
            <i class="fas fa-users"></i> Kelola User
        </h1>
        <p class="text-muted mb-0">Daftar semua user yang terdaftar di sistem</p>
    </div>
    <div class="header-actions">
        <!-- Export Buttons -->
        <div class="btn-group me-2">
            <a href="{{ route('user-admin.users.export-pdf') }}{{ request()->has('search') || request()->has('jurusan') ? '?' . http_build_query(request()->only(['search', 'jurusan'])) : '' }}" 
               class="btn-export pdf" 
               target="_blank"
               title="Export ke PDF">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
            <a href="{{ route('user-admin.users.export-excel') }}{{ request()->has('search') || request()->has('jurusan') ? '?' . http_build_query(request()->only(['search', 'jurusan'])) : '' }}" 
               class="btn-export excel"
               title="Export ke Excel">
                <i class="fas fa-file-excel"></i> Excel
            </a>
        </div>
        
        <!-- Add User Button -->
        <a href="{{ route('user-admin.users.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>
</div>

<!-- ============================================== -->
<!-- TAMBAHKAN CSS INI DI @push('styles') -->
<!-- ============================================== -->

<style>
    /* Header Actions */
    .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-group {
        display: flex;
        gap: 0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 12px;
        overflow: hidden;
    }

    .btn-export {
        padding: 12px 20px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }

    .btn-export.pdf {
        background: linear-gradient(135deg, #ef5350 0%, #e53935 100%);
    }

    .btn-export.pdf:hover {
        background: linear-gradient(135deg, #e53935 0%, #c62828 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 83, 80, 0.4);
        color: white;
    }

    .btn-export.excel {
        background: linear-gradient(135deg, #66bb6a 0%, #43a047 100%);
    }

    .btn-export.excel:hover {
        background: linear-gradient(135deg, #43a047 0%, #2e7d32 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 187, 106, 0.4);
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 16px;
        }

        .header-actions {
            width: 100%;
            flex-direction: column;
        }

        .btn-group {
            width: 100%;
        }

        .btn-export {
            flex: 1;
            justify-content: center;
        }

        .btn-add {
            width: 100%;
            justify-content: center;
        }
    }
</style>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="alert-success">
        <div class="alert-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="alert-content">
            {{ session('success') }}
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Alert Error -->
    @if(session('error'))
    <div class="alert-error">
        <div class="alert-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="alert-content">
            {{ session('error') }}
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Filter & Search Card -->
    <div class="filter-card mb-4">
        <div class="filter-header">
            <h6>
                <i class="fas fa-filter"></i> Filter & Pencarian
            </h6>
        </div>
        <div class="filter-body">
            <form action="{{ route('user-admin.users.index') }}" method="GET">
                <div class="row">
                    <!-- Search -->
                    <div class="col-md-5">
                        <div class="search-group">
                            <input 
                                type="text" 
                                class="search-input" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder=" Cari nama, NIM, email, atau jurusan..."
                            >
                            <button class="search-btn" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>

                    <!-- Filter Jurusan -->
                    <div class="col-md-4">
                        <select class="filter-select" name="jurusan" onchange="this.form.submit()">
                            <option value="">-- Semua Jurusan --</option>
                            @foreach($jurusans as $jur)
                                <option value="{{ $jur }}" {{ request('jurusan') == $jur ? 'selected' : '' }}>
                                    {{ $jur }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Reset Button -->
                    <div class="col-md-3">
                        <a href="{{ route('user-admin.users.index') }}" class="reset-btn">
                            <i class="fas fa-redo"></i> Reset Filter
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="table-card mb-4">
        <div class="table-header">
            <h6>
                <i class="fas fa-list"></i> Daftar User ({{ $users->total() }} user)
            </h6>
        </div>
        <div class="table-body">
            @if($users->count() > 0)
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
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
                                <div class="user-info">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td><code class="nim-code">{{ $user->nim }}</code></td>
                            <td>
                                <span class="badge badge-info">{{ $user->jurusan }}</span>
                            </td>
                            <td>
                                <small class="email-text">{{ $user->email }}</small>
                            </td>
                            <td>
                                <span class="badge badge-warning">
                                    <i class="fas fa-coins"></i> {{ $user->koin }}
                                </span>
                            </td>
                            <td>
                                <small class="time-text">
                                    {{ $user->created_at ? $user->created_at->diffForHumans() : 'N/A' }}
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <!-- Edit Button -->
                                    <a 
                                        href="{{ route('user-admin.users.edit', $user) }}" 
                                        class="action-btn edit"
                                        title="Edit"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <button 
                                        type="button" 
                                        class="action-btn delete"
                                        onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                        title="Hapus"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Form (Hidden) -->
                                <form 
                                    id="delete-form-{{ $user->id }}" 
                                    action="{{ route('user-admin.users.destroy', $user) }}" 
                                    method="POST" 
                                    class="d-none"
                                >
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
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user
                </div>
                <div>
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h5>Tidak ada data user</h5>
                <p>
                    @if(request('search') || request('jurusan'))
                        Tidak ada user yang sesuai dengan filter yang dipilih.
                    @else
                        Belum ada user yang terdaftar di sistem.
                    @endif
                </p>
                @if(request('search') || request('jurusan'))
                    <a href="{{ route('user-admin.users.index') }}" class="btn-primary">
                        <i class="fas fa-redo"></i> Reset Filter
                    </a>
                @else
                    <a href="{{ route('user-admin.users.create') }}" class="btn-primary">
                        <i class="fas fa-plus"></i> Tambah User Pertama
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
    body {
        background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        min-height: 100vh;
    }

    .container-fluid {
        padding: 30px 20px;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h1 {
        color: #333;
        font-weight: 700;
        font-size: 28px;
    }

    .page-header p {
        color: #666;
        font-size: 15px;
    }

    .btn-add {
        padding: 12px 28px;
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 77, 255, 0.4);
        color: white;
    }

    /* Alerts */
    .alert-success, .alert-error {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        border-radius: 16px;
        margin-bottom: 20px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        animation: slideIn 0.3s ease;
    }

    .alert-success {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        color: #2e7d32;
    }

    .alert-error {
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
        color: #c62828;
    }

    .alert-icon {
        font-size: 24px;
    }

    .alert-content {
        flex: 1;
        font-weight: 500;
    }

    .alert-close {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        opacity: 0.6;
        transition: opacity 0.3s;
    }

    .alert-close:hover {
        opacity: 1;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Filter Card */
    .filter-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .filter-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 18px 24px;
        border-bottom: 2px solid #f0f0f0;
    }

    .filter-header h6 {
        margin: 0;
        font-weight: 600;
        color: #333;
        font-size: 15px;
    }

    .filter-body {
        padding: 24px;
    }

    .search-group {
        display: flex;
        gap: 0;
    }

    .search-input {
        flex: 1;
        padding: 12px 16px;
        border: 2px solid #e8eaf6;
        border-right: none;
        border-radius: 12px 0 0 12px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #7c4dff;
    }

    .search-btn {
        padding: 12px 24px;
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        border: none;
        border-radius: 0 12px 12px 0;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.3);
    }

    .search-btn:hover {
        box-shadow: 0 6px 20px rgba(124, 77, 255, 0.4);
    }

    .filter-select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e8eaf6;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .filter-select:focus {
        outline: none;
        border-color: #7c4dff;
    }

    .reset-btn {
        display: block;
        width: 100%;
        padding: 12px 16px;
        background: #f5f5f5;
        color: #666;
        text-decoration: none;
        border-radius: 12px;
        text-align: center;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid #e0e0e0;
    }

    .reset-btn:hover {
        background: #eeeeee;
        color: #333;
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .table-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 20px 28px;
        border-bottom: 2px solid #f0f0f0;
    }

    .table-header h6 {
        margin: 0;
        font-weight: 600;
        color: #333;
        font-size: 16px;
    }

    .table-body {
        padding: 28px;
    }

    /* Modern Table */
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .modern-table thead th {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 14px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #666;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .modern-table thead th:first-child {
        border-radius: 12px 0 0 12px;
    }

    .modern-table thead th:last-child {
        border-radius: 0 12px 12px 0;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
    }

    .modern-table tbody tr:hover {
        transform: translateX(4px);
    }

    .modern-table tbody td {
        background: white;
        padding: 16px;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
    }

    .modern-table tbody td:first-child {
        border-left: 1px solid #f0f0f0;
        border-radius: 12px 0 0 12px;
    }

    .modern-table tbody td:last-child {
        border-right: 1px solid #f0f0f0;
        border-radius: 0 12px 12px 0;
    }

    /* User Info */
    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.3);
    }

    .nim-code {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        color: #333;
        font-weight: 600;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        color: #1976d2;
    }

    .badge-warning {
        background: linear-gradient(135deg, #fff9e6 0%, #ffecb3 100%);
        color: #f57f17;
    }

    .email-text {
        color: #666;
        font-size: 13px;
    }

    .time-text {
        color: #999;
        font-size: 12px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: white;
        font-size: 14px;
    }

    .action-btn.edit {
        background: linear-gradient(135deg, #ffb74d 0%, #ffa726 100%);
        box-shadow: 0 4px 12px rgba(255, 183, 77, 0.3);
    }

    .action-btn.edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 183, 77, 0.4);
    }

    .action-btn.delete {
        background: linear-gradient(135deg, #ef5350 0%, #e53935 100%);
        box-shadow: 0 4px 12px rgba(239, 83, 80, 0.3);
    }

    .action-btn.delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 83, 80, 0.4);
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
    }

    .pagination-info {
        color: #666;
        font-size: 14px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 64px;
        color: #e0e0e0;
        margin-bottom: 20px;
    }

    .empty-state h5 {
        color: #333;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 24px;
    }

    .btn-primary {
        display: inline-block;
        padding: 12px 28px;
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 77, 255, 0.4);
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(userId, userName) {
        if (confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?\n\nData user dan riwayat peminjaman yang sudah selesai akan dihapus permanen.`)) {
            document.getElementById('delete-form-' + userId).submit();
        }
    }
</script>
@endpush