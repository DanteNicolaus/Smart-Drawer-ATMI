@extends('layouts.user-admin')

@section('title', 'Dashboard User Admin')

@section('content')
<div class="container-fluid px-4">

    <!-- Page Header -->
    <div class="page-header mb-4">
        <div>
            <h1 class="h3 mb-2">
                </i> Dashboard User Admin
            </h1>
            <p class="text-muted mb-0">Kelola akun user sistem Smart Drawer ATMI</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total User Terdaftar -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="stat-card purple">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">
                        <i class="fas fa-chart-bar"></i> Total User Terdaftar
                    </div>
                    <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
                    <small class="stat-description">User aktif dalam sistem</small>
                </div>
            </div>
        </div>

        <!-- User Aktif (Memiliki Koin) -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="stat-card green">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">
                        <i class="fas fa-coins"></i> User Aktif (Punya Koin)
                    </div>
                    <div class="stat-value">{{ $activeUsers ?? 0 }}</div>
                    <small class="stat-description">User dengan koin &gt; 0</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="action-card">
                <div class="action-header">
                    <h6>
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h6>
                </div>
                <div class="action-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('user-admin.users.index') }}" class="action-btn primary">
                                <div class="action-icon">
                                    <i class="fas fa-list"></i>
                                </div>
                                <strong>Lihat Semua User</strong>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('user-admin.users.create') }}" class="action-btn success">
                                <div class="action-icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <strong>Tambah User Baru</strong>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('user-admin.users.index') }}" class="action-btn info">
                                <div class="action-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <strong>Cari User</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Terbaru -->
    <div class="row">
        <div class="col-12">
            <div class="table-card mb-4">
                <div class="table-header">
                    <h6>
                        <i class="fas fa-user"></i> User Terbaru
                    </h6>
                    <a href="{{ route('user-admin.users.index') }}" class="btn-view-all">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="table-body">
                    @if(isset($recentUsers) && $recentUsers->count() > 0)
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Jurusan</th>
                                    <th>Email</th>
                                    <th>Koin</th>
                                    <th>Terdaftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                <tr>
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
                                            @if($user->created_at)
                                                {{ $user->created_at->diffForHumans() }}
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5>Belum Ada User Terdaftar</h5>
                        <p>Mulai dengan menambahkan user pertama ke sistem</p>
                        <a href="{{ route('user-admin.users.create') }}" class="btn-primary">
                            <i class="fas fa-plus"></i> Tambah User Pertama
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
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
    .page-header h1 {
        color: #333;
        font-weight: 700;
        font-size: 28px;
    }

    .page-header p {
        color: #666;
        font-size: 15px;
    }

    /* Statistics Cards */
    .stat-card {
        background: white;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 24px;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    }

    .stat-card.purple {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
    }

    .stat-card.green {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    }

    .stat-icon-wrapper {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #7c4dff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .stat-card.green .stat-icon-wrapper {
        color: #66bb6a;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        margin-bottom: 4px;
    }

    .stat-description {
        font-size: 13px;
        color: #999;
    }

    /* Action Card */
    .action-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .action-header {
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        padding: 20px 28px;
    }

    .action-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 16px;
    }

    .action-body {
        padding: 32px 28px;
    }

    .action-btn {
        display: block;
        padding: 32px 20px;
        background: white;
        border-radius: 16px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
        border: 2px solid #e8eaf6;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .action-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 24px rgba(0,0,0,0.12);
        border-color: transparent;
    }

    .action-btn.primary {
        background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
    }

    .action-btn.success {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    }

    .action-btn.info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    }

    .action-icon {
        width: 56px;
        height: 56px;
        background: rgba(255,255,255,0.8);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
        color: #7c4dff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .action-btn.success .action-icon {
        color: #66bb6a;
    }

    .action-btn.info .action-icon {
        color: #42a5f5;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #f0f0f0;
    }

    .table-header h6 {
        margin: 0;
        font-weight: 600;
        color: #333;
        font-size: 16px;
    }

    .btn-view-all {
        padding: 8px 20px;
        background: linear-gradient(135deg, #7c4dff 0%, #b388ff 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.3);
    }

    .btn-view-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 77, 255, 0.4);
        color: white;
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

    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        height: 100%;
    }

    .info-card.blue {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 50%);
    }

    .info-card.yellow {
        background: linear-gradient(135deg, #fff9e6 0%, #ffecb3 50%);
    }

    .info-header {
        padding: 20px 24px;
        border-bottom: 2px solid rgba(255,255,255,0.5);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-header i {
        font-size: 20px;
        color: #1976d2;
    }

    .info-card.yellow .info-header i {
        color: #f57f17;
    }

    .info-header h6 {
        margin: 0;
        font-weight: 600;
        color: #1976d2;
        font-size: 15px;
    }

    .info-card.yellow .info-header h6 {
        color: #f57f17;
    }

    .info-body {
        padding: 24px;
    }

    .info-subtitle {
        font-size: 14px;
        margin-bottom: 12px;
        color: #333;
    }

    .info-list {
        margin: 0;
        padding-left: 20px;
        font-size: 13px;
        color: #555;
    }

    .info-list li {
        margin-bottom: 8px;
        line-height: 1.6;
    }
</style>
@endpush