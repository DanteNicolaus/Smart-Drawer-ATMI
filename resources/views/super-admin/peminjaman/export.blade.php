<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Riwayat Peminjaman</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
            padding: 10px;
            text-align: center;
            border: 1px solid #000;
            font-size: 11pt;
        }
        td {
            padding: 8px;
            border: 1px solid #000;
            font-size: 10pt;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">RIWAYAT PEMINJAMAN ALAT LABORATORIUM</h2>
    <p style="text-align: center;">Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Peminjaman</th>
                <th>Nama Peminjam</th>
                <th>NIM</th>
                <th>Kode Alat</th>
                <th>Nama Alat</th>
                <th>Jumlah Pinjam</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Keperluan</th>
                <th>Catatan Admin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->kode_peminjaman }}</td>
                <td>{{ $p->user->name ?? '-' }}</td>
                <td>{{ $p->user->nim ?? '-' }}</td>
                <td>{{ $p->alat->kode_alat ?? '-' }}</td>
                <td>{{ $p->alat->nama_alat ?? '-' }}</td>
                <td class="text-center">{{ $p->jumlah_pinjam }} unit</td>
                <td class="text-center">{{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d-m-Y') : '-' }}</td>
                <td class="text-center">{{ $p->tanggal_kembali_rencana ? $p->tanggal_kembali_rencana->format('d-m-Y') : '-' }}</td>
                <td class="text-center">{{ $p->tanggal_kembali_aktual ? $p->tanggal_kembali_aktual->format('d-m-Y') : '-' }}</td>
                <td class="text-center">
                    @if($p->status == 'pending') Pending
                    @elseif($p->status == 'disetujui') Disetujui
                    @elseif($p->status == 'ditolak') Ditolak
                    @elseif($p->status == 'dipinjam') Sedang Dipinjam
                    @elseif($p->status == 'dikembalikan') Dikembalikan
                    @endif
                </td>
                <td>{{ $p->keperluan ?? '-' }}</td>
                <td>{{ $p->catatan_admin ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="13" class="text-center">Tidak ada data peminjaman</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <br>
    <p><strong>Total Data: {{ $peminjaman->count() }} peminjaman</strong></p>
</body>
</html>