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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(180deg, #ecfeff 0%, #cffafe 40%, #a5f3fc 70%, #ecfeff 100%);
            background-attachment: fixed;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Navbar */
        .top-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(165, 243, 252, 0.8);
            padding: 0 30px;
            box-shadow: 0 2px 8px rgba(6, 182, 212, 0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .top-navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
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
            color: #155e75;
            white-space: nowrap;
            justify-self: start;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #cffafe, #a5f3fc);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .logo span:last-child {
            display: inline;
        }

        .nav-menu {
            display: flex;
            gap: 5px;
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
            color: #0e7490;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            font-weight: 500;
            white-space: nowrap;
            font-size: 0.95rem;
        }

        .nav-menu a:hover {
            background: #ecfeff;
            color: #0891b2;
        }

        .nav-menu a.active {
            background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%);
            color: #155e75;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            justify-self: end;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #cffafe, #a5f3fc);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 600;
            color: #155e75;
            flex-shrink: 0;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #155e75;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 12px;
            color: #0e7490;
            white-space: nowrap;
        }

        .logout-btn {
            padding: 8px 16px;
            background: #06b6d4;
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
            background: #0891b2;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
        }

        main {
            min-height: calc(100vh - 140px);
            width: 100%;
        }

        /* Footer */
        footer {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            border-top: 1px solid rgba(165, 243, 252, 0.8);
            color: #0e7490;
            text-align: center;
            padding: 1.5rem;
            margin-top: 50px;
        }

        footer p {
            margin: 0;
            font-size: 14px;
            color: #6b7280;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: #155e75;
            font-size: 28px;
            cursor: pointer;
            padding: 5px;
            line-height: 1;
        }

        /* Alert Styles */
        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 15px 20px;
            border-radius: 10px;
            border-left: 4px solid #22c55e;
            margin: 20px auto;
            max-width: 1400px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px 20px;
            border-radius: 10px;
            border-left: 4px solid #ef4444;
            margin: 20px auto;
            max-width: 1400px;
        }

        /* Tablet Landscape */
        @media (max-width: 1024px) {
            .top-navbar {
                padding: 0 20px;
            }

            .nav-menu a {
                padding: 10px 15px;
                font-size: 14px;
            }

            .logo {
                font-size: 1.15rem;
            }

            .logo-icon {
                width: 38px;
                height: 38px;
                font-size: 1.2rem;
            }
        }

        /* Tablet */
        @media (max-width: 768px) {
            .top-navbar {
                padding: 0 15px;
            }

            .top-navbar-container {
                height: 60px;
            }

            .logo {
                font-size: 1.1rem;
                gap: 8px;
            }

            .logo-icon {
                width: 36px;
                height: 36px;
                font-size: 1.1rem;
            }

            .logo span:last-child {
                display: none;
            }

            .nav-menu {
                position: fixed;
                top: 60px;
                left: -100%;
                width: 100%;
                max-width: 300px;
                height: calc(100vh - 60px);
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(10px);
                flex-direction: column;
                padding: 20px;
                transition: left 0.3s ease-in-out;
                box-shadow: 2px 0 20px rgba(6, 182, 212, 0.15);
                overflow-y: auto;
                gap: 0;
            }

            .nav-menu.active {
                left: 0;
            }

            .nav-menu li {
                width: 100%;
            }

            .nav-menu a {
                width: 100%;
                padding: 15px;
                justify-content: flex-start;
                margin-bottom: 5px;
            }

            .mobile-menu-btn {
                display: block;
            }

            .user-details {
                display: none;
            }

            .user-info {
                gap: 10px;
            }

            .logout-btn {
                padding: 8px 12px;
                font-size: 13px;
            }

            .alert-success,
            .alert-error {
                padding: 12px 15px;
                font-size: 14px;
                margin: 15px 20px;
            }

            footer p {
                font-size: 12px;
            }
        }

        /* Mobile */
        @media (max-width: 480px) {
            .top-navbar {
                padding: 0 10px;
            }

            .top-navbar-container {
                height: 55px;
            }

            .logo {
                font-size: 1rem;
                gap: 6px;
            }

            .logo-icon {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }

            .user-avatar {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }

            .logout-btn {
                padding: 6px 10px;
                font-size: 12px;
            }

            .nav-menu {
                top: 55px;
                height: calc(100vh - 55px);
            }

            .alert-success,
            .alert-error {
                padding: 10px 12px;
                font-size: 13px;
                margin: 12px 15px;
            }

            footer {
                padding: 15px 10px;
            }

            footer p {
                font-size: 11px;
            }
        }

        /* Very Small Mobile */
        @media (max-width: 360px) {
            .logo span:last-child {
                display: none;
            }

            .user-info {
                gap: 5px;
            }

            .logout-btn {
                padding: 6px 8px;
                font-size: 11px;
            }
        }

        /* Landscape Mode */
        @media (max-height: 500px) and (orientation: landscape) {
            .top-navbar-container {
                height: 50px;
            }

            .nav-menu {
                top: 50px;
                height: calc(100vh - 50px);
                padding: 15px;
            }

            .nav-menu a {
                padding: 10px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <nav class="top-navbar">
        <div class="top-navbar-container">
            <a href="{{ route('user-admin.dashboard') }}" class="logo">
                <div class="logo-icon">👥</div>
                <span>Smart Drawer </span>
            </a>

            <button class="mobile-menu-btn" onclick="toggleMenu()" aria-label="Toggle Menu">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('user-admin.dashboard') }}" class="{{ request()->routeIs('user-admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a></li>
                <li><a href="{{ route('user-admin.users.index') }}" class="{{ request()->routeIs('user-admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Kelola User
                </a></li>
            </ul>

            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-details">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">User Admin</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
        <div style="padding: 0 20px;">
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div style="padding: 0 20px;">
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>&copy; 2025 Smart Drawer ATMI. Politeknik ATMI Surakarta. All rights reserved.</p>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const navMenu = document.getElementById('navMenu');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            if (!navMenu.contains(event.target) && !menuBtn.contains(event.target)) {
                navMenu.classList.remove('active');
            }
        });

        // Close menu when clicking a link
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', function() {
                const navMenu = document.getElementById('navMenu');
                navMenu.classList.remove('active');
            });
        });

        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-success, .alert-error');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
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