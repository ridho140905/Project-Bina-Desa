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
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </span>
                    Data Profil
                </h1>
                <p>Manajemen data profil desa</p>
            </div>
            <a href="{{ route('profil.create') }}" class="btn btn-light-universal btn-universal">
                <span class="icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                </span>
                Tambah Profil
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
                <form method="GET" action="{{ route('profil.index') }}" class="mb-4">
                    <div class="row g-3">
                        {{-- Filter Provinsi --}}
                        <div class="col-md-6">
                            <label class="form-label-universal">Provinsi</label>
                            <div class="filter-container">
                                <select name="provinsi" class="form-select-universal" onchange="this.form.submit()">
                                    <option value="">Semua Provinsi</option>
                                    <option value="Riau" {{ request('provinsi') == 'Riau' ? 'selected' : '' }}>Riau</option>
                                    <option value="Sumatera Barat" {{ request('provinsi') == 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                                    <option value="Sumatera Utara" {{ request('provinsi') == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                                </select>
                            </div>
                        </div>

                        {{-- Search --}}
                        <div class="col-md-6">
                            <label class="form-label-universal">Cari Data</label>
                            <div class="search-container">
                                <div class="input-group-universal">
                                    <input type="text" name="search" class="form-control-universal"
                                           value="{{ request('search') }}" placeholder="Cari nama desa, kecamatan, atau kabupaten...">
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
                    </div>
                </form>

                {{-- Info Filter Aktif --}}
                @if(request('search') || request('provinsi'))
                <div class="alert alert-info mb-3">
                    <strong>Filter Aktif:</strong>
                    @if(request('search'))
                        Pencarian: "{{ request('search') }}"
                    @endif
                    @if(request('provinsi'))
                        {{ request('search') ? ' | ' : '' }}
                        Provinsi: {{ request('provinsi') }}
                    @endif
                </div>
                @endif

                <div class="table-responsive table-responsive-universal">
                    <table class="table universal-table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Foto</th>
                                <th>Nama Desa</th>
                                <th>Kecamatan</th>
                                <th>Kabupaten</th>
                                <th>Provinsi</th>
                                <th>Alamat Kantor</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataProfil as $item)
                                <tr>
                                    <td class="text-center text-muted-universal">
                                        {{ ($dataProfil->currentPage() - 1) * $dataProfil->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        @if($item->foto_utama_url)
                                            <img src="{{ $item->foto_utama_url }}"
                                                 alt="{{ $item->nama_desa }}"
                                                 class="profile-img-table"
                                                 onerror="this.src='https://via.placeholder.com/50x50?text=No+Image'">
                                        @else
                                            <div class="no-image-table">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="fw-semibold-universal">{{ $item->nama_desa }}</td>
                                    <td><span class="universal-badge badge-info">{{ $item->kecamatan }}</span></td>
                                    <td><span class="universal-badge badge-warning">{{ $item->kabupaten }}</span></td>
                                    <td><span class="universal-badge badge-success">{{ $item->provinsi }}</span></td>
                                    <td>{{ Str::limit($item->alamat_kantor, 25) }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->telepon }}</td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('profil.show', $item->profil_id) }}"
                                               class="btn btn-primary btn-sm mb-1"
                                               title="Detail Profil">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('profil.edit', $item->profil_id) }}"
                                               class="btn btn-edit"
                                               title="Edit Profil">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                            </a>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('profil.destroy', $item->profil_id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-delete"
                                                        onclick="return confirm('Yakin ingin menghapus profil {{ $item->nama_desa }}?')"
                                                        title="Hapus Profil">
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
                                    <td colspan="10" class="empty-state-universal">
                                        <span class="icon">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                        </span>
                                        @if(request('search') || request('provinsi'))
                                            Data profil tidak ditemukan dengan filter yang dipilih.
                                        @else
                                            Belum ada data profil.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination tanpa teks Next/Previous --}}
                @if($dataProfil->hasPages())
                    <div class="mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mb-0">
                                {{-- Previous Page Link --}}
                                @if ($dataProfil->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link page-link-arrow">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
                                            </svg>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link page-link-arrow" href="{{ $dataProfil->previousPageUrl() }}">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
                                            </svg>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($dataProfil->getUrlRange(1, $dataProfil->lastPage()) as $page => $url)
                                    @if ($page == $dataProfil->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($dataProfil->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link page-link-arrow" href="{{ $dataProfil->nextPageUrl() }}">
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
.badge-primary { background-color: #007bff; color: white; }
.badge-danger { background-color: #dc3545; color: white; }
.badge-info { background-color: #17a2b8; color: white; }
.badge-warning { background-color: #ffc107; color: #000; }
.badge-success { background-color: #28a745; color: white; }

.text-muted-universal {
    color: #6c757d !important;
}

.fw-semibold-universal {
    font-weight: 600 !important;
}

/* Style untuk foto profil di tabel */
.profile-img-table {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}

.no-image-table {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    border: 2px dashed #dee2e6;
}

/* FORM STYLES - LEBAR DISAMAKAN SESUAI SEARCH */
.form-select-universal, .form-control-universal {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 14px;
    height: 42px;
    box-sizing: border-box;
}

/* Filter container */
.filter-container {
    width: 100%;
    max-width: 400px; /* SAMA DENGAN SEARCH */
}

.form-select-universal {
    width: 100%;
}

/* Search container */
.search-container {
    width: 100%;
    max-width: 400px; /* SAMA DENGAN FILTER */
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

.form-label-universal {
    font-weight: 500;
    margin-bottom: 6px;
    display: block;
    color: #374151;
    font-size: 14px;
}

/* Grid layout untuk filter dan search */
.row.g-3 > .col-md-6 {
    display: flex;
    flex-direction: column;
}

/* PAGINATION STYLES - TANPA TEKS NEXT/PREVIOUS */
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

/* Style untuk panah pagination (tanpa teks) */
.page-link-arrow {
    padding: 8px;
    min-width: 40px;
}

.page-link-arrow svg {
    width: 16px;
    height: 16px;
}

/* Info Filter */
.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 16px;
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

/* Responsive styles */
@media (max-width: 768px) {
    .row.g-3 > .col-md-6 {
        width: 100%;
        max-width: 100%;
    }

    .filter-container,
    .search-container {
        max-width: 100%;
    }

    .input-group-universal {
        flex-wrap: wrap;
    }

    .form-control-universal {
        width: 100%;
        margin-bottom: 8px;
    }

    .btn-search-universal,
    .btn-clear-universal {
        flex: 1;
        min-width: 45%;
    }

    .pagination {
        gap: 2px;
    }

    .page-link {
        padding: 6px 10px;
        min-width: 36px;
        height: 36px;
        font-size: 13px;
    }

    .page-link-arrow {
        min-width: 36px;
        height: 36px;
        padding: 6px;
    }
}
</style>
@endsection
