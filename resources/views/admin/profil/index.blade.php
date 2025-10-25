@extends('layouts.admin.app')

@section('content')
<div class="content-wrapper-full">
    <div class="container-full py-4">
        {{-- Header --}}
        <div class="page-header-primary">
            <div>
                <h1>📋 Data Profil</h1>
                <p>Manajemen data profil desa</p>
            </div>
            <a href="{{ route('profil.create') }}" class="btn btn-light-universal btn-universal">
                ➕ Tambah Profil
            </a>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-universal">
                {{ session('success') }}
            </div>
        @endif

        {{-- Card Table --}}
        <div class="card-universal">
            <div class="card-body-universal">
                <div class="table-responsive table-responsive-universal">
                    <table class="table universal-table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>ID</th>
                                <th>Nama Desa</th>
                                <th>Kecamatan</th>
                                <th>Kabupaten</th>
                                <th>Provinsi</th>
                                <th>Alamat Kantor</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Visi</th>
                                <th>Misi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataProfil as $item)
                                <tr>
                                    <td class="text-center text-muted-universal">{{ $loop->iteration }}</td>
                                    <td><span class="universal-badge badge-secondary">{{ $item->profil_id }}</span></td>
                                    <td class="fw-semibold-universal">{{ $item->nama_desa }}</td>
                                    <td><span class="universal-badge badge-info">{{ $item->kecamatan }}</span></td>
                                    <td><span class="universal-badge badge-warning">{{ $item->kabupaten }}</span></td>
                                    <td><span class="universal-badge badge-success">{{ $item->provinsi }}</span></td>
                                    <td>{{ Str::limit($item->alamat_kantor, 25) }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->telepon }}</td>
                                    <td>{{ Str::limit($item->visi, 25) }}</td>
                                    <td>{{ Str::limit($item->misi, 25) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('profil.edit', $item->profil_id) }}" class="btn btn-sm btn-warning me-1">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('profil.destroy', $item->profil_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="empty-state-universal">Belum ada data profil.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
