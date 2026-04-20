<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Drawer ')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(180deg, #eef2ff 0%, #dbeafe 40%, #e0e7ff 70%, #eef2ff 100%);
            background-attachment: fixed;
            min-height: 100vh;
            overflow-x: hidden;
            color: #333;
        }

        /* Navbar Styles */
        .navbar {
            background: #ffffff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.07);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #2563eb;
            font-size: 1.3rem;
            font-weight: 700;
            text-decoration: none;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .nav-links {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .nav-links a {
            color: #555;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .nav-links a:hover {
            background: #eef2ff;
            color: #2563eb;
        }

        .nav-links a.active {
            background: #eff6ff;
            color: #2563eb;
            font-weight: 600;
        }

        .btn-login {
            background: #2563eb !important;
            color: #ffffff !important;
            padding: 0.55rem 1.5rem !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            transition: all 0.2s !important;
        }

        .btn-login:hover {
            background: #1d4ed8 !important;
            transform: none !important;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35) !important;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #555;
            font-size: 1.8rem;
            cursor: pointer;
            padding: 0.5rem;
        }

        /* Success/Error Message Styling */
        .success-banner, .error-banner {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            color: #333;
            padding: 1.2rem 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideDown 0.5s ease-out, fadeOut 0.5s ease-in 4.5s;
            min-width: 300px;
            max-width: 90%;
            border: 1px solid #e5e7eb;
        }

        .success-icon, .error-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .success-icon { background: #dcfce7; color: #16a34a; }
        .error-icon   { background: #fee2e2; color: #dc2626; }

        .message-content { flex: 1; }

        .message-content strong {
            display: block;
            margin-bottom: 0.2rem;
            font-size: 0.95rem;
        }

        .success-banner .message-content strong { color: #16a34a; }
        .error-banner   .message-content strong { color: #dc2626; }

        .message-content p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translate(-50%, -100px); }
            to   { opacity: 1; transform: translate(-50%, 0); }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to   { opacity: 0; transform: translate(-50%, -30px); }
        }

        /* Main Content */
        main { min-height: calc(100vh - 80px); }

        /* Footer */
        footer {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            border-top: 1px solid rgba(199, 210, 254, 0.6);
            color: #6b7280;
            text-align: center;
            padding: 2rem;
            margin-top: 2rem;
        }

        footer p { margin-bottom: 0.3rem; font-size: 0.9rem; }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar { padding: 1rem; }
            .logo { font-size: 1.1rem; }
            .logo-icon { width: 36px; height: 36px; font-size: 1.1rem; }

            .mobile-menu-toggle { display: block; }

            .nav-links {
                position: fixed;
                top: 64px;
                left: -100%;
                width: 100%;
                background: #ffffff;
                flex-direction: column;
                padding: 1.5rem;
                gap: 0.5rem;
                transition: left 0.3s ease;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            }

            .nav-links.active { left: 0; }

            .nav-links a {
                width: 100%;
                text-align: center;
                padding: 0.8rem;
                font-size: 1rem;
            }

            .btn-login { width: 100%; text-align: center; }

            .success-banner, .error-banner {
                min-width: unset;
                width: 90%;
                padding: 1rem 1.5rem;
            }

            .success-icon, .error-icon { width: 36px; height: 36px; font-size: 1rem; }
            .message-content strong { font-size: 0.85rem; }
            .message-content p      { font-size: 0.82rem; }
        }

        @media (max-width: 480px) {
            .logo span  { font-size: 1rem; }
            .logo-icon  { width: 32px; height: 32px; font-size: 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Success Message -->
    @if(session('success') || session('logout_success'))
    <div class="success-banner" id="messageBanner">
        <div class="success-icon">✓</div>
        <div class="message-content">
            <strong>Berhasil!</strong>
            <p>{{ session('success') ?? session('logout_success') }}</p>
        </div>
    </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
    <div class="error-banner" id="messageBanner">
        <div class="error-icon">✗</div>
        <div class="message-content">
            <strong>Error!</strong>
            <p>{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-icon">📦</div>
            <span>Smart Drawer </span>
        </a>

        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle Menu">☰</button>

        <div class="nav-links" id="navLinks">
            <a href="{{ route('home') }}"    class="{{ request()->routeIs('home')    ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('about') }}"   class="{{ request()->routeIs('about')   ? 'active' : '' }}">Tentang</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a>

            @auth
                <a href="{{ route('dashboard') }}" class="btn-login">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-login">Login</a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Smart Drawer ATMI. Politeknik ATMI Surakarta.</p>
        <p>All rights reserved.</p>
    </footer>

    <script>
        // Auto-hide message banner after 5 seconds
        const messageBanner = document.getElementById('messageBanner');
        if (messageBanner) {
            setTimeout(() => { messageBanner.style.display = 'none'; }, 5000);
        }

        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const navLinks = document.getElementById('navLinks');

        mobileMenuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            mobileMenuToggle.textContent = navLinks.classList.contains('active') ? '✕' : '☰';
        });

        // Close mobile menu when clicking a link
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    navLinks.classList.remove('active');
                    mobileMenuToggle.textContent = '☰';
                }
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navLinks.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                navLinks.classList.remove('active');
                mobileMenuToggle.textContent = '☰';
            }
        });
    </script>
    @stack('scripts')
</body>
</html>