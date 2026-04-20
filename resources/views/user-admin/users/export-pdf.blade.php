<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Data Users</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 5px;
            color: #7c4dff;
            font-size: 16pt;
        }
        
        .info-header {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #e8eaf6;
            border-radius: 5px;
        }
        
        .info-header p {
            margin: 3px 0;
            font-size: 9pt;
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
            background-color: #7c4dff;
            color: white;
            padding: 8px;
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
        }
        
        td {
            padding: 6px;
            font-size: 8pt;
            vertical-align: top;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            background-color: #fff9e6;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .footer-summary {
            margin-top: 15px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        
        .footer-summary p {
            margin: 5px 0;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <h2>DATA USER SISTEM SMART DRAWER ATMI</h2>
    
    <div class="info-header">
        <p><strong>Tanggal Export:</strong> {{ date('d F Y H:i:s') }}</p>
        <p><strong>Dicetak oleh:</strong> {{ auth()->user()->name }} ({{ auth()->user()->getRoleDisplayName() }})</p>
        <p><strong>Total User:</strong> {{ $users->count() }} user terdaftar</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama Lengkap</th>
                <th style="width: 12%;">NIM</th>
                <th style="width: 15%;">Jurusan</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 12%;">No HP</th>
                <th style="width: 8%;">Koin</th>
                <th style="width: 13%;">Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td class="text-center">{{ $user->nim ?? '-' }}</td>
                <td>{{ $user->jurusan ?? '-' }}</td>
                <td style="font-size: 7pt;">{{ $user->email }}</td>
                <td class="text-center">{{ $user->no_hp ?? '-' }}</td>
                <td class="text-center">
                    <span class="badge">{{ $user->koin }}</span>
                </td>
                <td class="text-center" style="font-size: 7pt;">
                    {{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 20px; font-style: italic;">
                    Tidak ada data user
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer-summary">
        <p><strong>Ringkasan Data:</strong></p>
        <p>• Total User Terdaftar: <strong>{{ $users->count() }}</strong> user</p>
        <p>• Total Koin Semua User: <strong>{{ $users->sum('koin') }}</strong> koin</p>
        <p>• User dengan Koin > 0: <strong>{{ $users->where('koin', '>', 0)->count() }}</strong> user</p>
        <p>• User dengan Koin = 0: <strong>{{ $users->where('koin', 0)->count() }}</strong> user</p>
    </div>
    
    <div style="margin-top: 30px; text-align: center; font-size: 8pt; color: #666;">
        <p>Dokumen ini digenerate otomatis oleh Smart Drawer ATMI</p>
        <p>© {{ date('Y') }} Smart Drawer ATMI - All Rights Reserved</p>
    </div>
</body>
</html>