<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Profil Bina Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #d2b48c, #f5deb3);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
        }

        /* Animasi background halus */
        @keyframes moveGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            background-size: 400% 400%;
            animation: moveGradient 12s ease infinite;
        }

        .login-card {
            background-color: #fffaf0;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(139, 69, 19, 0.2);
            padding: 40px 30px;
            width: 360px;
            animation: fadeInUp 0.8s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h4 {
            color: #8b4513;
            font-weight: 700;
        }

        .btn-login {
            background-color: #a0522d;
            color: white;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .btn-login:hover {
            background-color: #8b4513;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
        }

        .form-control:focus {
            border-color: #a0522d;
            box-shadow: 0 0 6px rgba(160, 82, 45, 0.5);
        }

        .alert {
            font-size: 0.9rem;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .footer-text {
            color: #8b4513;
            font-size: 0.85rem;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h4 class="text-center mb-4">Login Admin</h4>

        {{-- Pesan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Pesan error custom --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="/auth/login" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-login w-100 mt-2">Masuk</button>
        </form>

        <p class="text-center footer-text mt-3">&copy; {{ date('Y') }} Profil Bina Desa</p>
    </div>

</body>
</html>
