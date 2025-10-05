<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Profil Bina Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Warna & font utama */
        body {
            background: linear-gradient(135deg, #f5deb3, #deb887, #d2b48c);
            background-size: 400% 400%;
            animation: moveBg 15s ease infinite;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: #4e342e;
        }

        @keyframes moveBg {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .navbar {
            background-color: #8b4513;
            animation: slideDown 0.7s ease;
        }

        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
        }

        .card {
            border: none;
            border-radius: 20px;
            background-color: #fffaf0;
            box-shadow: 0 8px 25px rgba(139, 69, 19, 0.25);
            animation: fadeInUp 0.9s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h3 {
            color: #8b4513;
            font-weight: 700;
        }

        .btn-brown {
            background-color: #a0522d;
            border: none;
            color: #fff;
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .btn-brown:hover {
            background-color: #8b4513;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
        }

        .card-footer {
            background-color: #f5f5dc;
            font-size: 0.9rem;
            color: #6b4f36;
        }

        .welcome-icon {
            font-size: 2.2rem;
            animation: wave 1.6s infinite;
            display: inline-block;
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(10deg); }
            75% { transform: rotate(-10deg); }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">🌾 Profil Bina Desa</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 fw-semibold">👤 AdminBaru </span>
                <a href="/auth" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Konten utama -->
    <div class="container mt-5 text-center">
        <div class="card p-4 mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h3 class="fw-bold">Selamat Datang,Admin <span class="welcome-icon">👋</span></h3>
                <p class="lead mt-3">
                    Anda berhasil login ke sistem <strong>Dashboard Bina Desa</strong>.
                </p>

                <hr class="my-4">

                <a href="/profil" class="btn btn-brown px-4 mt-2">Lihat Profil Desa</a>
            </div>
            <div class="card-footer text-muted">
                &copy;  Website Bina Desa
            </div>
        </div>
    </div>

</body>
</html>
