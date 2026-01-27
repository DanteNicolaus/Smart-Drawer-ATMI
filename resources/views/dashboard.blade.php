<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Smart Drawer ATMI</title>
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

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.6rem 1.5rem;
            border: 2px solid white;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: white;
            color: #667eea;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .dashboard-header {
            margin-bottom: 2rem;
        }

        .dashboard-header h1 {
            color: #333;
            margin-bottom: 0.5rem;
        }

        .dashboard-header p {
            color: #666;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-icon.green {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-icon.purple {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-info h3 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
        }

        .stat-info p {
            color: #666;
            font-size: 0.9rem;
        }

        /* Success Message Styling */
        .success-message {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3);
            animation: slideInDown 0.5s ease-out;
            transition: all 0.5s ease;
        }

        .success-message-icon {
            font-size: 1.5rem;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .menu-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        .menu-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }

        .menu-card h3 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .menu-card p {
            color: #666;
            line-height: 1.6;
        }

        .menu-card .btn-action {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.7rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .menu-card .btn-action:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 1rem;
            }

            .navbar-right {
                width: 100%;
                justify-content: space-between;
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
                <small>Politeknik ATMI Surakarta</small>
            </div>
        </div>
        <div class="navbar-right">
            <div class="user-info">
                <div class="user-avatar">👤</div>
                <div>
                    <strong>{{ Auth::user()->name }}</strong>
                    <p style="font-size: 0.85rem; opacity: 0.9;">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'User' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
        <div class="success-message" id="successMessage">
            <span class="success-message-icon">🎉</span>
            <div>
                <strong>{{ session('success') }}</strong>
            </div>
        </div>
        @endif

        <div class="dashboard-header">
            <h1>Dashboard</h1>
            <p>Selamat datang di sistem peminjaman alat Smart Drawer</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon blue">📋</div>
                <div class="stat-info">
                    <h3>12</h3>
                    <p>Total Peminjaman</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">⏳</div>
                <div class="stat-info">
                    <h3>3</h3>
                    <p>Sedang Dipinjam</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">✅</div>
                <div class="stat-info">
                    <h3>9</h3>
                    <p>Sudah Dikembalikan</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">🔧</div>
                <div class="stat-info">
                    <h3>45</h3>
                    <p>Alat Tersedia</p>
                </div>
            </div>
        </div>

        <div class="menu-grid">
            <a href="#" class="menu-card">
                <div class="menu-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">📋</div>
                <h3>Riwayat Peminjaman</h3>
                <p>Lihat semua riwayat peminjaman alat Anda dengan data lengkap dan detail</p>
                <span class="btn-action">Lihat Riwayat</span>
            </a>

            <a href="#" class="menu-card">
                <div class="menu-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">🔧</div>
                <h3>Daftar Alat</h3>
                <p>Jelajahi berbagai alat laboratorium yang tersedia untuk dipinjam</p>
                <span class="btn-action">Lihat Alat</span>
            </a>

            <a href="#" class="menu-card">
                <div class="menu-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">➕</div>
                <h3>Pinjam Alat</h3>
                <p>Ajukan peminjaman alat baru dengan proses yang cepat dan mudah</p>
                <span class="btn-action">Pinjam Sekarang</span>
            </a>
        </div>
    </div>

    <script>
        // Auto-hide success message after 5 seconds
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                successMessage.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 500);
            }, 5000);
        }
    </script>
</body>
</html>