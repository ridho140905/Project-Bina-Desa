@extends('layouts.admin')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Data Profil</h1>
            <p class="mb-0">Daftar profil desa.</p>
        </div>
        <div>
            <a href="{{ route('profil.create') }}" class="btn btn-primary">Tambah Profil</a>
        </div>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card border-0 shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">#</th>
                        <th class="border-0">ID</th>
                        <th class="border-0">Nama Desa</th>
                        <th class="border-0">Kecamatan</th>
                        <th class="border-0">Kabupaten</th>
                        <th class="border-0">Provinsi</th>
                        <th class="border-0">Alamat Kantor</th>
                        <th class="border-0">Email</th>
                        <th class="border-0">Telepon</th>
                        <th class="border-0">Visi</th>
                        <th class="border-0">Misi</th>
                        <th class="border-0 rounded-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataProfil as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->profil_id }}</td>
                        <td>{{ $item->nama_desa }}</td>
                        <td>{{ $item->kecamatan }}</td>
                        <td>{{ $item->kabupaten }}</td>
                        <td>{{ $item->provinsi }}</td>
                        <td>{{ Str::limit($item->alamat_kantor, 30) }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->telepon }}</td>
                        <td>{{ Str::limit($item->visi, 30) }}</td>
                        <td>{{ Str::limit($item->misi, 30) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('profil.edit', $item->profil_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('profil.destroy', $item->profil_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
