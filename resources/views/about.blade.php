<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - Smart Drawer ATMI</title>
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

        .nav-links a:hover,
        .nav-links a.active {
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

        .hero {
            text-align: center;
            padding: 3rem 2rem 2rem;
            color: white;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: fadeInDown 1s;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            animation: fadeInUp 1s;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .about-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s;
        }

        .about-section h2 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .about-section p {
            color: #666;
            line-height: 1.8;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .info-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #e0e5ec 100%);
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .info-card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .info-card h3 {
            color: #333;
            margin-bottom: 0.5rem;
        }

        .info-card p {
            color: #666;
            font-size: 0.95rem;
        }

        .team-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .team-section h2 {
            color: #333;
            margin-bottom: 2rem;
            text-align: center;
            font-size: 2rem;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .team-card {
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #e0e5ec 100%);
            border-radius: 15px;
            transition: all 0.3s;
        }

        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .team-avatar {
            width: 100px;
            height: 100px;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .team-card h3 {
            color: #333;
            margin-bottom: 0.3rem;
        }

        .team-card p {
            color: #666;
            font-size: 0.9rem;
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
            
            .about-section {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <div class="logo-icon">📦</div>
            <span>Smart Drawer ATMI</span>
        </div>
        <div class="nav-links">
            <a href="{{ route('welcome') }}">Beranda</a>
            <a href="{{ route('tentang') }}" class="active">Tentang</a>
            <a href="{{ route('kontak') }}">Kontak</a>
            <a href="{{ route('login') }}" class="btn-login">Login</a>
        </div>
    </nav>

    <section class="hero">
        <h1>Tentang Smart Drawer ATMI</h1>
        <p>Mengenal lebih dekat sistem peminjaman alat kami</p>
    </section>

    <div class="container">
        <div class="about-section">
            <h2>📖 Tentang Sistem</h2>
            <p>
                Smart Drawer ATMI adalah sistem manajemen peminjaman alat laboratorium yang dikembangkan khusus untuk Politeknik ATMI Surakarta. Sistem ini dirancang untuk memudahkan mahasiswa dan dosen dalam mengelola peminjaman peralatan praktikum dengan cara yang efisien dan terorganisir.
            </p>
            <p>
                Dengan menggunakan teknologi web modern, Smart Drawer ATMI menyediakan antarmuka yang intuitif dan mudah digunakan, memungkinkan pengguna untuk melihat ketersediaan alat, mengajukan peminjaman, dan melacak riwayat penggunaan alat secara real-time.
            </p>

            <div class="info-grid">
                <div class="info-card">
                    <div class="info-card-icon">🎯</div>
                    <h3>Misi Kami</h3>
                    <p>Menyediakan sistem peminjaman alat yang efisien dan mudah diakses untuk mendukung proses pembelajaran</p>
                </div>
                <div class="info-card">
                    <div class="info-card-icon">👁️</div>
                    <h3>Visi Kami</h3>
                    <p>Menjadi sistem manajemen laboratorium terdepan yang mendukung ekosistem pendidikan teknik</p>
                </div>
                <div class="info-card">
                    <div class="info-card-icon">💡</div>
                    <h3>Inovasi</h3>
                    <p>Terus berinovasi untuk memberikan pengalaman terbaik dalam pengelolaan aset laboratorium</p>
                </div>
            </div>
        </div>

        <div class="about-section">
            <h2>🏫 Politeknik ATMI Surakarta</h2>
            <p>
                Politeknik ATMI Surakarta merupakan institusi pendidikan vokasi yang berfokus pada bidang teknik manufaktur dan mekatronika. Dengan fasilitas laboratorium yang lengkap dan modern, ATMI berkomitmen untuk menghasilkan lulusan yang kompeten dan siap kerja di industri.
            </p>
            <p>
                Smart Drawer ATMI hadir sebagai bagian dari upaya digitalisasi kampus untuk meningkatkan efisiensi operasional dan memberikan pengalaman belajar yang lebih baik bagi seluruh civitas akademika.
            </p>
        </div>

        <div class="team-section">
            <h2>👥 Tim Pengembang</h2>
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar">👨‍💻</div>
                    <h3>Tim Developer</h3>
                    <p>Pengembang Sistem</p>
                </div>
                <div class="team-card">
                    <div class="team-avatar">👨‍🔬</div>
                    <h3>Tim Laboratorium</h3>
                    <p>Pengelola Aset</p>
                </div>
                <div class="team-card">
                    <div class="team-avatar">👨‍🏫</div>
                    <h3>Tim Akademik</h3>
                    <p>Supervisor Sistem</p>
                </div>
                <div class="team-card">
                    <div class="team-avatar">🎓</div>
                    <h3>Mahasiswa ATMI</h3>
                    <p>Pengguna Sistem</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>