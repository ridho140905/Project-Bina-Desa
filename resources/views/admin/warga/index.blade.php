@extends('layouts.admin')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Warga</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Data Warga</h1>
            <p class="mb-0">Daftar warga desa.</p>
        </div>
        <div>
            <a href="{{ route('warga.create') }}" class="btn btn-primary">Tambah Warga</a>
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
                        <th class="border-0">No KTP</th>
                        <th class="border-0">Nama</th>
                        <th class="border-0">Jenis Kelamin</th>
                        <th class="border-0">Agama</th>
                        <th class="border-0">Pekerjaan</th>
                        <th class="border-0">Telepon</th>
                        <th class="border-0">Email</th>
                        <th class="border-0 rounded-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($warga as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_ktp }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $item->agama }}</td>
                        <td>{{ $item->pekerjaan }}</td>
                        <td>{{ $item->telp }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('warga.edit', $item->warga_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('warga.destroy', $item->warga_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data warga?')">Hapus</button>
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
