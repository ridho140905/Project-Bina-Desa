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
                    Detail Galeri - {{ Str::limit($dataGaleri->judul, 50) }}
                </h1>
                <p>Informasi detail dan foto-foto dalam galeri</p>
            </div>
            <div class="btn-group-custom">
                <a href="{{ route('galeri.index') }}" class="btn-light-universal">
                    <span class="icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                        </svg>
                    </span>
                    Kembali
                </a>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-universal">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-universal">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <!-- Informasi Galeri -->
            <div class="col-lg-6 mb-4">
                <div class="card-universal">
                    <div class="card-header-universal">
                        <h5 class="card-title-universal">
                            <span class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                </svg>
                            </span>
                            Informasi Galeri
                        </h5>
                    </div>
                    <div class="card-body-universal">
                        <!-- Foto Utama -->
                        @php
                            // Gunakan accessor fotoUtama dari model
                            $fotoUtama = $dataGaleri->fotoUtama;
                        @endphp
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                @if($fotoUtama)
                                    <img src="{{ asset('storage/media/galeri/' . $fotoUtama->file_name) }}"
                                         alt="Foto Utama {{ $dataGaleri->judul }}"
                                         class="poster-img-detail">
                                @else
                                    <div class="no-poster-detail">
                                        <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Informasi Foto Utama -->
                            @if($fotoUtama)
                                <div class="photo-info mt-2">
                                    <small class="text-muted d-block">Foto Utama</small>
                                    <small class="text-muted">File: {{ $fotoUtama->file_name }}</small>
                                    @if($fotoUtama->file_size)
                                        <small class="text-muted"> | Size: {{ round($fotoUtama->file_size / 1024, 2) }} KB</small>
                                    @endif
                                </div>
                            @endif

                            <!-- Tombol Edit & Hapus Foto Utama -->
                            <div class="photo-action-bottom mt-3">
                                <a href="{{ route('galeri.edit', $dataGaleri->galeri_id) }}"
                                   class="btn-edit-bottom"
                                   title="Edit Galeri">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                    </svg>
                                    Edit Galeri
                                </a>

                                @if($fotoUtama)
                                <form action="{{ route('galeri.delete-file', ['galeri' => $dataGaleri->galeri_id, 'file' => $fotoUtama->media_id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn-delete-bottom"
                                            onclick="return confirm('Hapus foto utama galeri?')"
                                            title="Hapus Foto Utama">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                        Hapus Foto Utama
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>

                        <div class="info-list">
                            <div class="info-item">
                                <span class="info-label">Judul Galeri</span>
                                <span class="info-value">{{ $dataGaleri->judul }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Jumlah Foto</span>
                                <span class="info-value">{{ $dataGaleri->media->count() }} foto</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Foto Utama</span>
                                <span class="info-value">
                                    @if($fotoUtama)
                                        <span class="badge badge-success">Ada</span>
                                    @else
                                        <span class="badge badge-warning">Tidak ada</span>
                                    @endif
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Foto Pendukung</span>
                                <span class="info-value">
                                    {{ $dataGaleri->fotoPendukung->count() }} foto
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tanggal Dibuat</span>
                                <span class="info-value">{{ $dataGaleri->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Terakhir Diupdate</span>
                                <span class="info-value">{{ $dataGaleri->updated_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi Galeri -->
            <div class="col-lg-6 mb-4">
                <div class="card-universal h-100">
                    <div class="card-header-universal">
                        <h5 class="card-title-universal">
                            <span class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h10v2zm0-4H7V7h10v2z"/>
                                </svg>
                            </span>
                            Deskripsi Galeri
                        </h5>
                    </div>
                    <div class="card-body-universal">
                        <div class="content-box">
                            @if($dataGaleri->deskripsi)
                                {!! nl2br(e($dataGaleri->deskripsi)) !!}
                            @else
                                <div class="text-center text-muted py-4">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="mb-3">
                                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                    </svg>
                                    <p>Belum ada deskripsi galeri</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Foto Tambahan -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card-universal">
                    <div class="card-header-universal">
                        <h5 class="card-title-universal">
                            <span class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                                </svg>
                            </span>
                            Tambah Foto Pendukung Baru
                        </h5>
                        <div class="card-header-info">
                            <small>Hanya untuk menambahkan foto pendukung. Foto utama dapat dihapus dengan tombol di atas.</small>
                        </div>
                    </div>
                    <div class="card-body-universal">
                        <form action="{{ route('galeri.upload-files', $dataGaleri->galeri_id) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="field-group">
                                        <label class="form-label-universal">Pilih Foto Pendukung</label>
                                        <div class="control">
                                            <input class="input-universal @error('foto_pendukung') is-danger @enderror"
                                                   type="file"
                                                   name="foto_pendukung[]"
                                                   id="fotoPendukungInput"
                                                   multiple
                                                   accept="image/*">
                                        </div>
                                        <small class="form-text text-muted">
                                            Format: JPG, JPEG, PNG, GIF, WebP. Maksimal 5 file, 5MB per file.
                                        </small>
                                        @error('foto_pendukung')
                                            <p class="help is-danger">{{ $message }}</p>
                                        @enderror
                                        @error('foto_pendukung.*')
                                            <p class="help is-danger">{{ $message }}</p>
                                        @enderror
                                        <div id="fileListPreview" class="mt-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn-success-universal w-100" id="uploadBtn">
                                        <span class="icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                                            </svg>
                                        </span>
                                        Upload Foto
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Foto Pendukung - TABEL -->
        <div class="row">
            <div class="col-12">
                <div class="card-universal">
                    <div class="card-header-universal">
                        <h5 class="card-title-universal">
                            <span class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                </svg>
                            </span>
                            Foto Pendukung ({{ $dataGaleri->fotoPendukung->count() }})
                        </h5>
                        <div class="card-header-info">
                            <small>Foto-foto pendukung dalam galeri ini. Foto utama tidak ditampilkan di sini.</small>
                        </div>
                    </div>
                    <div class="card-body-universal">
                        @php
                            // Gunakan accessor fotoPendukung dari model
                            $fotoPendukung = $dataGaleri->fotoPendukung;
                        @endphp

                        @if($fotoPendukung->count() > 0)
                            <div class="table-responsive table-responsive-universal">
                                <table class="table universal-table">
                                    <thead>
                                        <tr>
                                            <th width="50%">Nama File</th>
                                            <th width="20%">Tipe File</th>
                                            <th width="30%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($fotoPendukung as $foto)
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div class="file-thumbnail-container me-3">
                                                            <img src="{{ asset('storage/media/galeri/' . $foto->file_name) }}"
                                                                 alt="Thumbnail {{ $foto->file_name }}"
                                                                 class="file-thumbnail"
                                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                            <div class="file-icon" style="display: none;">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ $foto->file_name }}</div>
                                                            <small class="text-muted">Uploaded: {{ $foto->created_at->format('d/m/Y H:i') }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="universal-badge badge-info">
                                                        {{ strtoupper(pathinfo($foto->file_name, PATHINFO_EXTENSION)) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="action-buttons-near">
                                                        <a href="{{ asset('storage/media/galeri/' . $foto->file_name) }}"
                                                           target="_blank"
                                                           class="btn-primary-near"
                                                           title="Lihat Foto">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                                            </svg>
                                                        </a>
                                                        <form action="{{ route('galeri.delete-file', ['galeri' => $dataGaleri->galeri_id, 'file' => $foto->media_id]) }}"
                                                              method="POST"
                                                              class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn-delete-near"
                                                                    onclick="return confirm('Hapus foto {{ $foto->file_name }}?')"
                                                                    title="Hapus Foto">
                                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state-universal">
                                <span class="icon">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                    </svg>
                                </span>
                                Belum ada foto pendukung dalam galeri ini
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS untuk bagian tabel -->
<style>
/* Table Styles */
.table-responsive-universal {
    border-radius: var(--border-radius);
    overflow: hidden;
}

.universal-table {
    width: 100%;
    border-collapse: collapse;
}

.universal-table th {
    background-color: #f8fafc;
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e2e8f0;
}

.universal-table td {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.universal-table tr:last-child td {
    border-bottom: none;
}

.file-thumbnail-container {
    position: relative;
    display: flex;
    align-items: center;
}

.file-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

.file-icon {
    display: inline-flex;
    align-items: center;
    color: #6b7280;
}

/* Action Buttons */
.action-buttons-near {
    display: flex;
    gap: 8px;
    justify-content: flex-start;
    align-items: center;
    height: 100%;
    flex-wrap: nowrap;
    margin: 0;
    padding: 0;
}

.action-buttons-near form {
    display: flex;
    margin: 0;
    align-items: center;
}

.btn-primary-near, .btn-delete-near {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    padding: 0;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.btn-primary-near {
    background-color: var(--primary-color);
    color: #fff;
}

.btn-primary-near:hover {
    background-color: #2563eb;
    transform: translateY(-1px);
}

.btn-delete-near {
    background-color: var(--danger-color);
    color: #fff;
}

.btn-delete-near:hover {
    background-color: #dc2626;
    transform: translateY(-1px);
}

/* Badge */
.universal-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-info {
    background-color: #dbeafe;
    color: #1e40af;
}

/* CSS lainnya tetap sama seperti sebelumnya */
:root {
    --primary-color: #3b82f6;
    --secondary-color: #64748b;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --light-color: #f8fafc;
    --dark-color: #1e293b;
    --border-radius: 8px;
    --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Header Styles */
.page-header-primary {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 20px;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    margin-bottom: 24px;
}

.page-header-primary h1 {
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--dark-color);
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.page-header-primary p {
    color: var(--secondary-color);
    margin: 0;
}

/* Card Header Info */
.card-header-info {
    font-size: 0.85rem;
    color: #6b7280;
    margin-top: 4px;
    font-style: italic;
}

/* Button Styles */
.btn-group-custom {
    display: flex;
    gap: 12px;
    align-items: center;
}

.btn-light-universal {
    background-color: var(--light-color);
    color: var(--dark-color);
    border: 1px solid #e2e8f0;
    padding: 10px 16px;
    border-radius: var(--border-radius);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-light-universal:hover {
    background-color: #e2e8f0;
    transform: translateY(-1px);
    color: var(--dark-color);
}

/* Card Styles */
.card-universal {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    overflow: hidden;
    margin-bottom: 24px;
    height: 100%;
}

.card-header-universal {
    padding: 16px 20px;
    background-color: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

.card-title-universal {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--dark-color);
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}

.card-body-universal {
    padding: 20px;
}

/* Poster Image */
.poster-img-detail {
    width: 100%;
    max-width: 300px;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    position: relative;
}

/* Informasi Foto Utama */
.photo-info {
    font-size: 0.8rem;
}

/* Tombol Edit & Hapus Foto Utama */
.photo-action-bottom {
    display: flex;
    gap: 8px;
    align-items: center;
    justify-content: center;
    margin-top: 16px;
    width: 100%;
}

.btn-edit-bottom, .btn-delete-bottom {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
    white-space: nowrap;
    cursor: pointer;
}

.btn-edit-bottom {
    background-color: var(--warning-color);
    color: white;
}

.btn-edit-bottom:hover {
    background-color: #e0a800;
    transform: translateY(-1px);
    color: white;
}

.btn-delete-bottom {
    background-color: var(--danger-color);
    color: white;
}

.btn-delete-bottom:hover {
    background-color: #dc2626;
    transform: translateY(-1px);
}

.no-poster-detail {
    width: 100%;
    max-width: 300px;
    height: 200px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    border: 2px dashed #dee2e6;
    margin: 0 auto;
    border-radius: 12px;
}

/* Info List */
.info-list {
    display: grid;
    grid-template-columns: 1fr;
    gap: 12px;
}

.info-item {
    display: flex;
    flex-direction: column;
    padding: 12px 0;
    border-bottom: 1px solid #f1f1f1;
}

.info-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 4px;
    font-size: 0.9rem;
}

.info-value {
    color: #6b7280;
    font-size: 1rem;
}

/* Badge styling */
.badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-success {
    background-color: #d1fae5;
    color: #065f46;
}

.badge-warning {
    background-color: #fef3c7;
    color: #92400e;
}

/* Content Box */
.content-box {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: var(--border-radius);
    border-left: 4px solid var(--primary-color);
    white-space: pre-line;
    line-height: 1.6;
    min-height: 200px;
    max-height: 400px;
    overflow-y: auto;
}

.content-box::-webkit-scrollbar {
    width: 6px;
}

.content-box::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.content-box::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.content-box::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* File Upload */
.field-group {
    margin-bottom: 16px;
}

.form-label-universal {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    display: block;
}

.input-universal {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: border-color 0.2s;
}

.input-universal:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-success-universal {
    background-color: var(--success-color);
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: var(--border-radius);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
    width: 100%;
    justify-content: center;
}

.btn-success-universal:hover {
    background-color: #0da271;
    transform: translateY(-1px);
    color: white;
}

/* File List Preview */
#fileListPreview {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
}

.file-preview-item {
    position: relative;
    display: inline-block;
    margin: 5px;
    text-align: center;
    vertical-align: top;
}

.file-preview-item img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.file-preview-item .file-name {
    font-size: 10px;
    margin-top: 2px;
    color: #666;
    word-break: break-all;
    max-width: 60px;
}

/* Empty State */
.empty-state-universal {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 40px !important;
    color: #6c757d;
    text-align: center;
}

/* Alert */
.alert-universal {
    padding: 12px 16px;
    border-radius: var(--border-radius);
    margin-bottom: 20px;
    border-left: 4px solid;
}

.alert-success {
    background-color: #d1fae5;
    border-color: var(--success-color);
    color: #065f46;
}

.alert-danger {
    background-color: #fee2e2;
    border-color: var(--danger-color);
    color: #991b1b;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-primary {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .btn-group-custom {
        width: 100%;
        justify-content: flex-start;
    }

    .info-list {
        grid-template-columns: 1fr;
    }

    .photo-action-bottom {
        flex-direction: column;
        gap: 6px;
    }

    .btn-edit-bottom, .btn-delete-bottom {
        padding: 6px 10px;
        font-size: 0.8rem;
    }

    .universal-table th,
    .universal-table td {
        padding: 12px 8px;
    }

    .file-thumbnail {
        width: 40px;
        height: 40px;
    }

    .poster-img-detail {
        max-width: 200px;
        height: 150px;
    }

    .no-poster-detail {
        max-width: 200px;
        height: 150px;
    }

    .btn-primary-near, .btn-delete-near {
        width: 32px;
        height: 32px;
    }
}

@media (min-width: 992px) {
    .info-list {
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .info-item {
        padding: 8px 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validasi file untuk foto pendukung
    const fotoPendukungInput = document.getElementById('fotoPendukungInput');
    const fileListPreview = document.getElementById('fileListPreview');

    if (fotoPendukungInput) {
        fotoPendukungInput.addEventListener('change', function() {
            const files = this.files;
            const maxSize = 5 * 1024 * 1024; // 5MB per file
            const maxFiles = 5; // Maksimal 5 file

            // Clear previous preview
            fileListPreview.innerHTML = '';

            if (files.length > maxFiles) {
                alert(`Maksimal ${maxFiles} foto yang dapat diupload`);
                this.value = '';
                return;
            }

            for (let file of files) {
                if (file.size > maxSize) {
                    alert(`Foto ${file.name} melebihi ukuran maksimal 5MB`);
                    this.value = '';
                    fileListPreview.innerHTML = '';
                    break;
                }

                // Validasi tipe file harus gambar
                if (!file.type.startsWith('image/')) {
                    alert(`File ${file.name} bukan gambar. Hanya file gambar yang diperbolehkan`);
                    this.value = '';
                    fileListPreview.innerHTML = '';
                    break;
                }

                // Create preview untuk setiap file
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'file-preview-item';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Preview Foto';

                        const name = document.createElement('div');
                        name.className = 'file-name';
                        name.textContent = file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name;

                        previewItem.appendChild(img);
                        previewItem.appendChild(name);
                        fileListPreview.appendChild(previewItem);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    }

    // Form submission handling
    const uploadForm = document.getElementById('uploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            const files = document.getElementById('fotoPendukungInput').files;
            const uploadBtn = document.getElementById('uploadBtn');

            // Validasi minimal satu file
            if (files.length === 0) {
                e.preventDefault();
                alert('Pilih foto terlebih dahulu!');
                return false;
            }

            // Show loading state
            uploadBtn.disabled = true;
            uploadBtn.innerHTML = `
                <span class="icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </span>
                Mengupload...
            `;
        });
    }
});
</script>
@endsection
