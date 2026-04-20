<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Riwayat Peminjaman</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9pt;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 5px;
            color: #4472C4;
            font-size: 16pt;
        }
        
        .info-header {
            text-align: center;
            margin-bottom: 15px;
            padding: 8px;
            background-color: #e8eaf6;
            border-radius: 5px;
        }
        
        .info-header p {
            margin: 2px 0;
            font-size: 8pt;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        table, th, td {
            border: 1px solid #000;
        }
        
        th {
            background-color: #4472C4;
            color: white;
            padding: 6px 4px;
            text-align: center;
            font-size: 8pt;
            font-weight: bold;
        }
        
        td {
            padding: 5px 4px;
            font-size: 7pt;
            vertical-align: top;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 7pt;
        }
        
        .badge-warning {
            background-color: #FFF3CD;
            color: #856404;
        }
        
        .badge-info {
            background-color: #D1ECF1;
            color: #0c5460;
        }
        
        .badge-danger {
            background-color: #F8D7DA;
            color: #721c24;
        }
        
        .badge-primary {
            background-color: #CCE5FF;
            color: #004085;
        }
        
        .badge-success {
            background-color: #D4EDDA;
            color: #155724;
        }
        
        .footer-summary {
            margin-top: 15px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        
        .footer-summary table {
            border: none;
            margin-top: 5px;
        }
        
        .footer-summary td {
            border: none;
            padding: 3px 0;
            font-size: 8pt;
        }
    </style>
</head>
<body>
    <h2>LAPORAN RIWAYAT PEMINJAMAN ALAT LABORATORIUM</h2>
    
    <div class="info-header">
        <p><strong>Tanggal Export:</strong> {{ date('d F Y H:i:s') }}</p>
        <p><strong>Dicetak oleh:</strong> {{ auth()->user()->name }} ({{ auth()->user()->getRoleDisplayName() }})</p>
        <p><strong>Total Peminjaman:</strong> {{ $peminjaman->count() }} peminjaman</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 8%;">Kode</th>
                <th style="width: 12%;">Peminjam</th>
                <th style="width: 7%;">NIM</th>
                <th style="width: 12%;">Alat</th>
                <th style="width: 8%;">Kategori</th>
                <th style="width: 5%;">Jml</th>
                <th style="width: 8%;">Tgl Pinjam</th>
                <th style="width: 8%;">Tgl Kembali</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 13%;">Keperluan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td style="font-size: 6pt;">{{ $p->kode_peminjaman }}</td>
                <td>{{ $p->user->name ?? '-' }}</td>
                <td class="text-center">{{ $p->user->nim ?? '-' }}</td>
                <td>{{ $p->alat->nama_alat ?? '-' }}</td>
                <td>{{ $p->alat->kategori ?? '-' }}</td>
                <td class="text-center">{{ $p->jumlah_pinjam }}</td>
                <td class="text-center" style="font-size: 6pt;">
                    {{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d-m-Y') : '-' }}
                </td>
                <td class="text-center" style="font-size: 6pt;">
                    {{ $p->tanggal_kembali_rencana ? $p->tanggal_kembali_rencana->format('d-m-Y') : '-' }}
                </td>
                <td class="text-center" style="font-size: 6pt;">
                    {{ $p->tanggal_kembali_aktual ? $p->tanggal_kembali_aktual->format('d-m-Y') : '-' }}
                </td>
                <td class="text-center">
                    @if($p->status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($p->status == 'disetujui')
                        <span class="badge badge-info">Disetujui</span>
                    @elseif($p->status == 'ditolak')
                        <span class="badge badge-danger">Ditolak</span>
                    @elseif($p->status == 'dipinjam')
                        <span class="badge badge-primary">Dipinjam</span>
                    @elseif($p->status == 'dikembalikan')
                        <span class="badge badge-success">Kembali</span>
                    @endif
                </td>
                <td style="font-size: 6pt;">{{ Str::limit($p->keperluan, 50) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="12" class="text-center" style="padding: 20px; font-style: italic;">
                    Tidak ada data peminjaman
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer-summary">
        <p style="font-weight: bold; margin-bottom: 5px; font-size: 9pt;">Ringkasan Data:</p>
        <table>
            <tr>
                <td style="width: 40%;"><strong>Total Peminjaman:</strong></td>
                <td><strong>{{ $peminjaman->count() }}</strong> peminjaman</td>
            </tr>
            <tr>
                <td><strong>Status Pending:</strong></td>
                <td>{{ $peminjaman->where('status', 'pending')->count() }} peminjaman</td>
            </tr>
            <tr>
                <td><strong>Status Disetujui:</strong></td>
                <td>{{ $peminjaman->where('status', 'disetujui')->count() }} peminjaman</td>
            </tr>
            <tr>
                <td><strong>Status Ditolak:</strong></td>
                <td>{{ $peminjaman->where('status', 'ditolak')->count() }} peminjaman</td>
            </tr>
            <tr>
                <td><strong>Sedang Dipinjam:</strong></td>
                <td>{{ $peminjaman->where('status', 'dipinjam')->count() }} peminjaman</td>
            </tr>
            <tr>
                <td><strong>Sudah Dikembalikan:</strong></td>
                <td>{{ $peminjaman->where('status', 'dikembalikan')->count() }} peminjaman</td>
            </tr>
            <tr style="background-color: #FFF3CD;">
                <td><strong>Peminjaman Aktif:</strong></td>
                <td><strong>{{ $peminjaman->whereIn('status', ['pending', 'disetujui', 'dipinjam'])->count() }}</strong> peminjaman</td>
            </tr>
        </table>
    </div>
    
    <div style="margin-top: 30px; text-align: center; font-size: 7pt; color: #666;">
        <p>Dokumen ini digenerate otomatis oleh Smart Drawer ATMI</p>
        <p>© {{ date('Y') }} Smart Drawer ATMI - All Rights Reserved</p>
    </div>
</body>
</html>