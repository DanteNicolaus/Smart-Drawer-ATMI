<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alat - Smart Drawer ATMI</title>
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

        .search-section {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 2;
            min-width: 250px;
        }

        .search-box input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
        }

        .filter-box {
            flex: 1;
            min-width: 200px;
        }

        .filter-box select {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
        }

        .tools-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .tool-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .tool-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .tool-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .tool-icon-large {
            width: 100%;
            height: 150px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e0e5ec 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .tool-header {
            margin-bottom: 1rem;
        }

        .tool-header h3 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .tool-code {
            color: #666;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .tool-info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .tool-info-item:last-child {
            border-bottom: none;
        }

        .tool-info-label {
            color: #666;
            font-size: 0.9rem;
        }

        .tool-info-value {
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .status-available {
            color: #28a745;
        }

        .status-borrowed {
            color: #dc3545;
        }

        .btn-borrow {
            width: 100%;
            padding: 0.8rem;
            margin-top: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-borrow:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-borrow:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .tools-grid {
                grid-template-columns: 1fr;
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
                <small>Daftar Alat</small>
            </div>
        </div>
        <div class="navbar-right">
            <a href="{{ route('dashboard') }}" class="btn-back">← Kembali ke Dashboard</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1>🔧 Daftar Alat Laboratorium</h1>
            <p>Jelajahi berbagai alat yang tersedia untuk dipinjam</p>
        </div>

        <div class="search-section">
            <div class="search-box">
                <input type="text" placeholder="🔍 Cari alat...">
            </div>
            <div class="filter-box">
                <select>
                    <option>Semua Kategori</option>
                    <option>Elektronik</option>
                    <option>Mekanik</option>
                    <option>Pengukuran</option>
                    <option>Kelistrikan</option>
                </select>
            </div>
            <div class="filter-box">
                <select>
                    <option>Semua Status</option>
                    <option>Tersedia</option>
                    <option>Dipinjam</option>
                </select>
            </div>
        </div>

        <div class="tools-grid">
            <div class="tool-card">
                <div class="tool-icon-large">🔧</div>
                <div class="tool-header">
                    <h3>Obeng Set Precision</h3>
                    <span class="tool-code">Kode: OBG-001</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kategori</span>
                    <span class="tool-info-value">Mekanik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kondisi</span>
                    <span class="tool-info-value">Baik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Status</span>
                    <span class="tool-info-value status-available">✓ Tersedia</span>
                </div>
                <button class="btn-borrow">Pinjam Alat</button>
            </div>

            <div class="tool-card">
                <div class="tool-icon-large">⚡</div>
                <div class="tool-header">
                    <h3>Multimeter Digital</h3>
                    <span class="tool-code">Kode: MLT-005</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kategori</span>
                    <span class="tool-info-value">Kelistrikan</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kondisi</span>
                    <span class="tool-info-value">Baik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Status</span>
                    <span class="tool-info-value status-borrowed">✗ Dipinjam</span>
                </div>
                <button class="btn-borrow" disabled>Tidak Tersedia</button>
            </div>

            <div class="tool-card">
                <div class="tool-icon-large">🔌</div>
                <div class="tool-header">
                    <h3>Solder Station 60W</h3>
                    <span class="tool-code">Kode: SLD-012</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kategori</span>
                    <span class="tool-info-value">Elektronik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kondisi</span>
                    <span class="tool-info-value">Baik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Status</span>
                    <span class="tool-info-value status-available">✓ Tersedia</span>
                </div>
                <button class="btn-borrow">Pinjam Alat</button>
            </div>

            <div class="tool-card">
                <div class="tool-icon-large">📏</div>
                <div class="tool-header">
                    <h3>Jangka Sorong Digital</h3>
                    <span class="tool-code">Kode: JKS-008</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kategori</span>
                    <span class="tool-info-value">Pengukuran</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kondisi</span>
                    <span class="tool-info-value">Baik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Status</span>
                    <span class="tool-info-value status-borrowed">✗ Dipinjam</span>
                </div>
                <button class="btn-borrow" disabled>Tidak Tersedia</button>
            </div>

            <div class="tool-card">
                <div class="tool-icon-large">🔩</div>
                <div class="tool-header">
                    <h3>Kunci Pas Set</h3>
                    <span class="tool-code">Kode: KPS-015</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kategori</span>
                    <span class="tool-info-value">Mekanik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kondisi</span>
                    <span class="tool-info-value">Baik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Status</span>
                    <span class="tool-info-value status-available">✓ Tersedia</span>
                </div>
                <button class="btn-borrow">Pinjam Alat</button>
            </div>

            <div class="tool-card">
                <div class="tool-icon-large">🔬</div>
                <div class="tool-header">
                    <h3>Mikroskop Digital</h3>
                    <span class="tool-code">Kode: MKS-003</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kategori</span>
                    <span class="tool-info-value">Pengukuran</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kondisi</span>
                    <span class="tool-info-value">Baik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Status</span>
                    <span class="tool-info-value status-borrowed">✗ Dipinjam</span>
                </div>
                <button class="btn-borrow" disabled>Tidak Tersedia</button>
            </div>

            <div class="tool-card">
                <div class="tool-icon-large">🔦</div>
                <div class="tool-header">
                    <h3>Lampu Kerja LED</h3>
                    <span class="tool-code">Kode: LMP-020</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kategori</span>
                    <span class="tool-info-value">Elektronik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kondisi</span>
                    <span class="tool-info-value">Baik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Status</span>
                    <span class="tool-info-value status-available">✓ Tersedia</span>
                </div>
                <button class="btn-borrow">Pinjam Alat</button>
            </div>

            <div class="tool-card">
                <div class="tool-icon-large">🔋</div>
                <div class="tool-header">
                    <h3>Power Supply Adjustable</h3>
                    <span class="tool-code">Kode: PWR-018</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kategori</span>
                    <span class="tool-info-value">Elektronik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Kondisi</span>
                    <span class="tool-info-value">Baik</span>
                </div>
                <div class="tool-info-item">
                    <span class="tool-info-label">Status</span>
                    <span class="tool-info-value status-available">✓ Tersedia</span>
                </div>
                <button class="btn-borrow">Pinjam Alat</button>
            </div>
        </div>
    </div>
</body>
</html>