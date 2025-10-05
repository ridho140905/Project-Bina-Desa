<!DOCTYPE html>
<html>
<head>
    <title>Edit Profil Desa</title>
</head>
<body>
    <h2>Edit Profil Desa</h2>

    <form action="{{ route('profil.update', $profil->id) }}" method="POST">
        @csrf
        @method('PUT')
        <p>
            <label>Judul</label><br>
            <input type="text" name="judul" value="{{ $profil->judul }}" required>
        </p>
        <p>
            <label>Deskripsi</label><br>
            <textarea name="deskripsi" rows="5" required>{{ $profil->deskripsi }}</textarea>
        </p>
        <button type="submit">Update</button>
        <a href="{{ route('profil.index') }}">Kembali</a>
    </form>
</body>
</html>
