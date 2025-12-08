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
                            <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </span>
                    Data Agenda
                </h1>
                <p>Manajemen data agenda kegiatan</p>
            </div>
            <a href="{{ route('agenda.create') }}" class="btn btn-light-universal btn-universal">
                <span class="icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                </span>
                Tambah Agenda
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
                <form method="GET" action="{{ route('agenda.index') }}" class="mb-3">
                    <div class="row g-2 align-items-center">
                        {{-- Filter Penyelenggara --}}
                        <div class="col-auto">
                            <select name="penyelenggara" class="form-select-compact" onchange="this.form.submit()">
                                <option value="">Semua Penyelenggara</option>
                                @php
                                    $penyelenggaraList = App\Models\Agenda::distinct()->pluck('penyelenggara');
                                @endphp
                                @foreach($penyelenggaraList as $penyelenggara)
                                    <option value="{{ $penyelenggara }}" {{ request('penyelenggara') == $penyelenggara ? 'selected' : '' }}>
                                        {{ $penyelenggara }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Search --}}
                        <div class="col-auto flex-grow-1">
                            <div class="search-box-compact">
                                <input type="text" name="search" class="search-input-compact"
                                       value="{{ request('search') }}" placeholder="Cari agenda...">
                                <button type="submit" class="search-btn-compact">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                    </svg>
                                </button>
                                @if(request('search') || request('penyelenggara'))
                                    <a href="{{ route('agenda.index') }}" class="clear-btn-compact" title="Clear All">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Info Jumlah Data --}}
                        <div class="col-auto">
                            <div class="data-count-compact">
                                <small>{{ $dataAgenda->total() }} data</small>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Info Filter Aktif --}}
                @if(request('search') || request('penyelenggara'))
                <div class="filter-active-compact">
                    <div class="filter-badges-compact">
                        @if(request('search'))
                            <span class="filter-badge-compact">
                                "{{ request('search') }}"
                                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="filter-remove-compact">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                    </svg>
                                </a>
                            </span>
                        @endif
                        @if(request('penyelenggara'))
                            <span class="filter-badge-compact">
                                {{ request('penyelenggara') }}
                                <a href="{{ request()->fullUrlWithQuery(['penyelenggara' => null]) }}" class="filter-remove-compact">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                    </svg>
                                </a>
                            </span>
                        @endif
                    </div>
                </div>
                @endif

                <div class="table-responsive table-responsive-universal">
                    <table class="table universal-table">
                        <thead>
                            <tr>
                                <th width="30" class="text-center">#</th>
                                <th width="40">Poster</th>
                                <th>Judul Agenda</th>
                                <th width="100">Lokasi</th>
                                <th width="120">Tanggal Mulai</th>
                                <th width="120">Tanggal Selesai</th>
                                <th width="100">Penyelenggara</th>
                                <th width="80">Status</th>
                                <th width="100" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataAgenda as $item)
                                @php
                                    $poster = $item->media->where('sort_order', 1)->first();
                                @endphp
                                <tr>
                                    <td class="text-center text-muted-universal">
                                        {{ ($dataAgenda->currentPage() - 1) * $dataAgenda->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        @if($poster)
                                            <img src="{{ asset('storage/media/agenda/' . $poster->file_name) }}"
                                                 alt="{{ $item->judul }}"
                                                 class="profile-img-table"
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
                                    <td>
                                        <div class="agenda-title-compact">
                                            <div class="fw-semibold-universal">{{ Str::limit($item->judul, 40) }}</div>
                                        </div>
                                    </td>
                                    <td><span class="universal-badge badge-info">{{ Str::limit($item->lokasi, 12) }}</span></td>
                                    <td>
                                        <span class="universal-badge badge-primary">
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/y H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="universal-badge badge-warning">
                                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/y H:i') }}
                                        </span>
                                    </td>
                                    <td><span class="universal-badge badge-success">{{ Str::limit($item->penyelenggara, 12) }}</span></td>
                                    <td>
                                        @php
                                            $now = now();
                                            $start = \Carbon\Carbon::parse($item->tanggal_mulai);
                                            $end = \Carbon\Carbon::parse($item->tanggal_selesai);

                                            if ($now->lt($start)) {
                                                $status = 'Akan Datang';
                                                $badgeClass = 'badge-info';
                                            } elseif ($now->between($start, $end)) {
                                                $status = 'Berlangsung';
                                                $badgeClass = 'badge-success';
                                            } else {
                                                $status = 'Selesai';
                                                $badgeClass = 'badge-secondary';
                                            }
                                        @endphp
                                        <span class="universal-badge {{ $badgeClass }}">{{ $status }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons-compact">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('agenda.show', $item->agenda_id) }}"
                                               class="btn btn-primary btn-xs"
                                               title="Detail Agenda">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                                </svg>
                                            </a>

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('agenda.edit', $item->agenda_id) }}"
                                               class="btn btn-edit btn-xs"
                                               title="Edit Agenda">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                            </a>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('agenda.destroy', $item->agenda_id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-delete btn-xs"
                                                        onclick="return confirm('Yakin ingin menghapus agenda {{ $item->judul }}?')"
                                                        title="Hapus Agenda">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="empty-state-universal">
                                        <span class="icon">
                                            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                            </svg>
                                        </span>
                                        @if(request('search') || request('penyelenggara'))
                                            Data tidak ditemukan
                                        @else
                                            Belum ada data agenda
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($dataAgenda->hasPages())
                    <div class="mt-3">
                        {{ $dataAgenda->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* COMPACT FORM STYLES */
.form-select-compact {
    border: 1px solid #d1d5db;
    border-radius: 4px;
    padding: 4px 8px;
    font-size: 12px;
    height: 28px;
    width: 150px;
    background-color: white;
}

.search-box-compact {
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 250px;
}

.search-input-compact {
    border: 1px solid #d1d5db;
    border-radius: 4px 0 0 4px;
    border-right: none;
    padding: 4px 8px;
    font-size: 12px;
    height: 28px;
    flex: 1;
}

.search-btn-compact {
    background: #3b82f6;
    border: 1px solid #3b82f6;
    border-left: none;
    border-radius: 0 4px 4px 0;
    padding: 4px 8px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 28px;
    transition: all 0.2s ease;
}

.search-btn-compact:hover {
    background: #2563eb;
}

.clear-btn-compact {
    background: #6b7280;
    border: 1px solid #6b7280;
    border-left: none;
    border-radius: 0;
    padding: 4px 6px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 28px;
    margin-left: 1px;
    transition: all 0.2s ease;
}

.clear-btn-compact:hover {
    background: #4b5563;
}

.data-count-compact {
    font-size: 11px;
    color: #6b7280;
    white-space: nowrap;
}

/* COMPACT FILTER BADGES */
.filter-active-compact {
    margin-bottom: 12px;
}

.filter-badges-compact {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.filter-badge-compact {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #f3f4f6;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    padding: 2px 6px;
    font-size: 11px;
    color: #374151;
}

.filter-remove-compact {
    display: flex;
    align-items: center;
    color: #6b7280;
    text-decoration: none;
    transition: color 0.2s;
}

.filter-remove-compact:hover {
    color: #ef4444;
}

/* COMPACT ACTION BUTTONS */
.action-buttons-compact {
    display: flex;
    gap: 4px;
    justify-content: center;
    align-items: center;
}

.action-buttons-compact form {
    display: flex !important;
    margin: 0 !important;
}

.btn-edit, .btn-delete, .btn-primary {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    padding: 0;
    border: none;
    border-radius: 4px;
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

/* COMPACT TABLE STYLES */
.profile-img-table {
    width: 30px;
    height: 30px;
    border-radius: 4px;
    object-fit: cover;
    border: 1px solid #e2e8f0;
}

.no-image-table {
    width: 30px;
    height: 30px;
    border-radius: 4px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    border: 1px dashed #dee2e6;
}

.agenda-title-compact .fw-semibold-universal {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    line-height: 1.2;
}

.universal-badge {
    display: inline-flex;
    align-items: center;
    gap: 2px;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 10px;
    font-weight: 500;
    white-space: nowrap;
}

.badge-secondary { background-color: #6c757d; color: white; }
.badge-primary { background-color: #007bff; color: white; }
.badge-info { background-color: #17a2b8; color: white; }
.badge-warning { background-color: #ffc107; color: #000; }
.badge-success { background-color: #28a745; color: white; }

/* COMPACT PAGINATION */
.pagination {
    display: flex;
    padding-left: 0;
    list-style: none;
    gap: 2px;
    justify-content: center;
    flex-wrap: wrap;
}

.page-link {
    position: relative;
    display: block;
    padding: 4px 8px;
    font-size: 11px;
    color: #3b82f6;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #d1d5db;
    border-radius: 4px;
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

/* COMPACT EMPTY STATE */
.empty-state-universal {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 20px !important;
    color: #6c757d;
    text-align: center;
    font-size: 12px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .form-select-compact {
        width: 120px;
    }

    .search-box-compact {
        max-width: 200px;
    }

    .table-responsive-universal {
        font-size: 11px;
    }

    .universal-badge {
        font-size: 9px;
        padding: 1px 4px;
    }
}

@media (max-width: 576px) {
    .row.g-2.align-items-center {
        gap: 8px !important;
    }

    .col-auto {
        margin-bottom: 4px;
    }

    .form-select-compact {
        width: 100px;
    }

    .search-box-compact {
        max-width: 150px;
    }
}
</style>
@endsection
