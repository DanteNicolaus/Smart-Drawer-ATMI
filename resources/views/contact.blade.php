<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Smart Drawer ATMI</title>
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

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s;
        }

        .contact-info h2 {
            color: #333;
            margin-bottom: 2rem;
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #e0e5ec 100%);
            border-radius: 15px;
            transition: all 0.3s;
        }

        .info-item:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .info-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        .info-content h3 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }

        .info-content p {
            color: #666;
            line-height: 1.6;
        }

        .info-content a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .info-content a:hover {
            color: #764ba2;
        }

        .contact-form {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s;
        }

        .contact-form h2 {
            color: #333;
            margin-bottom: 2rem;
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .map-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .map-section h2 {
            color: #333;
            margin-bottom: 2rem;
            font-size: 2rem;
            text-align: center;
        }

        .map-container {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e0e5ec 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
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
            
            .contact-grid {
                grid-template-columns: 1fr;
            }
            
            .contact-info,
            .contact-form {
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
            <a href="{{ route('tentang') }}">Tentang</a>
            <a href="{{ route('kontak') }}" class="active">Kontak</a>
            <a href="{{ route('login') }}" class="btn-login">Login</a>
        </div>
    </nav>

    <section class="hero">
        <h1>Hubungi Kami</h1>
        <p>Kami siap membantu Anda</p>
    </section>

    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <h2>📞 Informasi Kontak</h2>
                
                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div class="info-content">
                        <h3>Alamat</h3>
                        <p>Jl. Mojo No. 1, Karangasem<br>
                        Laweyan, Surakarta<br>
                        Jawa Tengah 57145</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📧</div>
                    <div class="info-content">
                        <h3>Email</h3>
                        <p><a href="mailto:smartdrawer@atmi.ac.id">smartdrawer@atmi.ac.id</a></p>
                        <p><a href="mailto:lab@atmi.ac.id">lab@atmi.ac.id</a></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📱</div>
                    <div class="info-content">
                        <h3>Telepon</h3>
                        <p><a href="tel:+622716460300">(0271) 714466</a></p>
                        <p>Senin - Jumat: 08.00 - 16.00 WIB</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">🌐</div>
                    <div class="info-content">
                        <h3>Website</h3>
                        <p><a href="https://www.atmi.ac.id" target="_blank">www.atmi.ac.id</a></p>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <h2>✉️ Kirim Pesan</h2>
                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subjek</label>
                        <input type="text" id="subject" name="subject" placeholder="Subjek pesan" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea id="message" name="message" placeholder="Tulis pesan Anda di sini..." required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Kirim Pesan</button>
                </form>
            </div>
        </div>

        <div class="map-section">
            <h2>🗺️ Lokasi Kami</h2>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.0886179394847!2d110.79259931477564!3d-7.565156494551234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a16627c8f2e71%3A0x5b5b5b5b5b5b5b5b!2sPoliteknik%20ATMI%20Surakarta!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid" 
                    width="100%" 
                    height="100%" 
                    style="border:0; border-radius: 15px;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</body>
</html>