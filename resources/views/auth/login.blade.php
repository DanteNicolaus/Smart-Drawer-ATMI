<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Drawer ATMI</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            display: flex;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.12);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            border: 1px solid rgba(199, 210, 254, 0.6);
        }

        /* Left Side */
        .left-side {
            background: linear-gradient(160deg, #eef2ff 0%, #dbeafe 50%, #c7d2fe 100%);
            color: #1e293b;
            padding: 60px 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 110px;
            height: 110px;
            background: rgba(255, 255, 255, 0.7);
            border: 2px solid rgba(199, 210, 254, 0.8);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 52px;
            backdrop-filter: blur(6px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
        }

        .left-side h2 {
            font-size: 28px;
            margin-bottom: 15px;
            text-align: center;
            color: #1e293b;
            font-weight: 700;
        }

        .left-side p {
            text-align: center;
            color: #4f5f7a;
            line-height: 1.6;
            font-size: 15px;
        }

        .left-side p.desc {
            margin-top: 25px;
            font-size: 13px;
            color: #6b7fa0;
        }

        /* Right Side */
        .right-side {
            flex: 1;
            padding: 60px 40px;
            background: #ffffff;
        }

        .form-title {
            font-size: 26px;
            color: #1e293b;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .form-subtitle {
            color: #64748b;
            margin-bottom: 28px;
            font-size: 14px;
        }

        /* Alerts */
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        /* ========================================== */
        /* SESSION TIMEOUT ALERT (BARU) */
        /* ========================================== */
        
        .alert-info {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left: 4px solid #2563eb;
            animation: slideDown 0.3s ease;
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        
        .alert-info .alert-icon {
            font-size: 20px;
            color: #1e40af;
            margin-top: 2px;
        }
        
        .alert-info .alert-content {
            flex: 1;
        }
        
        .alert-info .alert-content strong {
            display: block;
            color: #1e40af;
            font-size: 14px;
            margin-bottom: 4px;
            font-weight: 600;
        }
        
        .alert-info .alert-content p {
            color: #1e40af;
            font-size: 13px;
            margin: 0;
            line-height: 1.5;
        }
        
        .alert-info .alert-close {
            background: none;
            border: none;
            color: #1e40af;
            font-size: 18px;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.3s;
            padding: 0 4px;
            line-height: 1;
        }
        
        .alert-info .alert-close:hover {
            opacity: 1;
        }
        
        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #374151;
            font-weight: 600;
            margin-bottom: 7px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
            background: #fafafa;
            transition: all 0.2s;
        }

        input::placeholder {
            color: #a0aec0;
        }

        input:focus {
            outline: none;
            border-color: #6366f1;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        .error-message {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Remember Me */
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
            margin: 0;
            accent-color: #6366f1;
        }

        .remember-me label {
            margin: 0;
            font-weight: normal;
            font-size: 14px;
            color: #64748b;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 24px 0;
            color: #94a3b8;
            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider span {
            padding: 0 12px;
        }

        /* Google Login Button */
        .btn-google {
            width: 100%;
            padding: 12px;
            background: white;
            color: #3c4043;
            border: 1.5px solid #dadce0;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-decoration: none;
        }

        .btn-google:hover {
            background: #f8f9fa;
            border-color: #d2d3d4;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-google:active {
            background: #f1f3f4;
        }

        .google-icon {
            width: 18px;
            height: 18px;
        }

        /* Back Home Link */
        .back-home {
            text-align: center;
            margin-top: 18px;
        }

        .back-home a {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .back-home a:hover {
            color: #1d4ed8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-side {
                padding: 40px 30px;
            }

            .right-side {
                padding: 40px 30px;
            }

            .logo {
                width: 90px;
                height: 90px;
                font-size: 42px;
            }

            .left-side h2 {
                font-size: 22px;
            }

            .form-title {
                font-size: 22px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 12px;
            }

            .left-side, .right-side {
                padding: 30px 22px;
            }

            .logo {
                width: 75px;
                height: 75px;
                font-size: 36px;
            }

            .left-side h2 {
                font-size: 20px;
            }

            .form-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-side">
            <div class="logo-container">
                <div class="logo">📦</div>
            </div>
            <h2>Smart Drawer ATMI</h2>
            <p>Sistem Peminjaman Alat<br>Politeknik ATMI Surakarta</p>
        </div>

        <div class="right-side">
            <h1 class="form-title">Selamat Datang!</h1>
            <p class="form-subtitle">Silakan login untuk melanjutkan</p>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
            @endif

            {{-- ✅ NOTIFIKASI SESSION TIMEOUT (BARU) --}}
            @if(session('info'))
            <div class="alert-info">
                <div class="alert-icon">⏰</div>
                <div class="alert-content">
                    <strong>Sesi Berakhir</strong>
                    <p>{{ session('info') }}</p>
                </div>
                <button class="alert-close" onclick="this.parentElement.remove()" type="button">×</button>
            </div>
            @endif

            @if($errors->has('nim'))
            <div class="alert alert-error">
                {{ $errors->first('nim') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="nim">Username *</label>
                    <input 
                        type="text" 
                        id="nim" 
                        name="nim" 
                        value="{{ old('nim') }}" 
                        required 
                        autofocus
                        placeholder="Contoh: 20232006"
                    >
                    @error('nim')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        placeholder="Masukkan password Anda"
                    >
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <a href="{{ route('google.login') }}" class="btn-google">
                <svg class="google-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                <span>Login dengan Google ATMI</span>
            </a>

            <div class="back-home">
                <a href="/">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    {{-- ✅ Auto-hide alert setelah 10 detik (BARU) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const infoAlert = document.querySelector('.alert-info');
            if (infoAlert) {
                setTimeout(function() {
                    infoAlert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    infoAlert.style.opacity = '0';
                    infoAlert.style.transform = 'translateY(-20px)';
                    setTimeout(function() {
                        infoAlert.remove();
                    }, 500);
                }, 10000); // 10 detik
            }
        });
    </script>
</body>
</html>