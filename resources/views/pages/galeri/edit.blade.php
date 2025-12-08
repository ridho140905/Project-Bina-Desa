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
                    Edit Data Galeri - {{ $dataGaleri->judul }}
                </h1>
                <p>Form untuk mengubah data galeri</p>
            </div>
            <a href="{{ route('galeri.index') }}" class="btn btn-light-universal btn-universal">
                <span class="icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                </span>
                Kembali
            </a>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-universal">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-universal">
                <strong>Error!</strong> Terdapat kesalahan dalam pengisian form:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Card Form --}}
        <div class="card-universal">
            <div class="card-body-universal">
                <form action="{{ route('galeri.update', $dataGaleri->galeri_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Judul --}}
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Judul <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('judul') is-danger @enderror"
                                           type="text"
                                           name="judul"
                                           value="{{ old('judul', $dataGaleri->judul) }}"
                                           placeholder="Masukkan judul galeri"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-format-title"></i></span>
                                </div>
                                @error('judul')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Deskripsi</label>
                                <div class="control icons-left">
                                    <textarea class="textarea-universal @error('deskripsi') is-danger @enderror"
                                              name="deskripsi"
                                              rows="4"
                                              placeholder="Masukkan deskripsi galeri (opsional)">{{ old('deskripsi', $dataGaleri->deskripsi) }}</textarea>
                                    <span class="icon left"><i class="mdi mdi-text"></i></span>
                                </div>
                                @error('deskripsi')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Foto Saat Ini --}}
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Foto Saat Ini</label>

                                @if($dataGaleri->media->count() > 0)
                                    <div class="mb-3">
                                        <p class="text-sm text-muted mb-2">Foto yang sudah diupload:</p>
                                        <div class="row g-2">
                                            @foreach($dataGaleri->media as $foto)
                                                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                                    <div class="card photo-card">
                                                        <img src="{{ asset('storage/media/galeri/' . $foto->file_name) }}"
                                                             alt="Foto {{ $dataGaleri->judul }}"
                                                             class="photo-preview">
                                                        <div class="card-body p-2">
                                                            <small class="text-muted d-block text-truncate">{{ $foto->file_name }}</small>
                                                            <div class="mt-2">
                                                                <a href="{{ route('galeri.delete-file', ['galeri' => $dataGaleri->galeri_id, 'file' => $foto->media_id]) }}"
                                                                   class="btn btn-sm btn-danger w-100"
                                                                   onclick="return confirm('Yakin ingin menghapus foto ini?')">
                                                                    Hapus
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <p class="text-sm text-muted">Belum ada foto</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Upload Foto Tambahan --}}
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Tambah Foto Baru</label>
                                <div class="control">
                                    <input class="input-universal @error('foto') is-danger @enderror"
                                           type="file"
                                           name="foto[]"
                                           multiple
                                           accept=".jpg,.jpeg,.png,.gif">
                                </div>
                                <small class="form-text text-muted">
                                    Upload foto tambahan. Format: JPG, JPEG, PNG, GIF. Maksimal 5MB per file.
                                </small>
                                @error('foto')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                                @error('foto.*')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="col-12">
                            <div class="field grouped">
                                <div class="control">
                                    <button type="submit" class="btn btn-success-universal btn-universal">
                                        <span class="icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                                            </svg>
                                        </span>
                                        Update Galeri
                                    </button>
                                </div>
                                <div class="control">
                                    <a href="{{ route('galeri.index') }}" class="btn btn-danger-universal btn-universal">
                                        <span class="icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                            </svg>
                                        </span>
                                        Batal
                                    </a>
                                </div>
                                <div class="control">
                                    <a href="{{ route('galeri.show', $dataGaleri->galeri_id) }}" class="btn btn-primary-universal btn-universal">
                                        <span class="icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                            </svg>
                                        </span>
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.field-group {
    margin-bottom: 1.5rem;
}

.input-universal, .textarea-universal {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.input-universal:focus, .textarea-universal:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.textarea-universal {
    resize: vertical;
    min-height: 100px;
}

.control.icons-left {
    position: relative;
}

.control.icons-left .icon.left {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
}

.control.icons-left input,
.control.icons-left textarea {
    padding-left: 40px;
}

.form-text.text-muted {
    font-size: 12px;
    color: #6b7280;
    margin-top: 4px;
}

.help.is-danger {
    color: #dc3545;
    font-size: 12px;
    margin-top: 4px;
}

.input-universal.is-danger,
.textarea-universal.is-danger {
    border-color: #dc3545;
}

.field.grouped {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

.btn-success-universal {
    background-color: #28a745;
    color: white;
}

.btn-danger-universal {
    background-color: #dc3545;
    color: white;
}

.btn-primary-universal {
    background-color: #007bff;
    color: white;
}

.btn-success-universal:hover {
    background-color: #218838;
}

.btn-danger-universal:hover {
    background-color: #c82333;
}

.btn-primary-universal:hover {
    background-color: #0056b3;
}

/* PERBAIKAN KHUSUS UNTUK FOTO YANG LEBIH KECIL DAN RAPI */
.photo-card {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    overflow: hidden;
    transition: all 0.2s ease;
    height: 100%;
}

.photo-card:hover {
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.photo-preview {
    width: 100%;
    height: 80px; /* Diperkecil dari 150px */
    object-fit: cover;
    border-bottom: 1px solid #e2e8f0;
}

.text-sm {
    font-size: 14px;
}

.text-xs {
    font-size: 12px;
}

.card-body {
    padding: 0.5rem; /* Diperkecil dari 0.75rem */
}

/* Grid yang lebih rapat untuk foto */
.row.g-2 {
    --bs-gutter-x: 0.5rem;
    --bs-gutter-y: 0.5rem;
}

/* Text truncate untuk nama file panjang */
.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Spacing untuk bagian foto */
.mb-2 {
    margin-bottom: 0.5rem !important;
}

.mb-3 {
    margin-bottom: 1rem !important;
}

.mt-2 {
    margin-top: 0.5rem !important;
}

/* Responsive grid untuk foto */
.col-6 {
    flex: 0 0 auto;
    width: 50%;
}

.col-sm-4 {
    flex: 0 0 auto;
    width: 33.333333%;
}

.col-md-3 {
    flex: 0 0 auto;
    width: 25%;
}

.col-lg-2 {
    flex: 0 0 auto;
    width: 16.666667%;
}
</style>
@endsection
