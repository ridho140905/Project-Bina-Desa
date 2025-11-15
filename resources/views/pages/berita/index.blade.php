@extends('layouts.admin.app')

@section('content')
<div class="content-wrapper-full">
    <div class="container-full py-4">
        {{-- Header --}}
        <div class="page-header-primary">
            <div>
                <h1>
                    <span class="icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </span>
                    Data Berita
                </h1>
                <p>Manajemen data berita desa</p>
            </div>
            <a href="{{ route('berita.create') }}" class="btn btn-light-universal btn-universal">
                <span class="icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                </span>
                Tambah Berita
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
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Status</th>
                                <th>Tanggal Terbit</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataBerita as $item)
                                <tr>
                                    <td class="text-center text-muted-universal">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->cover_foto)
                                                <img src="{{ asset('storage/' . $item->cover_foto) }}"
                                                     alt="Cover"
                                                     class="cover-thumbnail me-3">
                                            @endif
                                            <div>
                                                <div class="fw-semibold-universal">{{ Str::limit($item->judul, 50) }}</div>
                                                <small class="text-muted-universal">{{ $item->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="universal-badge badge-primary">
                                            {{ $item->kategori->nama ?? 'Tidak ada kategori' }}
                                        </span>
                                    </td>
                                    <td>{{ $item->penulis }}</td>
                                    <td>
                                        @if($item->status == 'terbit')
                                            <span class="universal-badge badge-success">Terbit</span>
                                        @else
                                            <span class="universal-badge badge-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->terbit_at)
                                            {{ \Carbon\Carbon::parse($item->terbit_at)->format('d M Y H:i') }}
                                        @else
                                            <span class="text-muted-universal">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('berita.show', $item->berita_id) }}" class="btn btn-info btn-sm" title="Lihat">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('berita.edit', $item->berita_id) }}" class="btn btn-edit">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('berita.destroy', $item->berita_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state-universal">
                                        <span class="icon">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 6h-2.18c.11-.31.18-.65.18-1a2.996 2.996 0 0 0-5.5-1.65l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-5-2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm11 15H4v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 11 8.76l1-1.36 1 1.36L15.38 12 17 10.83 14.92 8H20v6z"/>
                                            </svg>
                                        </span>
                                        Belum ada data berita.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
    min-height: 40px;
}

.action-buttons form {
    display: flex !important;
    margin: 0 !important;
}

.btn-edit, .btn-delete, .btn-info {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    padding: 0;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.btn-info {
    background-color: #17a2b8;
    color: #fff;
}

.btn-info:hover {
    background-color: #138496;
    transform: translateY(-1px);
}

.btn-edit {
    background-color: #ffc107;
    color: #000;
}

.btn-edit:hover {
    background-color: #e0a800;
    transform: translateY(-1px);
}

.btn-delete {
    background-color: #dc3545;
    color: #fff;
}

.btn-delete:hover {
    background-color: #c82333;
    transform: translateY(-1px);
}

.cover-thumbnail {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #e9ecef;
}

/* Memastikan kolom aksi memiliki width yang konsisten */
.universal-table th.text-center:last-child,
.universal-table td.text-center:last-child {
    width: 140px;
    min-width: 140px;
    max-width: 140px;
}

/* Memastikan tombol tetap sejajar di semua kondisi */
.universal-table tbody td.text-center {
    vertical-align: middle !important;
}

.empty-state-universal {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 40px !important;
    color: #6c757d;
    text-align: center;
}

.icon {
    display: inline-flex;
    align-items: center;
    margin-right: 8px;
}

.universal-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-primary { background-color: #007bff; color: white; }
.badge-success { background-color: #28a745; color: white; }
.badge-secondary { background-color: #6c757d; color: white; }
.badge-info { background-color: #17a2b8; color: white; }
.badge-warning { background-color: #ffc107; color: black; }

.text-muted-universal {
    color: #6c757d !important;
}

.fw-semibold-universal {
    font-weight: 600 !important;
}
</style>
@endsection
