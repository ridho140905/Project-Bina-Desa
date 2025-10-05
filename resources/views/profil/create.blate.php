<!DOCTYPE html>
<html>
<head>
    <title>Tambah Profil Desa</title>
</head>
<body>
    <h2>Tambah Profil Desa</h2>

    <form action="{{ route('profil.store') }}" method="POST">
        @csrf
        <p>
            <label>Judul</label><br>
            <input type="text" name="judul" required>
        </p>
        <p>
            <label>Deskripsi</label><br>
            <textarea name="deskripsi" rows="5" required></textarea>
        </p>
        <button type="submit">Simpan</button>
        <a href="{{ route('profil.index') }}">Kembali</a>
    </form>
</body>
</html>
