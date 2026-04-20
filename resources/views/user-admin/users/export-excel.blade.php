<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Data_Users_' . date('Y-m-d_His') . '.xls"');
header('Cache-Control: max-age=0');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Data Users</title>
</head>
<body>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th colspan="8" style="text-align: center; font-size: 14pt; font-weight: bold; background-color: #7c4dff; color: white;">
                    DATA USER SISTEM SMART DRAWER ATMI
                </th>
            </tr>
            <tr>
                <th colspan="8" style="text-align: center; background-color: #e8eaf6;">
                    Tanggal Export: {{ date('d F Y H:i:s') }} | Total User: {{ $users->count() }}
                </th>
            </tr>
            <tr style="background-color: #7c4dff; color: white; font-weight: bold;">
                <th style="text-align: center;">No</th>
                <th>Nama Lengkap</th>
                <th>NIM</th>
                <th>Jurusan</th>
                <th>Email</th>
                <th>No HP</th>
                <th style="text-align: center;">Koin</th>
                <th style="text-align: center;">Tanggal Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr style="{{ $index % 2 == 0 ? 'background-color: #F2F2F2;' : '' }}">
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->nim ?? '-' }}</td>
                <td>{{ $user->jurusan ?? '-' }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->no_hp ?? '-' }}</td>
                <td style="text-align: center;">
                    <span style="background-color: #fff9e6; padding: 3px 8px; font-weight: bold;">{{ $user->koin }}</span>
                </td>
                <td style="text-align: center;">{{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px; font-style: italic;">
                    Tidak ada data user
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #E7E6E6; font-weight: bold;">
                <td colspan="6" style="text-align: right; padding: 10px;">
                    Total User:
                </td>
                <td colspan="2" style="text-align: center; padding: 10px;">
                    {{ $users->count() }} user
                </td>
            </tr>
            <tr style="background-color: #fff9e6; font-weight: bold;">
                <td colspan="6" style="text-align: right; padding: 10px;">
                    Total Koin Semua User:
                </td>
                <td colspan="2" style="text-align: center; padding: 10px;">
                    {{ $users->sum('koin') }} koin
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>