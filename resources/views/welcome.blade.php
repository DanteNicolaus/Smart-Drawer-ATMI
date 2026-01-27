<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Drawer ATMI - Beranda</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .btn-login {
            background: white;
            color: #667eea;
            padding: 0.7rem 2rem;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Success Message Styling */
        .success-banner {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            color: #333;
            padding: 1.2rem 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideDown 0.5s ease-out, fadeOut 0.5s ease-in 4.5s;
            min-width: 400px;
        }

        .success-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .success-content {
            flex: 1;
        }

        .success-content strong {
            display: block;
            margin-bottom: 0.3rem;
            color: #43e97b;
            font-size: 1rem;
        }

        .success-content p {
            margin: 0;
            color: #666;
            font-size: 0.95rem;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translate(-50%, -100px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                transform: translate(-50%, -30px);
            }
        }

        .hero {
            text-align: center;
            padding: 4rem 2rem;
            color: white;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            animation: fadeInDown 1s;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeInUp 1s;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem 4rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            animation: fadeIn 1s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .features {
                padding: 2rem 1rem;
            }

            .nav-links {
                flex-wrap: wrap;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    @if(session('logout_success'))
    <div class="success-banner" id="successBanner">
        <div class="success-icon">✓</div>
        <div class="success-content">
            <strong>Logout Berhasil!</strong>
            <p>{{ session('logout_success') }}</p>
        </div>
    </div>
    @endif

    <nav class="navbar">
        <div class="logo">
            <div class="logo-icon">📦</div>
            <span>Smart Drawer ATMI</span>
        </div>
        <div class="nav-links">
            <a href="/">Beranda</a>
            <a href="#">Tentang</a>
            <a href="#">Kontak</a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-login">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-login">Login</a>
            @endauth
        </div>
    </nav>

    <section class="hero">
        <h1>🎓 Sistem Peminjaman Alat</h1>
        <p>Politeknik ATMI Surakarta</p>
        <p>Kelola peminjaman alat laboratorium dengan mudah dan efisien</p>
    </section>

    <section class="features">
        <div class="feature-card">
            <div class="feature-icon">🔧</div>
            <h3>Berbagai Alat Tersedia</h3>
            <p>Akses ke berbagai alat laboratorium dan peralatan praktikum yang lengkap untuk mendukung pembelajaran Anda.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">📋</div>
            <h3>Riwayat Peminjaman</h3>
            <p>Pantau riwayat peminjaman Anda secara real-time dengan data lengkap dan terorganisir dengan baik.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">⚡</div>
            <h3>Proses Cepat</h3>
            <p>Sistem peminjaman yang cepat dan mudah, hemat waktu Anda untuk fokus pada pembelajaran.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">🔒</div>
            <h3>Aman & Terpercaya</h3>
            <p>Sistem keamanan terjamin dengan tracking lengkap untuk setiap transaksi peminjaman alat.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">📱</div>
            <h3>Responsive Design</h3>
            <p>Akses dari mana saja menggunakan perangkat apapun, smartphone, tablet, atau komputer.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">👥</div>
            <h3>User Friendly</h3>
            <p>Antarmuka yang intuitif dan mudah digunakan, bahkan untuk pengguna pertama kali.</p>
        </div>
    </section>

    <script>
        // Auto-hide success banner after 5 seconds
        const successBanner = document.getElementById('successBanner');
        if (successBanner) {
            setTimeout(() => {
                successBanner.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>