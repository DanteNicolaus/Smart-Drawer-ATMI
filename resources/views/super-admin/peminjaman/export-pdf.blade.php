<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Riwayat Peminjaman Alat Laboratorium - Politeknik ATMI Surakarta</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        @page {
            size: A4 landscape;
            margin: 15mm;
        }
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .no-print {
                display: none !important;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #000;
            background: #fff;
            padding: 20px;
        }
        
        /* Header Kop Surat */
        .header-kop {
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .header-kop table {
            width: 100%;
            border: none;
        }
        
        .header-logo {
            width: 80px;
            text-align: center;
            vertical-align: top;
        }
        
        .header-logo img {
            width: 70px;
            height: 70px;
        }
        
        .header-text {
            text-align: center;
            vertical-align: middle;
        }
        
        .header-text h1 {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
            color: #003366;
        }
        
        .header-text p {
            font-size: 9pt;
            margin: 2px 0;
            line-height: 1.3;
        }
        
        /* Title Section */
        .title-section {
            text-align: center;
            margin: 25px 0 20px;
        }
        
        .title-section h2 {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 8px;
        }
        
        .title-section p {
            font-size: 10pt;
            margin: 3px 0;
        }
        
        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 9pt;
        }
        
        .data-table thead th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
            padding: 10px 6px;
            text-align: center;
            border: 1px solid #000;
            vertical-align: middle;
        }
        
        .data-table tbody td {
            padding: 8px 6px;
            border: 1px solid #000;
            vertical-align: middle;
        }
        
        .data-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-left {
            text-align: left;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
            text-align: center;
        }
        
        .status-pending {
            background-color: #FFC107;
            color: #000;
        }
        
        .status-disetujui {
            background-color: #17A2B8;
            color: white;
        }
        
        .status-ditolak {
            background-color: #DC3545;
            color: white;
        }
        
        .status-dipinjam {
            background-color: #007BFF;
            color: white;
        }
        
        .status-dikembalikan {
            background-color: #28A745;
            color: white;
        }
        
        /* Footer Signature */
        .signature-section {
            margin-top: 40px;
        }
        
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        
        .signature-box p {
            margin: 5px 0;
        }
        
        .signature-space {
            height: 60px;
        }
        
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
        
        /* Print Button */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background-color: #DC3545;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 12pt;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        
        .print-button:hover {
            background-color: #c82333;
        }
        
        .small-text {
            font-size: 8pt;
            color: #666;
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button class="print-button no-print" onclick="window.print()">
        🖨️ Cetak / Save as PDF
    </button>
    
    <!-- Header Kop Kampus -->
    <div class="header-kop">
        <table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="header-logo">
                    <!-- Logo ATMI - Ganti dengan path logo Anda -->
                    <img src="{{ asset('assets/logo-atmi.png') }}" alt="Logo ATMI" 
                         onerror="this.style.display='none'">
                </td>
                <td class="header-text">
                    <h1>POLITEKNIK ATMI SURAKARTA</h1>
                    <p>Kampus : Jl. Adi Sucipto No.KM 9.5, Blukukan Dua, Blulukan, Kec. Colomadu, Kabupaten Karanganyar, 57174</p>
                    <p>E-mail: politeknik@atmi.ac.id </p>
                    <p><strong>Jawa Tengah, Indonesia</strong></p>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Title Section -->
    <div class="title-section">
        <h2>LAPORAN RIWAYAT PEMINJAMAN ALAT LABORATORIUM</h2>
        <p>Tanggal Cetak: {{ $tanggal }}</p>
        <p>Total Peminjaman: {{ $peminjaman->count() }} data</p>
    </div>
    
    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 11%;">Kode Peminjaman</th>
                <th style="width: 16%;">Peminjam</th>
                <th style="width: 16%;">Alat</th>
                <th style="width: 7%;">Jumlah</th>
                <th style="width: 10%;">Tgl Pinjam</th>
                <th style="width: 10%;">Tgl Kembali</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 6%;">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    <strong>{{ $p->kode_peminjaman }}</strong>
                </td>
                <td class="text-left">
                    {{ $p->user->name }}<br>
                    <span class="small-text">NIM: {{ $p->user->nim ?? '-' }}</span>
                </td>
                <td class="text-left">
                    {{ $p->alat->nama_alat }}<br>
                    <span class="small-text">{{ $p->alat->kode_alat }}</span>
                </td>
                <td class="text-center">{{ $p->jumlah_pinjam }} unit</td>
                <td class="text-center">
                    {{ $p->tanggal_pinjam->format('d/m/Y') }}
                </td>
                <td class="text-center">
                    {{ $p->tanggal_kembali_rencana->format('d/m/Y') }}
                </td>
                <td class="text-center">
                    {{ $p->tanggal_kembali_aktual ? $p->tanggal_kembali_aktual->format('d/m/Y') : '-' }}
                </td>
                <td class="text-center">
                    @php
                        $statusClass = 'status-' . $p->status;
                        $statusLabel = [
                            'pending' => 'Pending',
                            'disetujui' => 'Disetujui',
                            'ditolak' => 'Ditolak',
                            'dipinjam' => 'Sedang Dipinjam',
                            'dikembalikan' => 'Dikembalikan'
                        ][$p->status] ?? $p->status;
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                </td>
                <td class="text-center">
                    @if($p->kondisi_saat_kembali)
                        {{ str_replace('_', ' ', ucfirst($p->kondisi_saat_kembali)) }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center" style="padding: 20px;">
                    Tidak ada data peminjaman
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Signature Section -->
    <div class="signature-section clearfix">
        <div class="signature-box">
            <p>Surakarta, {{ $tanggal }}</p>
            <p>Penanggung Jawab Laboratorium</p>
            <div class="signature-space"></div>
            <p class="signature-name">(_____________________)</p>
        </div>
    </div>
    
    <script>
        // Auto print ketika halaman dimuat (optional - uncomment jika ingin auto print)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // }
        
        // Informasi setelah print
        window.onafterprint = function() {
            console.log('Print selesai atau dibatalkan');
        }
    </script>
</body>
</html>