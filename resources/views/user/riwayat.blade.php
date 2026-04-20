@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')

@push('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #5b4fcf;
            --primary-light: #ede9fb;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #38bdf8;
            --blue: #3b82f6;
            --surface: #ffffff;
            --bg: #f3f4f8;
            --text: #1e1e2e;
            --muted: #6b7280;
            --border: #e5e7eb;
            --radius: 14px;
            --shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
        }

        .page-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 20px;
        }

        /* ---- Header ---- */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-header-text h1 {
            font-size: 26px;
            font-weight: 700;
            color: var(--text);
            margin: 0 0 4px;
        }

        .page-header-text p {
            color: var(--muted);
            font-size: 14px;
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        }

        .btn-export {
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            cursor: pointer;
            transition: filter .2s;
        }

        .btn-export.pdf {
            background: linear-gradient(135deg, #ef5350, #e53935);
        }

        .btn-export.excel {
            background: linear-gradient(135deg, #66bb6a, #43a047);
        }

        .btn-export:hover {
            filter: brightness(.88);
            color: white;
        }

        /* ---- Table Card ---- */
        .table-card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 24px 24px 16px;
            border: 1px solid var(--border);
        }

        /* ---- Status Badge ---- */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-badge.pending {
            background: #fff7ed;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .status-badge.disetujui {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .status-badge.ditolak {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .status-badge.dipinjam {
            background: #f0f9ff;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .status-badge.dikembalikan {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        /* ---- Action Button ---- */
        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 14px;
            background: linear-gradient(135deg, #5b4fcf, #9333ea);
            color: white;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all .25s;
            box-shadow: 0 3px 10px rgba(91, 79, 207, .25);
            white-space: nowrap;
        }

        .btn-detail:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 16px rgba(91, 79, 207, .35);
            color: white;
        }

        /* ---- Catatan Ditolak (tooltip-like) ---- */
        .catatan-text {
            font-size: 12px;
            color: #b91c1c;
            max-width: 160px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ---- DataTables Overrides ---- */
        div.dataTables_wrapper {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            color: var(--text);
        }

        div.dataTables_length label,
        div.dataTables_filter label {
            color: var(--muted);
            font-weight: 500;
        }

        div.dataTables_length select,
        div.dataTables_filter input {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 6px 10px;
            font-family: inherit;
            font-size: 13px;
            outline: none;
            transition: border-color .2s;
        }

        div.dataTables_length select:focus,
        div.dataTables_filter input:focus {
            border-color: var(--primary);
        }

        table.dataTable thead th {
            background: #f8f7ff;
            color: var(--primary);
            font-weight: 700;
            font-size: 12.5px;
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: 2px solid #ede9fb !important;
            padding: 12px 14px;
        }

        table.dataTable tbody td {
            padding: 12px 14px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }

        table.dataTable tbody tr:last-child td {
            border-bottom: none;
        }

        table.dataTable tbody tr:hover td {
            background: #f8f7ff;
        }

        div.dataTables_info {
            color: var(--muted);
            font-size: 13px;
            padding-top: 12px;
        }

        div.dataTables_paginate {
            padding-top: 10px;
        }

        div.dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            font-size: 13px;
            font-weight: 500;
            padding: 5px 12px !important;
            margin: 0 2px;
            border: 1.5px solid transparent !important;
            transition: all .2s;
        }

        div.dataTables_paginate .paginate_button.current,
        div.dataTables_paginate .paginate_button.current:hover {
            background: var(--primary) !important;
            color: white !important;
            border-color: var(--primary) !important;
        }

        div.dataTables_paginate .paginate_button:hover {
            background: var(--primary-light) !important;
            color: var(--primary) !important;
            border-color: var(--primary-light) !important;
        }

        /* ---- Kode peminjaman ---- */
        .kode-pill {
            font-size: 12px;
            font-weight: 700;
            background: #f3f4f8;
            color: #374151;
            padding: 3px 10px;
            border-radius: 6px;
            letter-spacing: .3px;
        }

        /* ---- Alat info ---- */
        .alat-name {
            font-weight: 600;
            font-size: 13.5px;
            color: var(--text);
        }

        .alat-kode {
            font-size: 11.5px;
            color: var(--muted);
        }

        /* ---- Responsive ---- */
        @media (max-width: 768px) {
            .page-wrap {
                padding: 20px 12px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
            }

            .btn-export {
                flex: 1;
                justify-content: center;
            }

            .table-card {
                padding: 16px 12px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-wrap">

        {{-- Header --}}
        <div class="page-header">
            <div class="page-header-text">
                <h1>📜 Riwayat Peminjaman</h1>
                <p>Daftar semua riwayat peminjaman yang tercatat di sistem</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('user.riwayat.export-pdf') }}" class="btn-export pdf" target="_blank">
                    📄 PDF
                </a>
                <a href="{{ route('user.riwayat.export-excel') }}" class="btn-export excel">
                    📊 Excel
                </a>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="table-card">
            <table id="riwayatTable" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Alat</th>
                        <th>Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th>Dikembalikan</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatPeminjaman as $peminjaman)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <span class="kode-pill">{{ $peminjaman->kode_peminjaman }}</span>
                            </td>

                            <td>
                                <div class="alat-name">{{ $peminjaman->alat->nama_alat }}</div>
                                <div class="alat-kode">{{ $peminjaman->alat->kode_alat }}</div>
                            </td>

                            <td>{{ $peminjaman->jumlah_pinjam }} unit</td>

                            <td>{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</td>

                            <td>{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</td>

                            <td>
                                @if ($peminjaman->tanggal_kembali_aktual)
                                    {{ $peminjaman->tanggal_kembali_aktual->format('d M Y') }}
                                @else
                                    <span style="color:#d1d5db;">—</span>
                                @endif
                            </td>

                            <td>
                                <span class="status-badge {{ $peminjaman->status }}">
                                    {{ $peminjaman->statusLabel }}
                                </span>
                            </td>

                            <td>
                                @if ($peminjaman->status == 'ditolak' && $peminjaman->catatan_admin)
                                    <span class="catatan-text">
                                        {{ Str::limit($peminjaman->catatan_admin, 40) }}
                                    </span>
                                @else
                                    <span style="color:#d1d5db;">—</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('user.peminjaman.detail', $peminjaman->id) }}" class="btn-detail">
                                    👁️ Detail
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- jQuery (skip jika sudah ada di layout) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#riwayatTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, 'Semua']
                ],
                order: [
                    [4, 'desc']
                ], // urutkan by tanggal pinjam terbaru
                language: {
                    search: "🔍 Cari:",
                    searchPlaceholder: "Cari kode, alat, status...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    zeroRecords: "Data tidak ditemukan",
                    emptyTable: "Belum ada riwayat peminjaman",
                    paginate: {
                        previous: "‹ Prev",
                        next: "Next ›"
                    }
                },
                columnDefs: [{
                        targets: [0],
                        width: '40px',
                        orderable: false
                    }, // No
                    {
                        targets: [9],
                        orderable: false,
                        searchable: false
                    }, // Aksi
                    {
                        targets: [3, 6, 7, 8],
                        searchable: false
                    }, // kolom minor
                ],
                drawCallback: function() {
                    // Re-init tooltip sederhana untuk catatan panjang
                    $('[title]').each(function() {
                        var el = $(this);
                        if (!el.data('tt-init')) {
                            el.data('tt-init', true);
                        }
                    });
                }
            });
        });
    </script>
@endpush
