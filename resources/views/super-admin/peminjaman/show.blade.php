@extends('layouts.super-admin')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- ===================== HEADER ===================== --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-file-alt me-2 text-primary"></i>Detail Peminjaman
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.peminjaman.index') }}">Peminjaman</a>
                            </li>
                            <li class="breadcrumb-item active">Detail #{{ $peminjaman->id }}</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            {{-- ===================== ALERTS ===================== --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ===================== MAIN LAYOUT ===================== --}}
            <div class="row">

                {{-- --------- LEFT COLUMN --------- --}}
                <div class="col-lg-8">

                    {{-- STATUS CARD --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">

                            {{-- Status Header --}}
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h5 class="mb-1">Status Peminjaman</h5>
                                    <p class="text-muted mb-0 small">ID: #{{ $peminjaman->id }}</p>
                                </div>
                                <div>
                                    @switch($peminjaman->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark px-3 py-2 fs-6">
                                                <i class="fas fa-clock me-1"></i>Menunggu Persetujuan
                                            </span>
                                            @break
                                        @case('disetujui')
                                            <span class="badge bg-success px-3 py-2 fs-6">
                                                <i class="fas fa-check-circle me-1"></i>Disetujui
                                            </span>
                                            @break
                                        @case('ditolak')
                                            <span class="badge bg-danger px-3 py-2 fs-6">
                                                <i class="fas fa-times-circle me-1"></i>Ditolak
                                            </span>
                                            @break
                                        @case('dipinjam')
                                            <span class="badge bg-info px-3 py-2 fs-6">
                                                <i class="fas fa-hand-holding me-1"></i>Sedang Dipinjam
                                            </span>
                                            @break
                                        @case('dikembalikan')
                                            <span class="badge bg-secondary px-3 py-2 fs-6">
                                                <i class="fas fa-undo me-1"></i>Sudah Dikembalikan
                                            </span>
                                            @break
                                    @endswitch
                                </div>
                            </div>

                            {{-- Timeline --}}
                            <div class="timeline">
                                <div class="timeline-item {{ in_array($peminjaman->status, ['dipinjam', 'dikembalikan']) ? 'completed' : '' }}">
                                    <div class="timeline-marker {{ in_array($peminjaman->status, ['dipinjam', 'dikembalikan']) ? 'bg-info' : 'bg-secondary' }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Alat Dipinjam</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>

                                <div class="timeline-item {{ $peminjaman->status === 'dikembalikan' ? 'completed' : '' }}">
                                    <div class="timeline-marker {{ $peminjaman->status === 'dikembalikan' ? 'bg-secondary' : 'bg-light' }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Alat Dikembalikan</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            @if ($peminjaman->tanggal_kembali_aktual)
                                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_aktual)->format('d M Y') }}
                                            @else
                                                Target: {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            @if ($peminjaman->status === 'pending')
                                <div class="mt-4 pt-4 border-top">
                                    <h6 class="mb-3">Aksi Persetujuan</h6>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-success btn-lg flex-fill"
                                            data-bs-toggle="modal" data-bs-target="#approveModal">
                                            <i class="fas fa-check-circle me-2"></i>Setujui Peminjaman
                                        </button>
                                        <button type="button" class="btn btn-danger btn-lg flex-fill"
                                            data-bs-toggle="modal" data-bs-target="#rejectModal">
                                            <i class="fas fa-times-circle me-2"></i>Tolak Peminjaman
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if ($peminjaman->status === 'disetujui')
                                <div class="mt-4 pt-4 border-top">
                                    <h6 class="mb-3">Aksi Peminjaman</h6>
                                    <form action="{{ route('admin.peminjaman.process', $peminjaman) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-info btn-lg w-100"
                                            onclick="return confirm('Konfirmasi bahwa alat sudah diambil oleh peminjam?')">
                                            <i class="fas fa-hand-holding me-2"></i>Tandai Alat Sudah Diambil
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if ($peminjaman->status === 'dipinjam')
                                <div class="mt-4 pt-4 border-top">
                                    <h6 class="mb-3">Aksi Pengembalian</h6>
                                    <button type="button" class="btn btn-primary btn-lg w-100"
                                        data-bs-toggle="modal" data-bs-target="#returnModal">
                                        <i class="fas fa-undo me-2"></i>Proses Pengembalian Alat
                                    </button>
                                </div>
                            @endif

                            {{-- Admin Notes --}}
                            @if ($peminjaman->status === 'ditolak' && $peminjaman->catatan_admin)
                                <div class="alert alert-danger mt-4 mb-0">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Alasan Penolakan
                                    </h6>
                                    <p class="mb-0">{{ $peminjaman->catatan_admin }}</p>
                                </div>
                            @endif

                            @if ($peminjaman->status === 'disetujui' && $peminjaman->catatan_admin)
                                <div class="alert alert-info mt-4 mb-0">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-info-circle me-2"></i>Catatan Admin
                                    </h6>
                                    <p class="mb-0">{{ $peminjaman->catatan_admin }}</p>
                                </div>
                            @endif

                        </div>
                    </div>

                    {{-- ALAT CARD --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-box me-2 text-primary"></i>Informasi Alat
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    @if ($peminjaman->alat->foto)
                                        <img src="{{ asset('storage/' . $peminjaman->alat->foto) }}"
                                            alt="{{ $peminjaman->alat->nama_alat }}"
                                            class="img-fluid rounded shadow-sm">
                                    @else
                                        <div class="text-center p-4 bg-light rounded">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="mb-0 mt-2 text-muted small">No Image</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h4 class="mb-3">{{ $peminjaman->alat->nama_alat }}</h4>
                                    <div class="row g-3">
                                        @foreach ([
                                            ['icon' => 'fa-barcode',    'label' => 'Kode Alat',       'value' => $peminjaman->alat->kode_alat],
                                            ['icon' => 'fa-layer-group','label' => 'Kategori',        'value' => $peminjaman->alat->kategori],
                                            ['icon' => 'fa-check-circle','label'=> 'Kondisi',         'value' => ucfirst($peminjaman->alat->kondisi)],
                                            ['icon' => 'fa-cubes',      'label' => 'Jumlah Dipinjam', 'value' => $peminjaman->jumlah_pinjam . ' Unit'],
                                            ['icon' => 'fa-warehouse',  'label' => 'Stok Tersedia',   'value' => $peminjaman->alat->jumlah_tersedia . ' Unit'],
                                        ] as $item)
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fas {{ $item['icon'] }} text-primary"></i>
                                                    <div>
                                                        <small class="text-muted d-block">{{ $item['label'] }}</small>
                                                        <strong>{{ $item['value'] }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DETAIL PEMINJAMAN CARD --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Detail Peminjaman
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="text-muted small mb-1">Tanggal Pinjam</label>
                                    <div class="p-3 bg-light rounded">
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        <strong>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small mb-1">Tanggal Kembali</label>
                                    <div class="p-3 bg-light rounded">
                                        <i class="fas fa-calendar-check text-primary me-2"></i>
                                        <strong>{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small mb-1">Durasi Peminjaman</label>
                                    <div class="p-3 bg-light rounded">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        <strong>
                                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->startOfDay()
                                                ->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_kembali)->startOfDay()) }}
                                            Hari
                                        </strong>
                                    </div>
                                </div>

                                @if ($peminjaman->keperluan)
                                    <div class="col-12">
                                        <label class="text-muted small mb-1">Keperluan</label>
                                        <div class="p-3 bg-light rounded">
                                            <i class="fas fa-sticky-note text-primary me-2"></i>
                                            {{ $peminjaman->keperluan }}
                                        </div>
                                    </div>
                                @endif

                                @if ($peminjaman->status === 'dikembalikan')
                                    <div class="col-md-6">
                                        <label class="text-muted small mb-1">Kondisi Saat Dikembalikan</label>
                                        <div class="p-3 bg-light rounded">
                                            <i class="fas fa-tools text-primary me-2"></i>
                                            <strong class="text-capitalize">
                                                {{ str_replace('_', ' ', $peminjaman->kondisi_saat_kembali) }}
                                            </strong>
                                        </div>
                                    </div>

                                    @if ($peminjaman->catatan_pengembalian)
                                        <div class="col-12">
                                            <label class="text-muted small mb-1">Catatan Pengembalian</label>
                                            <div class="p-3 bg-light rounded">
                                                <i class="fas fa-comment text-primary me-2"></i>
                                                {{ $peminjaman->catatan_pengembalian }}
                                            </div>
                                        </div>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>

                </div>

                {{-- --------- RIGHT COLUMN (SIDEBAR) --------- --}}
                <div class="col-lg-4">

                    {{-- USER CARD --}}
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0">
                                <i class="fas fa-user me-2 text-primary"></i>Informasi Peminjam
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="avatar-circle mx-auto mb-3">
                                    {{ strtoupper(substr($peminjaman->user->name, 0, 2)) }}
                                </div>
                                <h5 class="mb-1">{{ $peminjaman->user->name }}</h5>
                                <p class="text-muted mb-0 small">{{ $peminjaman->user->email }}</p>
                            </div>
                            <hr>
                            <div class="info-list">
                                @if ($peminjaman->user->phone ?? false)
                                    <div class="info-item">
                                        <i class="fas fa-phone text-primary"></i>
                                        <span>{{ $peminjaman->user->phone }}</span>
                                    </div>
                                @endif
                                @if ($peminjaman->user->nim ?? false)
                                    <div class="info-item">
                                        <i class="fas fa-id-card text-primary"></i>
                                        <span>{{ $peminjaman->user->nim }}</span>
                                    </div>
                                @endif
                                <div class="info-item">
                                    <i class="fas fa-calendar-plus text-primary"></i>
                                    <span>Member sejak {{ $peminjaman->user->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ACTIONS CARD --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0">
                                <i class="fas fa-cog me-2 text-primary"></i>Aksi Lainnya
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-outline-primary"
                                    onclick="window.print(); return false;">
                                    <i class="fas fa-print me-2"></i>Cetak Detail
                                </a>
                                @if (in_array($peminjaman->status, ['ditolak', 'dikembalikan']))
                                    <form action="{{ route('admin.peminjaman.destroy', $peminjaman) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100">
                                            <i class="fas fa-trash me-2"></i>Hapus Data
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


{{-- ===================== MODAL: SETUJUI ===================== --}}
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>Setujui Peminjaman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.peminjaman.approve', $peminjaman) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="approval-icon">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                    </div>
                    <p class="text-center mb-4">
                        Apakah Anda yakin ingin <strong>menyetujui</strong> peminjaman ini?
                    </p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>
                            Setelah disetujui, stok alat akan berkurang sebanyak
                            <strong>{{ $peminjaman->jumlah_pinjam }} unit</strong>.
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" name="catatan_admin" rows="3"
                            placeholder="Tambahkan catatan untuk peminjam..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>Ya, Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ===================== MODAL: TOLAK ===================== --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle me-2"></i>Tolak Peminjaman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.peminjaman.reject', $peminjaman) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="approval-icon">
                            <i class="fas fa-times-circle text-danger"></i>
                        </div>
                    </div>
                    <p class="text-center mb-4">
                        Apakah Anda yakin ingin <strong>menolak</strong> peminjaman ini?
                    </p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <small>Peminjam akan melihat alasan penolakan yang Anda berikan.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Alasan Penolakan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" name="catatan_admin" rows="4"
                            placeholder="Jelaskan alasan penolakan..." required></textarea>
                        <small class="text-muted">
                            Berikan penjelasan yang jelas agar peminjam memahami alasan penolakan.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-2"></i>Ya, Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ===================== MODAL: KEMBALIKAN ===================== --}}
<div class="modal fade" id="returnModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-undo me-2"></i>Proses Pengembalian
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.peminjaman.return', $peminjaman) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p class="mb-4">
                        Konfirmasi pengembalian alat <strong>{{ $peminjaman->alat->nama_alat }}</strong>
                    </p>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Kondisi Saat Dikembalikan <span class="text-danger">*</span>
                        </label>
                        <div class="row g-2">
                            @foreach ([
                                ['value' => 'baik',         'label' => 'Baik',        'icon' => 'fa-check-circle',      'style' => 'success'],
                                ['value' => 'rusak_ringan', 'label' => 'Rusak Ringan','icon' => 'fa-exclamation-triangle','style' => 'warning'],
                                ['value' => 'rusak_berat',  'label' => 'Rusak Berat', 'icon' => 'fa-times-circle',       'style' => 'danger'],
                                ['value' => 'hilang',       'label' => 'Hilang',      'icon' => 'fa-question-circle',    'style' => 'dark'],
                            ] as $kondisi)
                                <div class="col-6">
                                    <input type="radio" class="btn-check"
                                        name="kondisi_saat_kembali"
                                        id="kondisi_{{ $kondisi['value'] }}"
                                        value="{{ $kondisi['value'] }}"
                                        {{ $kondisi['value'] === 'baik' ? 'checked' : '' }}
                                        required>
                                    <label class="btn btn-outline-{{ $kondisi['style'] }} w-100"
                                        for="kondisi_{{ $kondisi['value'] }}">
                                        <i class="fas {{ $kondisi['icon'] }} d-block mb-1"></i>
                                        {{ $kondisi['label'] }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-1"></i>
                        <strong>Catatan:</strong> Jika kondisi "Hilang", stok total akan dikurangi.
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan Pengembalian (Opsional)</label>
                        <textarea class="form-control" name="catatan_pengembalian" rows="3"
                            placeholder="Catatan kondisi atau kerusakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Pengembalian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('styles')
<style>
    /* ---- Timeline ---- */
    .timeline { position: relative; padding: 20px 0; }
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px; top: 0; bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    .timeline-item { position: relative; padding-left: 50px; margin-bottom: 30px; }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-marker {
        position: absolute;
        left: 8px; top: 0;
        width: 16px; height: 16px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #e9ecef;
    }
    .timeline-item.completed .timeline-marker { box-shadow: 0 0 0 2px currentColor; }

    /* ---- Avatar ---- */
    .avatar-circle {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex; align-items: center; justify-content: center;
        font-size: 28px; font-weight: bold;
    }

    /* ---- Info List ---- */
    .info-list { display: flex; flex-direction: column; gap: 12px; }
    .info-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    .info-item i { width: 20px; text-align: center; }

    /* ---- Approval Icon ---- */
    .approval-icon {
        width: 80px; height: 80px;
        margin: 0 auto;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 40px;
    }

    /* ---- Card Hover ---- */
    .card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }

    /* ---- Print ---- */
    @media print {
        .btn, .modal, nav, .col-lg-4 { display: none !important; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-dismiss alerts setelah 5 detik
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            bootstrap.Alert.getOrCreateInstance(el).close();
        });
    }, 5000);
</script>
@endpush

@endsection