@extends('layouts.admin.app')

@section('content')
<div class="content-wrapper-full">
    <div class="container-full py-4">
        {{-- Header --}}
        <div class="page-header-primary">
            <div>
                <h1>👥 Data User</h1>
                <p>List data seluruh User</p>
            </div>
            <a href="{{ route('user.create') }}" class="btn btn-light-universal btn-universal">
                ➕ Tambah User
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
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataUser as $item)
                                <tr>
                                    <td class="text-center text-muted-universal">{{ $loop->iteration }}</td>
                                    <td class="fw-semibold-universal">{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td><span class="universal-badge badge-secondary">{{ Str::limit($item->password, 15) }}</span></td>
                                    <td class="text-center">
                                        <div class="btn-action-user">
                                            <a href="{{ route('user.edit', $item->id) }}" class="btn btn-edit-user">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('user.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete-user" onclick="return confirm('Yakin ingin menghapus?')">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state-universal">Belum ada data user.</td>
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
