<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Profil Bina Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container text-center mt-5">
        <h2 class="text-success">Selamat Datang, {{ $username }}!</h2>
        <p class="lead">Anda berhasil login ke sistem <strong>Profil Bina Desa</strong>.</p>

        <a href="/auth" class="btn btn-outline-success mt-3">Logout</a>
    </div>
</body>
</html>
