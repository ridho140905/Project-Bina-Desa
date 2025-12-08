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
                    Tambah Profil Desa
                </h1>
                <p>Form untuk menambahkan data profil desa baru</p>
            </div>
            <a href="{{ route('profil.index') }}" class="btn btn-light-universal btn-universal">
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
                <form action="{{ route('profil.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Kolom Kiri - Informasi Dasar Desa -->
                        <div class="col-md-6">
                            <div class="field-group">
                                <label class="form-label-universal">Nama Desa <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('nama_desa') is-danger @enderror"
                                           type="text"
                                           name="nama_desa"
                                           value="{{ old('nama_desa') }}"
                                           placeholder="Masukkan nama desa"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-home"></i></span>
                                </div>
                                @error('nama_desa')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="form-label-universal">Kecamatan <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('kecamatan') is-danger @enderror"
                                           type="text"
                                           name="kecamatan"
                                           value="{{ old('kecamatan') }}"
                                           placeholder="Masukkan nama kecamatan"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-map-marker"></i></span>
                                </div>
                                @error('kecamatan')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="form-label-universal">Kabupaten <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('kabupaten') is-danger @enderror"
                                           type="text"
                                           name="kabupaten"
                                           value="{{ old('kabupaten') }}"
                                           placeholder="Masukkan nama kabupaten"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-city"></i></span>
                                </div>
                                @error('kabupaten')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom Kanan - Informasi Wilayah & Upload -->
                        <div class="col-md-6">
                            <div class="field-group">
                                <label class="form-label-universal">Provinsi <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('provinsi') is-danger @enderror"
                                           type="text"
                                           name="provinsi"
                                           value="{{ old('provinsi') }}"
                                           placeholder="Masukkan nama provinsi"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-earth"></i></span>
                                </div>
                                @error('provinsi')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="form-label-universal">Telepon <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('telepon') is-danger @enderror"
                                           type="text"
                                           name="telepon"
                                           value="{{ old('telepon') }}"
                                           placeholder="Contoh: 081234567890"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-phone"></i></span>
                                </div>
                                @error('telepon')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="form-label-universal">Email <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('email') is-danger @enderror"
                                           type="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="contoh: desa@example.com"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-email"></i></span>
                                </div>
                                @error('email')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Upload Foto Profil -->
                            <div class="field-group">
                                <label class="form-label-universal">Foto Profil</label>
                                <div class="control">
                                    <input class="input-universal @error('foto_profil') is-danger @enderror"
                                           type="file"
                                           name="foto_profil"
                                           accept="image/*">
                                </div>
                                <small class="form-text text-muted">
                                    Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.
                                </small>
                                @error('foto_profil')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat Kantor - Full Width -->
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Alamat Kantor <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <textarea class="textarea-universal @error('alamat_kantor') is-danger @enderror"
                                              name="alamat_kantor"
                                              rows="3"
                                              placeholder="Masukkan alamat lengkap kantor desa"
                                              required>{{ old('alamat_kantor') }}</textarea>
                                    <span class="icon left"><i class="mdi mdi-office-building"></i></span>
                                </div>
                                @error('alamat_kantor')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Visi - Full Width -->
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Visi <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <textarea class="textarea-universal @error('visi') is-danger @enderror"
                                              name="visi"
                                              rows="4"
                                              placeholder="Tuliskan visi desa"
                                              required>{{ old('visi') }}</textarea>
                                    <span class="icon left"><i class="mdi mdi-target"></i></span>
                                </div>
                                @error('visi')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Misi - Full Width -->
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Misi <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <textarea class="textarea-universal @error('misi') is-danger @enderror"
                                              name="misi"
                                              rows="4"
                                              placeholder="Tuliskan misi desa"
                                              required>{{ old('misi') }}</textarea>
                                    <span class="icon left"><i class="mdi mdi-bullseye-arrow"></i></span>
                                </div>
                                @error('misi')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload File Pendukung Multiple -->
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">File Pendukung</label>
                                <div class="control">
                                    <input class="input-universal @error('file_pendukung') is-danger @enderror"
                                           type="file"
                                           name="file_pendukung[]"
                                           multiple
                                           accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
                                </div>
                                <small class="form-text text-muted">
                                    Format: JPG, JPEG, PNG, GIF, PDF, DOC, DOCX. Maksimal 5 file.
                                </small>
                                @error('file_pendukung')
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
                                        Simpan Data
                                    </button>
                                </div>
                                <div class="control">
                                    <a href="{{ route('profil.index') }}" class="btn btn-danger-universal btn-universal">
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
