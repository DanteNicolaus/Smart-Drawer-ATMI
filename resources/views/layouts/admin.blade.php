<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Smart Drawer </title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(180deg, #eef2ff 0%, #dbeafe 40%, #e0e7ff 70%, #eef2ff 100%);
            background-attachment: fixed;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .top-navbar {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(199, 210, 254, 0.6);
            padding: 0 30px;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .top-navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid !important;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            height: 70px;
            width: 100%;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.25rem;
            font-weight: 700;
            text-decoration: none;
            color: #1e293b;
            white-space: nowrap;
            flex-shrink: 0;
            justify-self: start;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #dbeafe, #c7d2fe);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .nav-menu {
            display: flex;
            gap: 4px;
            list-style: none;
            margin: 0;
            padding: 0;
            justify-self: center;
        }

        .nav-menu a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            color: #64748b;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            font-weight: 500;
            white-space: nowrap;
            font-size: 0.95rem;
        }

        .nav-menu a:hover { background: #eef2ff; color: #2563eb; }

        .nav-menu a.active {
            background: linear-gradient(135deg, #dbeafe 0%, #c7d2fe 100%);
            color: #1e40af;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
            justify-self: end;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #dbeafe, #c7d2fe);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            color: #1e40af;
            flex-shrink: 0;
        }

        .user-details { display: flex; flex-direction: column; min-width: 0; }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #1e293b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
        }

        .user-role { font-size: 12px; color: #64748b; white-space: nowrap; }

        .logout-btn {
            padding: 8px 16px;
            background: #2563eb;
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            font-weight: 600;
            white-space: nowrap;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #1d4ed8;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: 1.5px solid rgba(99, 102, 241, 0.25);
            border-radius: 8px;
            color: #1e293b;
            cursor: pointer;
            padding: 6px 10px;
            line-height: 1;
            transition: all 0.2s;
        }

        .mobile-menu-btn:hover { background: #eef2ff; border-color: #c7d2fe; }

        .hamburger-icon {
            display: flex;
            flex-direction: column;
            gap: 5px;
            width: 22px;
        }

        .hamburger-icon span {
            display: block;
            height: 2px;
            background: #1e40af;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn.is-active .hamburger-icon span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .mobile-menu-btn.is-active .hamburger-icon span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .mobile-menu-btn.is-active .hamburger-icon span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        main { min-height: calc(100vh - 140px); width: 100%; }

        footer {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            border-top: 1px solid rgba(199, 210, 254, 0.6);
            color: #6b7280;
            text-align: center;
            padding: 1.5rem;
            margin-top: 50px;
        }

        footer p { margin: 0; font-size: 14px; }

        .alert-success-bar {
            background: #dcfce7;
            color: #166534;
            padding: 15px 20px;
            border-radius: 10px;
            border-left: 4px solid #22c55e;
            margin: 20px auto;
            max-width: 1400px;
        }

        .alert-error-bar {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px 20px;
            border-radius: 10px;
            border-left: 4px solid #ef4444;
            margin: 20px auto;
            max-width: 1400px;
        }

        .nav-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.45);
            z-index: 999;
            backdrop-filter: blur(2px);
        }

        .nav-overlay.active { display: block; }

        @media (max-width: 1024px) {
            .top-navbar { padding: 0 20px; }
            .nav-menu a { padding: 10px 13px; font-size: 14px; }
            .logo { font-size: 1.1rem; }
            .logo-icon { width: 38px; height: 38px; font-size: 1.1rem; }
            .user-details { display: none; }
        }

        @media (max-width: 768px) {
            .top-navbar { padding: 0 16px; }
            .top-navbar-container { height: 62px; }
            .logo { font-size: 1rem; gap: 8px; }
            .logo-icon { width: 36px; height: 36px; font-size: 1rem; }

            .nav-menu {
                position: fixed;
                top: 0; left: -100%;
                width: 280px;
                height: 100vh;
                background: #ffffff;
                flex-direction: column;
                padding: 0;
                transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 4px 0 24px rgba(99, 102, 241, 0.12);
                z-index: 1000;
                gap: 0;
                overflow-y: auto;
            }

            .nav-menu.active { left: 0; }

            .nav-menu::before {
                content: '';
                display: block;
                height: 72px;
                background: linear-gradient(135deg, #dbeafe 0%, #c7d2fe 100%);
                flex-shrink: 0;
            }

            .nav-menu li { width: 100%; padding: 4px 12px; }
            .nav-menu li:first-child { padding-top: 16px; }

            .nav-menu a {
                width: 100%;
                padding: 14px 18px;
                border-radius: 12px;
                font-size: 15px;
                font-weight: 500;
                color: #374151;
                justify-content: flex-start;
            }

            .nav-menu a.active {
                background: linear-gradient(135deg, #dbeafe 0%, #c7d2fe 100%);
                color: #1e40af;
                font-weight: 600;
            }

            .mobile-menu-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .user-info { gap: 10px; }
            .logout-btn { padding: 7px 12px; font-size: 13px; }
            .user-avatar { width: 36px; height: 36px; font-size: 14px; }

            .alert-success-bar,
            .alert-error-bar { padding: 12px 15px; font-size: 14px; margin: 15px 16px; }
        }

        @media (max-width: 480px) {
            .top-navbar { padding: 0 12px; }
            .top-navbar-container { height: 58px; }
            .nav-menu { width: 260px; }
            .logo span:last-child { display: none; }
            .user-avatar { width: 34px; height: 34px; font-size: 13px; }
            .logout-btn { padding: 6px 10px; font-size: 12px; }
            footer p { font-size: 12px; }
            .alert-success-bar, .alert-error-bar { margin: 12px; font-size: 13px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <div class="nav-overlay" id="navOverlay" onclick="closeMenu()"></div>

    <nav class="top-navbar">
        <div class="top-navbar-container">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <div class="logo-icon">📦</div>
                <span>Smart Drawer </span>
            </a>

            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    🏠 Dashboard
                </a></li>
                <li><a href="{{ route('admin.alat.index') }}" class="{{ request()->routeIs('admin.alat.*') ? 'active' : '' }}">
                    📦 Daftar Alat
                </a></li>
                <li><a href="{{ route('admin.peminjaman.index') }}" class="{{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                    📋 Peminjaman
                </a></li>
            </ul>

            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-details">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Administrator</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;" id="navbar-logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
                <button class="mobile-menu-btn" id="menuBtn" onclick="toggleMenu()" aria-label="Toggle Menu">
                    <div class="hamburger-icon">
                        <span></span><span></span><span></span>
                    </div>
                </button>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
        <div style="padding: 0 16px;">
            <div class="alert-success-bar">✅ {{ session('success') }}</div>
        </div>
        @endif

        @if(session('error'))
        <div style="padding: 0 16px;">
            <div class="alert-error-bar">❌ {{ session('error') }}</div>
        </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>&copy; 2025 Smart Drawer ATMI. Politeknik ATMI Surakarta. All rights reserved.</p>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            const menuBtn = document.getElementById('menuBtn');
            const overlay = document.getElementById('navOverlay');
            const isOpen  = navMenu.classList.contains('active');
            if (isOpen) { closeMenu(); } else {
                navMenu.classList.add('active');
                menuBtn.classList.add('is-active');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeMenu() {
            document.getElementById('navMenu').classList.remove('active');
            document.getElementById('menuBtn').classList.remove('is-active');
            document.getElementById('navOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        document.querySelectorAll('.nav-menu a').forEach(link => link.addEventListener('click', closeMenu));
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenu(); });

        setTimeout(function () {
            document.querySelectorAll('.alert-success-bar, .alert-error-bar').forEach(function (el) {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(function () { el.remove(); }, 500);
            });
        }, 5000);
    </script>

    @stack('scripts')

    {{-- ===== SESSION TIMEOUT ===== --}}
    <script>
        window.sessionLifetime = {{ config('session.lifetime') }};
    </script>

    {{-- Modal muncul saat session habis --}}
<div id="sessionExpiredModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; padding:40px 30px; max-width:380px; width:90%; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="font-size:56px; margin-bottom:15px;">🔒</div>
        <h4 style="color:#721c24; margin:0 0 10px; font-size:20px;">SESSION TIMEOUT</h4>
        <p style="color:#555; margin:0 0 20px; font-size:14px; line-height:1.5;">
            <br>Click the OK button to log back in..
        </p>
        <button
            onclick="redirectToLogin()"
            style="
                width: 100%;
                padding: 13px 20px;
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 15px;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
                letter-spacing: 0.3px;
            "
            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(37,99,235,0.45)'"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(37,99,235,0.35)'"
        >
             OK, Back to Login Page
        </button>
    </div>
</div>

    <script src="{{ asset('js/session-timeout.js') }}"></script>
    {{-- ===== END SESSION TIMEOUT ===== --}}

</body>
</html>