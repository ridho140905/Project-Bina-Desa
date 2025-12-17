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
                            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                        </svg>
                    </span>
                    Data Galeri
                </h1>
                <p>Manajemen foto galeri kegiatan</p>
            </div>
            <a href="{{ route('galeri.create') }}" class="btn btn-light-universal btn-universal">
                <span class="icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                </span>
                Tambah Galeri
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
                {{-- Form Filter dan Search --}}
                <form method="GET" action="{{ route('galeri.index') }}" class="mb-4">
                    <div class="row g-3">
                        {{-- Filter Foto --}}
                        <div class="col-md-6">
                            <label class="form-label-universal">Filter Foto</label>
                            <div class="filter-container">
                                <select name="filter_foto" class="form-select-universal" onchange="this.form.submit()">
                                    <option value="">Semua Galeri</option>
                                    <option value="with_photos" {{ request('filter_foto') == 'with_photos' ? 'selected' : '' }}>
                                        Dengan Foto
                                    </option>
                                    <option value="without_photos" {{ request('filter_foto') == 'without_photos' ? 'selected' : '' }}>
                                        Tanpa Foto
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- Search --}}
                        <div class="col-md-6">
                            <label class="form-label-universal">Cari Galeri</label>
                            <div class="search-container">
                                <div class="input-group-universal">
                                    <input type="text" name="search" class="form-control-universal"
                                           value="{{ request('search') }}" placeholder="Cari judul atau deskripsi galeri...">
                                    <button type="submit" class="btn btn-search-universal">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                        </svg>
                                    </button>
                                    @if(request('search') || request('filter_foto'))
                                        <a href="{{ route('galeri.index') }}" class="btn btn-clear-universal" title="Clear All">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Info Filter Aktif --}}
                @if(request('search') || request('filter_foto'))
                <div class="alert alert-info mb-3">
                    <strong>Filter Aktif:</strong>
                    @if(request('search'))
                        Pencarian: "{{ request('search') }}"
                    @endif
                    @if(request('filter_foto'))
                        {{ request('search') ? ' | ' : '' }}
                        Filter:
                        @if(request('filter_foto') == 'with_photos')
                            Dengan Foto
                        @elseif(request('filter_foto') == 'without_photos')
                            Tanpa Foto
                        @endif
                    @endif
                </div>
                @endif

                {{-- Info Jumlah Data --}}
                <div class="data-count-info mb-3">
                    <small class="text-muted-universal">Total: {{ $dataGaleri->total() }} data galeri</small>
                </div>

                <div class="table-responsive table-responsive-universal">
                    <table class="table universal-table">
                        <thead>
                            <tr>
                                <th width="30" class="text-center">#</th>
                                <th width="60">Foto Utama</th>
                                <th width="200">Judul Galeri</th>
                                <th width="250">Deskripsi</th>
                                <th width="100">Jumlah Foto</th>
                                <th width="120">Tanggal Dibuat</th>
                                <th width="120" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataGaleri as $item)
                                @php
                                    $fotoUtama = $item->media->where('sort_order', 1)->first();
                                    $jumlahFoto = $item->media->count();
                                @endphp
                                <tr>
                                    <td class="text-center text-muted-universal align-middle">
                                        {{ ($dataGaleri->currentPage() - 1) * $dataGaleri->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="align-middle">
                                        @if($fotoUtama)
                                            <img src="{{ asset('storage/media/galeri/' . $fotoUtama->file_name) }}"
                                                 alt="{{ $item->judul }}"
                                                 class="thumbnail-img-table"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="no-image-table" style="display: none;">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="no-image-table">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <div class="fw-semibold-universal">{{ Str::limit($item->judul, 40) }}</div>
                                    </td>
                                    <td class="align-middle">
                                        @if($item->deskripsi)
                                            <div class="text-muted-universal">{{ Str::limit($item->deskripsi, 60) }}</div>
                                        @else
                                            <span class="text-muted-universal">-</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <span class="universal-badge {{ $jumlahFoto > 0 ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $jumlahFoto }} foto
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="universal-badge badge-info">
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="action-buttons-wrapper">
                                            <div class="action-buttons">
                                                {{-- Tombol Detail --}}
                                                <a href="{{ route('galeri.show', $item->galeri_id) }}"
                                                   class="btn-action btn-detail"
                                                   title="Detail Galeri">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>

                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('galeri.edit', $item->galeri_id) }}"
                                                   class="btn-action btn-edit"
                                                   title="Edit Galeri">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                    </svg>
                                                </a>

                                                {{-- Tombol Delete --}}
                                                <form action="{{ route('galeri.destroy', $item->galeri_id) }}"
                                                      method="POST"
                                                      class="action-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn-action btn-delete"
                                                            onclick="return confirm('Yakin ingin menghapus galeri {{ $item->judul }}?')"
                                                            title="Hapus Galeri">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state-universal align-middle">
                                        <span class="icon">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                            </svg>
                                        </span>
                                        @if(request('search') || request('filter_foto'))
                                            Data galeri tidak ditemukan dengan filter yang dipilih.
                                        @else
                                            Belum ada data galeri.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($dataGaleri->hasPages())
                    <div class="mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mb-0">
                                @if ($dataGaleri->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link page-link-arrow">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
                                            </svg>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link page-link-arrow" href="{{ $dataGaleri->previousPageUrl() }}">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
                                            </svg>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($dataGaleri->getUrlRange(1, $dataGaleri->lastPage()) as $page => $url)
                                    @if ($page == $dataGaleri->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                @if ($dataGaleri->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link page-link-arrow" href="{{ $dataGaleri->nextPageUrl() }}">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                                            </svg>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link page-link-arrow">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                                            </svg>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* === FIX UTAMA UNTUK TOMBOL SEJAJAR === */
.action-buttons-wrapper {
    display: table-cell;
    vertical-align: middle !important;
    height: 100%;
}

.action-buttons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    padding: 0;
    margin: 0;
    height: 40px;
}

.action-form {
    display: flex !important;
    align-items: center;
    justify-content: center;
    margin: 0;
    padding: 0;
    height: 32px;
    width: 32px;
}

.btn-action {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 32px !important;
    height: 32px !important;
    padding: 0 !important;
    margin: 0 !important;
    border: none !important;
    border-radius: 6px !important;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    line-height: 1;
    flex-shrink: 0;
    box-sizing: border-box;
}

/* Warna tombol */
.btn-detail {
    background-color: #007bff !important;
    color: white !important;
}

.btn-detail:hover {
    background-color: #0056b3 !important;
    transform: translateY(-1px);
}

.btn-edit {
    background-color: #ffc107 !important;
    color: black !important;
}

.btn-edit:hover {
    background-color: #e0a800 !important;
    transform: translateY(-1px);
}

.btn-delete {
    background-color: #dc3545 !important;
    color: white !important;
    border: none !important;
}

.btn-delete:hover {
    background-color: #c82333 !important;
    transform: translateY(-1px);
}

/* === PASTIKAN SEMUA KOLOM SEJAJAR === */
.universal-table tbody tr td {
    vertical-align: middle !important;
    padding-top: 12px !important;
    padding-bottom: 12px !important;
}

/* === STYLE LAINNYA TETAP SAMA === */
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
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.badge-secondary { background-color: #6c757d; color: white; }
.badge-success { background-color: #28a745; color: white; }
.badge-info { background-color: #17a2b8; color: white; }

.text-muted-universal {
    color: #6c757d !important;
}

.fw-semibold-universal {
    font-weight: 600 !important;
}

/* Thumbnail */
.thumbnail-img-table {
    width: 60px;
    height: 60px;
    border-radius: 6px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    display: block;
}

.no-image-table {
    width: 60px;
    height: 60px;
    border-radius: 6px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    border: 2px dashed #dee2e6;
}

/* Form Styles */
.form-select-universal, .form-control-universal {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 14px;
    height: 42px;
    box-sizing: border-box;
}

.filter-container, .search-container {
    width: 100%;
    max-width: 400px;
}

.form-select-universal {
    width: 100%;
}

.input-group-universal {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
}

.form-control-universal {
    flex: 1;
    min-width: 0;
}

.btn-search-universal, .btn-clear-universal {
    background: #3b82f6;
    border: none;
    border-radius: 6px;
    padding: 10px 12px;
    color: white;
    cursor: pointer;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.btn-clear-universal {
    background: #ef4444;
}

.btn-search-universal:hover {
    background: #2563eb;
}

.btn-clear-universal:hover {
    background: #dc2626;
}

.form-label-universal {
    font-weight: 500;
    margin-bottom: 6px;
    display: block;
    color: #374151;
    font-size: 14px;
}

.row.g-3 > .col-md-6 {
    display: flex;
    flex-direction: column;
}

.data-count-info {
    text-align: right;
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 16px;
}

/* Pagination */
.pagination {
    display: flex;
    padding-left: 0;
    list-style: none;
    border-radius: 0.375rem;
    gap: 4px;
    justify-content: center;
    flex-wrap: wrap;
    margin: 0;
}

.page-item {
    margin: 0;
}

.page-link {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px 12px;
    font-size: 14px;
    color: #3b82f6;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    transition: all 0.2s ease-in-out;
    font-weight: 500;
    min-width: 40px;
    height: 40px;
}

.page-link:hover {
    z-index: 2;
    color: #1e40af;
    background-color: #f3f4f6;
    border-color: #d1d5db;
}

.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #3b82f6;
    border-color: #3b82f6;
    font-weight: 600;
}

.page-item.disabled .page-link {
    color: #9ca3af;
    pointer-events: none;
    background-color: #f9fafb;
    border-color: #d1d5db;
    opacity: 0.6;
}

.page-link-arrow {
    padding: 8px;
    min-width: 40px;
}

.page-link-arrow svg {
    width: 16px;
    height: 16px;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 16px;
}

/* Responsive */
@media (max-width: 768px) {
    .action-buttons {
        gap: 4px;
    }

    .btn-action {
        width: 30px !important;
        height: 30px !important;
    }

    .filter-container,
    .search-container {
        max-width: 100%;
    }
}
</style>
@endsection
