<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - Smart Drawer ATMI</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo {
            font-size: 1.8rem;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.6rem 1.5rem;
            border: 2px solid white;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: white;
            color: #667eea;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            color: #333;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #666;
        }

        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-item {
            flex: 1;
            min-width: 200px;
        }

        .filter-item label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .filter-item select,
        .filter-item input {
            width: 100%;
            padding: 0.7rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .history-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        th {
            padding: 1.2rem;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 1.2rem;
            border-bottom: 1px solid #e0e0e0;
        }

        tbody tr {
            transition: all 0.3s;
        }

        tbody tr:hover {
            background: #f5f7fa;
        }

        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-dipinjam {
            background: #fff3cd;
            color: #856404;
        }

        .status-dikembalikan {
            background: #d4edda;
            color: #155724;
        }

        .status-terlambat {
            background: #f8d7da;
            color: #721c24;
        }

        .tool-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .tool-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .tool-details strong {
            display: block;
            color: #333;
            margin-bottom: 0.2rem;
        }

        .tool-details small {
            color: #666;
        }

        @media (max-width: 768px) {
            .history-table {
                overflow-x: auto;
            }
            
            table {
                min-width: 800px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <div class="logo">📦</div>
            <div>
                <h2>Smart Drawer ATMI</h2>
                <small>Riwayat Peminjaman</small>
            </div>
        </div>
        <div class="navbar-right">
            <a href="{{ route('dashboard') }}" class="btn-back">← Kembali ke Dashboard</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1>📋 Riwayat Peminjaman Alat</h1>
            <p>Lihat semua riwayat peminjaman alat Anda</p>
        </div>

        <div class="filter-section">
            <div class="filter-item">
                <label>Status</label>
                <select>
                    <option>Semua Status</option>
                    <option>Sedang Dipinjam</option>
                    <option>Sudah Dikembalikan</option>
                    <option>Terlambat</option>
                </select>
            </div>
            <div class="filter-item">
                <label>Tanggal Mulai</label>
                <input type="date">
            </div>
            <div class="filter-item">
                <label>Tanggal Akhir</label>
                <input type="date">
            </div>
        </div>

        <div class="history-table">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Alat</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Durasi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <div class="tool-info">
                                <div class="tool-icon">🔧</div>
                                <div class="tool-details">
                                    <strong>Obeng Set Precision</strong>
                                    <small>Kode: OBG-001</small>
                                </div>
                            </div>
                        </td>
                        <td>15 Jan 2026</td>
                        <td>18 Jan 2026</td>
                        <td>3 hari</td>
                        <td><span class="status-badge status-dikembalikan">Dikembalikan</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <div class="tool-info">
                                <div class="tool-icon">⚡</div>
                                <div class="tool-details">
                                    <strong>Multimeter Digital</strong>
                                    <small>Kode: MLT-005</small>
                                </div>
                            </div>
                        </td>
                        <td>20 Jan 2026</td>
                        <td>-</td>
                        <td>6 hari</td>
                        <td><span class="status-badge status-dipinjam">Sedang Dipinjam</span></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            <div class="tool-info">
                                <div class="tool-icon">🔌</div>
                                <div class="tool-details">
                                    <strong>Solder Station 60W</strong>
                                    <small>Kode: SLD-012</small>
                                </div>
                            </div>
                        </td>
                        <td>10 Jan 2026</td>
                        <td>14 Jan 2026</td>
                        <td>4 hari</td>
                        <td><span class="status-badge status-dikembalikan">Dikembalikan</span></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>
                            <div class="tool-info">
                                <div class="tool-icon">📏</div>
                                <div class="tool-details">
                                    <strong>Jangka Sorong Digital</strong>
                                    <small>Kode: JKS-008</small>
                                </div>
                            </div>
                        </td>
                        <td>22 Jan 2026</td>
                        <td>-</td>
                        <td>4 hari</td>
                        <td><span class="status-badge status-dipinjam">Sedang Dipinjam</span></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>
                            <div class="tool-info">
                                <div class="tool-icon">🔩</div>
                                <div class="tool-details">
                                    <strong>Kunci Pas Set</strong>
                                    <small>Kode: KPS-015</small>
                                </div>
                            </div>
                        </td>
                        <td>08 Jan 2026</td>
                        <td>12 Jan 2026</td>
                        <td>4 hari</td>
                        <td><span class="status-badge status-dikembalikan">Dikembalikan</span></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>
                            <div class="tool-info">
                                <div class="tool-icon">🔬</div>
                                <div class="tool-details">
                                    <strong>Mikroskop Digital</strong>
                                    <small>Kode: MKS-003</small>
                                </div>
                            </div>
                        </td>
                        <td>18 Jan 2026</td>
                        <td>-</td>
                        <td>8 hari</td>
                        <td><span class="status-badge status-dipinjam">Sedang Dipinjam</span></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>
                            <div class="tool-info">
                                <div class="tool-icon">🔦</div>
                                <div class="tool-details">
                                    <strong>Lampu Kerja LED</strong>
                                    <small>Kode: LMP-020</small>
                                </div>
                            </div>
                        </td>
                        <td>05 Jan 2026</td>
                        <td>09 Jan 2026</td>
                        <td>4 hari</td>
                        <td><span class="status-badge status-dikembalikan">Dikembalikan</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>