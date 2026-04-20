<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Riwayat_Peminjaman_' . date('Y-m-d_His') . '.xls"');
header('Cache-Control: max-age=0');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Riwayat Peminjaman</title>
</head>
<body>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th colspan="11" style="text-align: center; font-size: 14pt; font-weight: bold;color: white;">
                    RIWAYAT PEMINJAMAN ALAT LABORATORIUM
                </th>
            </tr>
            <tr>
                <th colspan="11" style="text-align: center;">
                    Nama: {{ auth()->user()->name }} | NIM: {{ auth()->user()->nim ?? '-' }} | Tanggal Export: {{ date('d F Y H:i:s') }}
                </th>
            </tr>
            <tr style="background-color: #4472C4; color: white; font-weight: bold;">
                <th style="text-align: center;">No</th>
                <th>Kode Peminjaman</th>
                <th>Kode Alat</th>
                <th>Nama Alat</th>
                <th>Kategori Alat</th>
                <th style="text-align: center;">Jumlah Pinjam</th>
                <th style="text-align: center;">Tanggal Pinjam</th>
                <th style="text-align: center;">Tanggal Kembali</th>
                <th style="text-align: center;">Status</th>
                <th>Keperluan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayatPeminjaman as $index => $p)
            <tr style="{{ $index % 2 == 0 ? 'background-color: #F2F2F2;' : '' }}">
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $p->kode_peminjaman }}</td>
                <td>{{ $p->alat->kode_alat ?? '-' }}</td>
                <td>{{ $p->alat->nama_alat ?? '-' }}</td>
                <td>{{ $p->alat->kategori ?? '-' }}</td>
                <td style="text-align: center;">{{ $p->jumlah_pinjam }} unit</td>
                <td style="text-align: center;">{{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d-m-Y') : '-' }}</td>
                <td style="text-align: center;">{{ $p->tanggal_kembali_rencana ? $p->tanggal_kembali_rencana->format('d-m-Y') : '-' }}</td>
                <td style="text-align: center;">{{ $p->tanggal_kembali_aktual ? $p->tanggal_kembali_aktual->format('d-m-Y') : '-' }}</td>
                <td style="text-align: center;">
                    @if($p->status == 'pending')
                        <span style="background-color: #FFF3CD; padding: 3px 8px;">Pending</span>
                    @elseif($p->status == 'disetujui')
                        <span style="background-color: #D1ECF1; padding: 3px 8px;">Disetujui</span>
                    @elseif($p->status == 'ditolak')
                        <span style="background-color: #F8D7DA; padding: 3px 8px;">Ditolak</span>
                    @elseif($p->status == 'dipinjam')
                        <span style="background-color: #D4EDDA; padding: 3px 8px;">Sedang Dipinjam</span>
                    @elseif($p->status == 'dikembalikan')
                        <span style="background-color: #E2E3E5; padding: 3px 8px;">Dikembalikan</span>
                    @endif
                </td>
                <td>{{ $p->keperluan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align: center; padding: 20px; font-style: italic;">
                    Tidak ada data peminjaman
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #E7E6E6; font-weight: bold;">
                <td colspan="11" style="text-align: left; padding: 10px;">
                    Total Data: {{ $riwayatPeminjaman->count() }} peminjaman
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>