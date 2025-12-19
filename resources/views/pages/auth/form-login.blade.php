<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Admin Dashboard</title>
    <!-- Load CSS dari folder admin -->
    <link rel="stylesheet" href="/admin/css/main.css">
    <!-- Material Design Icons -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #eaffe4 0%, #3fbe54 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-height: 600px;
        }

        .login-hero {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .hero-image-container {
            width: 100%;
            height: 250px;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .hero-image:hover {
            transform: scale(1.05);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #10b981;
        }

        .hero-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1rem;
            color: #d1d5db;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .hero-features {
            list-style: none;
            margin-top: 20px;
        }

        .hero-features li {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-size: 0.9rem;
            color: #e5e7eb;
        }

        .hero-features .icon {
            margin-right: 10px;
            color: #10b981;
            font-size: 1.1rem;
        }

        .login-container {
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        /* MODIFIKASI: Card Header dengan Logo Vertikal */
        .card-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-header-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .card-header-subtitle {
            font-size: 1rem;
            color: #6b7280;
            margin-top: 5px;
        }

        /* END MODIFIKASI */

        .notification {
            margin-bottom: 20px;
            border-radius: 8px;
            padding: 12px 16px;
            border-left: 4px solid;
            font-size: 0.9rem;
        }

        .notification.is-success {
            background: #f0f9ff;
            border-left-color: #0369a1;
            color: #075985;
        }

        .notification.is-danger {
            background: #fef2f2;
            border-left-color: #dc2626;
            color: #991b1b;
        }

        .notification .icon {
            margin-right: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            z-index: 2;
        }

        .form-input {
            width: 100%;
            padding: 14px 14px 14px 42px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
            color: #374151;
        }

        .form-input:focus {
            outline: none;
            border-color: #374151;
            box-shadow: 0 0 0 3px rgba(55, 65, 81, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .checkbox {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .checkbox-input {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            position: relative;
            transition: all 0.2s ease;
        }

        .checkbox-input:checked {
            background: #374151;
            border-color: #374151;
        }

        .checkbox-label {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: #374151;
            color: white;
        }

        .btn-primary:hover {
            background: #1f2937;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-secondary {
            background: white;
            color: #374151;
            border: 2px solid #e5e7eb;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background: #f9fafb;
            border-color: #9ca3af;
            transform: translateY(-1px);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .register-link p {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .register-link a {
            color: #374151;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .register-link a:hover {
            color: #1f2937;
            text-decoration: underline;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .image-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #374151, #4b5563);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 0.9rem;
            text-align: center;
            padding: 20px;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-wrapper {
            animation: fadeIn 0.6s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-wrapper {
                grid-template-columns: 1fr;
                max-width: 450px;
            }

            .login-hero {
                display: none;
            }

            .login-container {
                padding: 40px 30px;
            }

            .login-logo {
                width: 70px;
                height: 70px;
            }

            .card-header-title {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            .login-logo {
                width: 60px;
                height: 60px;
            }

            .card-header-title {
                font-size: 1.4rem;
            }

            .card-header-subtitle {
                font-size: 0.9rem;
            }

            .hero-image-container {
                position: relative;
                width: 100%;
                height: 250px;
                border-radius: 8px;
                overflow: hidden;
                margin-bottom: 30px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            }

            .image-placeholder {
                width: 100%;
                height: 100%;
                background: linear-gradient(45deg, #374151, #4b5563);
                display: none;
                align-items: center;
                justify-content: center;
                color: #9ca3af;
                font-size: 0.9rem;
                text-align: center;
                padding: 20px;
                position: absolute;
                top: 0;
                left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <!-- Hero Section dengan Gambar dan Deskripsi -->
        <div class="login-hero">
            <div class="hero-image-container">
                <!-- GANTI SRC GAMBAR DI BAWAH INI JIKA PERLU -->
                <img src="{{ asset('assets-admin/img/warga.png') }}" alt="Desa Binaan" class="hero-image"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div id="image-placeholder" class="image-placeholder" style="display: none;">
                    <div>
                        <i class="mdi mdi-image-off" style="font-size: 3rem; margin-bottom: 10px; display: block;"></i>
                        Gambar Desa<br>
                        <small></small>
                    </div>
                </div>
            </div>

            <div class="hero-content">
                <i class="mdi mdi-home-group hero-icon"></i>
                <h1 class="hero-title">Sistem Portal Desa</h1>
                <p class="hero-subtitle">
                    Platform digital untuk mengelola dan memajukan desa secara terintegrasi.
                    Membangun desa yang mandiri, sejahtera, dan berkelanjutan melalui teknologi modern.
                </p>

                <ul class="hero-features">
                    <li>
                        <i class="mdi mdi-check-circle icon"></i>
                        Manajemen data warga terintegrasi
                    </li>
                    <li>
                        <i class="mdi mdi-check-circle icon"></i>
                        Pengelolaan profil desa yang lengkap
                    </li>
                    <li>
                        <i class="mdi mdi-check-circle icon"></i>
                        Menampilkan berita yang terjadi
                    </li>
                    <li>
                        <i class="mdi mdi-check-circle icon"></i>
                        Laporan perkembangan desa real-time
                    </li>
                </ul>
            </div>
        </div>

        <!-- Login Form Section -->
        <div class="login-container">
            <div class="login-card">
                <!-- MODIFIKASI: Card Header dengan Logo Vertikal -->
                <div class="card-header">
                    <div class="logo-container">
                        <!-- Logo Profil Desa -->
                        <img src="{{ asset('assets-admin/img/logoprofildesa.png') }}" alt="Logo Profil Desa" class="login-logo">
                        <!-- Judul dan Subtitle -->
                        <h1 class="card-header-title">Portal Desa</h1>
                    </div>
                </div>
                <!-- END MODIFIKASI -->

                <div class="card-content">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="notification is-success">
                            <i class="mdi mdi-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="notification is-danger">
                            <i class="mdi mdi-alert-circle"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="notification is-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="mdi mdi-alert-circle">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth.login') }}">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Alamat Email</label>
                            <div class="input-group">
                                <i class="mdi mdi-email input-icon"></i>
                                <input class="form-input" type="email" name="email"
                                    placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="error-message">
                                    <i class="mdi mdi-alert"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <i class="mdi mdi-lock input-icon"></i>
                                <input class="form-input" type="password" name="password"
                                    placeholder="Masukkan password Anda" required>
                            </div>
                            @error('password')
                                <div class="error-message">
                                    <i class="mdi mdi-alert"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="checkbox-group">
                            <label class="checkbox">
                                <input type="checkbox" name="remember" value="1" class="checkbox-input">
                                <span class="checkbox-label">Ingat saya</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-login"></i>
                            Masuk
                        </button>

                        <a href="{{ route('auth.showRegister') }}" class="btn btn-secondary">
                            <i class="mdi mdi-account-plus"></i>
                            Buat Akun Baru
                        </a>

                        <div class="register-link">
                            <p>Belum punya akun? <a href="{{ route('auth.showRegister') }}">Daftar di sini</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/admin/js/main.min.js"></script>
</body>

</html>
