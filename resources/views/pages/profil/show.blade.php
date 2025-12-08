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
                    Profil Desa - {{ $dataProfil->nama_desa }}
                </h1>
                <p>Informasi detail dan file pendukung profil desa</p>
            </div>
            <div class="btn-group-custom">
                <a href="{{ route('profil.index') }}" class="btn-light-universal">
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
            <!-- Informasi Profil Desa -->
            <div class="col-lg-6 mb-4">
                <div class="card-universal">
                    <div class="card-header-universal">
                        <h5 class="card-title-universal">
                            <span class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </span>
                            Informasi Profil Desa
                        </h5>
                    </div>
                    <div class="card-body-universal">
                        <!-- Foto Profil -->
                        @php
                            $fotoProfil = $dataProfil->media->where('sort_order', 1)->first();
                        @endphp
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                @if($fotoProfil)
                                    <img src="{{ asset('storage/media/profil/' . $fotoProfil->file_name) }}"
                                         alt="Foto Profil {{ $dataProfil->nama_desa }}"
                                         class="profile-img-detail">
                                @else
                                    <div class="no-image-detail">
                                        <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Tombol Edit & Hapus DI BAWAH FOTO -->
                            <div class="photo-action-bottom">
                                <a href="{{ route('profil.edit', $dataProfil->profil_id) }}"
                                   class="btn-edit-bottom"
                                   title="Edit Profil">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                    </svg>
                                    Edit
                                </a>
                                @if($fotoProfil)
                                <form action="{{ route('profil.delete-file', ['profil' => $dataProfil->profil_id, 'file' => $fotoProfil->media_id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn-delete-bottom"
                                            onclick="return confirm('Hapus foto profil?')"
                                            title="Hapus Foto">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>

                            <h4 class="mt-3 fw-bold">{{ $dataProfil->nama_desa }}</h4>
                            <p class="text-muted">{{ $dataProfil->kecamatan }}, {{ $dataProfil->kabupaten }}</p>
                        </div>

                        <div class="info-list">
                            <div class="info-item">
                                <span class="info-label">Nama Desa</span>
                                <span class="info-value">{{ $dataProfil->nama_desa }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Kecamatan</span>
                                <span class="info-value">{{ $dataProfil->kecamatan }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Kabupaten</span>
                                <span class="info-value">{{ $dataProfil->kabupaten }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Provinsi</span>
                                <span class="info-value">{{ $dataProfil->provinsi }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Telepon</span>
                                <span class="info-value">{{ $dataProfil->telepon }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email</span>
                                <span class="info-value">{{ $dataProfil->email }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Alamat Kantor</span>
                                <span class="info-value">{{ $dataProfil->alamat_kantor }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visi & Misi -->
            <div class="col-lg-6 mb-4">
                <div class="card-universal h-100">
                    <div class="card-header-universal">
                        <h5 class="card-title-universal">
                            <span class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </span>
                            Visi & Misi Desa
                        </h5>
                    </div>
                    <div class="card-body-universal">
                        <div class="mb-4">
                            <h6 class="section-title">Visi Desa</h6>
                            <div class="content-box">
                                {!! nl2br(e($dataProfil->visi)) !!}
                            </div>
                        </div>
                        <div>
                            <h6 class="section-title">Misi Desa</h6>
                            <div class="content-box">
                                {!! nl2br(e($dataProfil->misi)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload File Pendukung -->
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
                            Tambah File Pendukung
                        </h5>
                    </div>
                    <div class="card-body-universal">
                        <form action="{{ route('profil.update', $dataProfil->profil_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="field-group">
                                        <label class="form-label-universal">Pilih File</label>
                                        <div class="control">
                                            <input class="input-universal @error('file_pendukung') is-danger @enderror"
                                                   type="file"
                                                   name="file_pendukung[]"
                                                   multiple
                                                   accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
                                        </div>
                                        <small class="form-text text-muted">
                                            Format: JPG, JPEG, PNG, GIF, PDF, DOC, DOCX. Maksimal 2MB per file.
                                        </small>
                                        @error('file_pendukung')
                                            <p class="help is-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn-success-universal w-100">
                                        <span class="icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                                            </svg>
                                        </span>
                                        Upload Files
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar File Pendukung -->
        <div class="row">
            <div class="col-12">
                <div class="card-universal">
                    <div class="card-header-universal">
                        <h5 class="card-title-universal">
                            <span class="icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                                </svg>
                            </span>
                            File Pendukung ({{ $dataProfil->media->where('sort_order', '>', 1)->count() }})
                        </h5>
                    </div>
                    <div class="card-body-universal">
                        @php
                            $filePendukung = $dataProfil->media->where('sort_order', '>', 1);
                        @endphp

                        @if($filePendukung->count() > 0)
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
                                        @foreach($filePendukung as $file)
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        @if(in_array(pathinfo($file->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img src="{{ asset('storage/media/profil/files/' . $file->file_name) }}"
                                                                 alt="Thumbnail"
                                                                 class="file-thumbnail me-3"
                                                                 onerror="this.style.display='none'">
                                                        @else
                                                            <span class="file-icon me-3">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                                                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                                                                </svg>
                                                            </span>
                                                        @endif
                                                        <div>
                                                            <div class="fw-semibold">{{ $file->file_name }}</div>
                                                            <small class="text-muted">Uploaded: {{ $file->created_at->format('d/m/Y H:i') }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <span class="universal-badge badge-info">
                                                        {{ strtoupper(pathinfo($file->file_name, PATHINFO_EXTENSION)) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="action-buttons-near">
                                                        <a href="{{ asset('storage/media/profil/files/' . $file->file_name) }}"
                                                           target="_blank"
                                                           class="btn-primary-near"
                                                           title="Lihat File">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                                            </svg>
                                                        </a>
                                                        <form action="{{ route('profil.delete-file', ['profil' => $dataProfil->profil_id, 'file' => $file->media_id]) }}"
                                                              method="POST"
                                                              class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn-delete-near"
                                                                    onclick="return confirm('Hapus file {{ $file->file_name }}?')"
                                                                    title="Hapus File">
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
                                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                                    </svg>
                                </span>
                                Belum ada file pendukung
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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

/* Profile Image */
.profile-img-detail {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border: 4px solid #e2e8f0;
    border-radius: 50%;
}

.no-image-detail {
    width: 140px;
    height: 140px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    border: 4px dashed #dee2e6;
    margin: 0 auto;
    border-radius: 50%;
}

/* Photo Action Buttons - DI BAWAH FOTO */
.photo-action-bottom {
    display: flex;
    gap: 8px;
    align-items: center;
    justify-content: center;
    margin-top: 12px;
    width: 100%;
}

.btn-edit-bottom, .btn-delete-bottom {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.875rem;
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

/* Info List - Improved Layout */
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

/* Content Box */
.section-title {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 1rem;
}

.content-box {
    background-color: #f8f9fa;
    padding: 16px;
    border-radius: var(--border-radius);
    border-left: 4px solid var(--primary-color);
    white-space: pre-line;
    line-height: 1.6;
    min-height: 120px;
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

/* File List Table */
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

.file-thumbnail {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 4px;
}

.file-icon {
    display: inline-flex;
    align-items: center;
    color: #6b7280;
}

/* Action Buttons - DEKAT DENGAN TULISAN AKSI */
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

    .action-buttons-near {
        flex-direction: row;
        gap: 6px;
        justify-content: flex-start;
    }

    .btn-primary-near, .btn-delete-near {
        width: 32px;
        height: 32px;
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
@endsection
