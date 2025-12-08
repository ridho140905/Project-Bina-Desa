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
                {{-- Form Search --}}
                <form method="GET" action="{{ route('galeri.index') }}" class="mb-4">
                    <div class="row g-3 align-items-end">
                        {{-- Search --}}
                        <div class="col-md-6">
                            <label class="form-label-universal">Cari Data</label>
                            <div class="input-group-universal">
                                <input type="text" name="search" class="form-control-universal"
                                       value="{{ request('search') }}" placeholder="Cari judul atau deskripsi galeri...">
                                <button type="submit" class="btn btn-search-universal">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                    </svg>
                                </button>
                                @if(request('search'))
                                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                                       class="btn btn-clear-universal" title="Clear Search">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Info Filter Aktif --}}
                @if(request('search'))
                <div class="alert alert-info mb-3">
                    <strong>Filter Aktif:</strong>
                    Pencarian: "{{ request('search') }}"
                </div>
                @endif

                <div class="table-responsive table-responsive-universal">
                    <table class="table universal-table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Foto Utama</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataGaleri as $item)
                                <tr>
                                    <td class="text-center text-muted-universal">
                                        {{ ($dataGaleri->currentPage() - 1) * $dataGaleri->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        @if($item->foto_utama_url)
                                            <div class="galeri-thumbnail">
                                                <img src="{{ $item->foto_utama_url }}"
                                                     alt="{{ $item->judul }}"
                                                     class="thumbnail-img"
                                                     onclick="showImage('{{ $item->foto_utama_url }}', '{{ $item->judul }}')">
                                            </div>
                                        @else
                                            <div class="no-image-table">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="fw-semibold-universal">{{ $item->judul }}</td>
                                    <td>
                                        @if($item->deskripsi)
                                            <span class="text-muted-universal">{{ Str::limit($item->deskripsi, 50) }}</span>
                                        @else
                                            <span class="text-muted-universal">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('galeri.show', $item->galeri_id) }}"
                                               class="btn btn-primary btn-sm mb-1"
                                               title="Detail Galeri">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('galeri.edit', $item->galeri_id) }}"
                                               class="btn btn-edit"
                                               title="Edit Galeri">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                            </a>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('galeri.destroy', $item->galeri_id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-delete"
                                                        onclick="return confirm('Yakin ingin menghapus galeri {{ $item->judul }}?')"
                                                        title="Hapus Galeri">
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
                                    <td colspan="5" class="empty-state-universal">
                                        <span class="icon">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                            </svg>
                                        </span>
                                        @if(request('search'))
                                            Data galeri tidak ditemukan dengan pencarian "{{ request('search') }}".
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
                        {{ $dataGaleri->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk preview gambar -->
<div id="imageModal" class="modal-universal">
    <div class="modal-content-universal">
        <span class="close-modal">&times;</span>
        <img id="modalImage" src="" alt="">
        <div id="modalCaption"></div>
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

.btn-edit, .btn-delete, .btn-primary {
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

.btn-primary {
    background-color: #007bff;
    color: #fff;
}

.btn-primary:hover {
    background-color: #0056b3;
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

.form-select-universal, .form-control-universal {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 14px;
}

.input-group-universal {
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-search-universal, .btn-clear-universal {
    background: #3b82f6;
    border: none;
    border-radius: 6px;
    padding: 8px 12px;
    color: white;
    cursor: pointer;
}

.btn-clear-universal {
    background: #ef4444;
}

.form-label-universal {
    font-weight: 500;
    margin-bottom: 4px;
    display: block;
    color: #374151;
}

/* Galeri Thumbnail */
.galeri-thumbnail {
    display: inline-block;
}

.thumbnail-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.2s ease;
    border: 2px solid #e2e8f0;
}

.thumbnail-img:hover {
    transform: scale(1.1);
    border-color: #3b82f6;
}

.no-image-table {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    border: 2px dashed #dee2e6;
}

/* Modal Styles */
.modal-universal {
    display: none;
    position: fixed;
    z-index: 1000;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    animation: fadeIn 0.3s;
}

.modal-content-universal {
    margin: auto;
    display: block;
    max-width: 80%;
    max-height: 80%;
    animation: zoomIn 0.3s;
}

#modalCaption {
    margin: auto;
    display: block;
    width: 80%;
    text-align: center;
    color: #fff;
    padding: 10px 0;
    font-size: 16px;
    font-weight: 500;
}

.close-modal {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.close-modal:hover {
    color: #bbb;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes zoomIn {
    from { transform: scale(0.8); }
    to { transform: scale(1); }
}

/* Pagination Styles */
.pagination {
    display: flex;
    padding-left: 0;
    list-style: none;
    border-radius: 0.375rem;
    gap: 8px;
    justify-content: center;
    flex-wrap: wrap;
}

.page-link {
    position: relative;
    display: block;
    padding: 8px 16px;
    font-size: 14px;
    color: #3b82f6;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    transition: all 0.2s ease-in-out;
    font-weight: 500;
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
}

/* Responsive */
@media (max-width: 768px) {
    .modal-content-universal {
        max-width: 95%;
        max-height: 70%;
    }

    .thumbnail-img {
        width: 50px;
        height: 50px;
    }

    .action-buttons {
        flex-direction: column;
        gap: 4px;
    }
}

/* Info Filter */
.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}
</style>
@endsection
