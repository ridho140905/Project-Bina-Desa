<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Profil Desa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 960px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        a.btn-add {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        a.btn-add:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:nth-child(even){
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .action-links a,
        .action-links button {
            display: inline-block;
            padding: 4px 8px;
            margin-right: 4px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .action-links a.edit {
            background-color: #2196F3;
            color: #fff;
        }

        .action-links a.edit:hover {
            background-color: #1976D2;
        }

        .action-links button.delete {
            background-color: #f44336;
            color: #fff;
        }

        .action-links button.delete:hover {
            background-color: #d32f2f;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Manajemen Profil Desa</h2>
        <a href="#" class="btn-add">+ Tambah Profil</a>

        <table>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
            @foreach($profil as $p)
            <tr>
                <td>{{ $p['judul'] }}</td>
                <td>{{ \Illuminate\Support\Str::limit($p['deskripsi'], 50) }}</td>
                <td class="action-links">
                    <a href="{{ url('profil/'.$p['id'].'/edit') }}" class="edit">Edit</a>
                    <form action="{{ url('profil/'.$p['id']) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
