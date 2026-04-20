@extends('layouts.super-admin')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                </i> Dashboard Super Admin
            </h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total User Biasa -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #6b7280; font-size: 0.75rem;">
                                Total User Biasa
                            </div>
                            <div class="h5 mb-0 font-weight-bold" style="color: #1f2937;">
                                {{ $totalUsers }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x" style="color: #3b82f6; opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Lab -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #6b7280; font-size: 0.75rem;">
                                Admin Lab
                            </div>
                            <div class="h5 mb-0 font-weight-bold" style="color: #1f2937;">
                                {{ $totalAdminLab }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x" style="color: #10b981; opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Admin -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #6b7280; font-size: 0.75rem;">
                                User Admin
                            </div>
                            <div class="h5 mb-0 font-weight-bold" style="color: #1f2937;">
                                {{ $totalUserAdmin }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-cog fa-2x" style="color: #06b6d4; opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Peminjaman -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #6b7280; font-size: 0.75rem;">
                                Total Peminjaman
                            </div>
                            <div class="h5 mb-0 font-weight-bold" style="color: #1f2937;">
                                {{ $totalPeminjaman }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x" style="color: #f59e0b; opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Alat -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #6b7280; font-size: 0.75rem;">
                                Total Alat
                            </div>
                            <div class="h5 mb-0 font-weight-bold" style="color: #1f2937;">
                                {{ $totalAlat }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x" style="color: #8b5cf6; opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('super-admin.admins.create') }}" class="btn btn-lg btn-outline-primary w-100 py-4" style="border-radius: 12px;">
                                <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                                <strong>Tambah Admin Baru</strong>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('super-admin.users.index') }}" class="btn btn-lg btn-outline-success w-100 py-4" style="border-radius: 12px;">
                                <i class="fas fa-users fa-2x mb-2"></i><br>
                                <strong>Kelola User</strong>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('super-admin.alat.index') }}" class="btn btn-lg btn-outline-info w-100 py-4" style="border-radius: 12px;">
                                <i class="fas fa-boxes fa-2x mb-2"></i><br>
                                <strong>Kelola Alat</strong>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('super-admin.peminjaman.index') }}" class="btn btn-lg btn-outline-warning w-100 py-4" style="border-radius: 12px;">
                                <i class="fas fa-history fa-2x mb-2"></i><br>
                                <strong>Lihat Semua Riwayat</strong>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Alat Per Kategori -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold" style="color: #1f2937;">
                        <i class="fas fa-cubes"></i> Statistik Alat Per Kategori
                    </h6>
                </div>
                <div class="card-body">
                    @if($alatPerKategori->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead style="background-color: #f9fafb;">
                                    <tr>
                                        <th style="color: #374151;">Kategori</th>
                                        <th class="text-center" style="color: #374151;">Total Alat</th>
                                        <th class="text-center" style="color: #374151;">Tersedia</th>
                                        <th class="text-center" style="color: #374151;">Sedang Dipinjam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alatPerKategori as $kat)
                                    <tr>
                                        <td><strong>{{ $kat->kategori }}</strong></td>
                                        <td class="text-center">{{ $kat->total }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success">{{ $kat->tersedia }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning text-dark">
                                                {{ $kat->total - $kat->tersedia }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-box-open fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada data alat</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }
    
    .card {
        border-radius: 12px;
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
</style>
@endpush