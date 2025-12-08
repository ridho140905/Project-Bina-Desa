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
                    Tambah Data Galeri
                </h1>
                <p>Form untuk menambahkan data galeri baru</p>
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
                <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Judul -->
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Judul <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('judul') is-danger @enderror"
                                           type="text"
                                           name="judul"
                                           value="{{ old('judul') }}"
                                           placeholder="Masukkan judul galeri"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-format-title"></i></span>
                                </div>
                                @error('judul')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Deskripsi</label>
                                <div class="control icons-left">
                                    <textarea class="textarea-universal @error('deskripsi') is-danger @enderror"
                                              name="deskripsi"
                                              rows="4"
                                              placeholder="Masukkan deskripsi galeri (opsional)">{{ old('deskripsi') }}</textarea>
                                    <span class="icon left"><i class="mdi mdi-text"></i></span>
                                </div>
                                @error('deskripsi')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Foto Multiple -->
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Foto <span class="text-danger">*</span></label>
                                <div class="control">
                                    <input class="input-universal @error('foto') is-danger @enderror"
                                           type="file"
                                           name="foto[]"
                                           multiple
                                           accept=".jpg,.jpeg,.png,.gif"
                                           required>
                                </div>
                                <small class="form-text text-muted">
                                    Format: JPG, JPEG, PNG, GIF. Maksimal 5MB per file. Dapat memilih multiple file.
                                </small>
                                @error('foto')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                                @error('foto.*')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12">
                            <div class="field grouped">
                                <div class="control">
                                    <button type="submit" class="btn btn-success-universal btn-universal">
                                        <span class="icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                                            </svg>
                                        </span>
                                        Simpan Galeri
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
}

.btn-success-universal {
    background-color: #28a745;
    color: white;
}

.btn-danger-universal {
    background-color: #dc3545;
    color: white;
}

.btn-success-universal:hover {
    background-color: #218838;
}

.btn-danger-universal:hover {
    background-color: #c82333;
}
</style>
@endsection
