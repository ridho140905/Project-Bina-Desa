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
                    Edit Data Agenda - {{ $dataAgenda->judul }}
                </h1>
                <p>Form untuk mengubah data agenda</p>
            </div>
            <a href="{{ route('agenda.index') }}" class="btn btn-light-universal btn-universal">
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
                <form action="{{ route('agenda.update', $dataAgenda->agenda_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Kolom Kiri - Informasi Dasar Agenda --}}
                        <div class="col-md-6">
                            <div class="field-group">
                                <label class="form-label-universal">Judul Agenda <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('judul') is-danger @enderror"
                                           type="text"
                                           name="judul"
                                           value="{{ old('judul', $dataAgenda->judul) }}"
                                           placeholder="Masukkan judul agenda"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-format-title"></i></span>
                                </div>
                                @error('judul')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="form-label-universal">Lokasi <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('lokasi') is-danger @enderror"
                                           type="text"
                                           name="lokasi"
                                           value="{{ old('lokasi', $dataAgenda->lokasi) }}"
                                           placeholder="Masukkan lokasi agenda"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-map-marker"></i></span>
                                </div>
                                @error('lokasi')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="form-label-universal">Penyelenggara <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('penyelenggara') is-danger @enderror"
                                           type="text"
                                           name="penyelenggara"
                                           value="{{ old('penyelenggara', $dataAgenda->penyelenggara) }}"
                                           placeholder="Masukkan nama penyelenggara"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-account-group"></i></span>
                                </div>
                                @error('penyelenggara')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Kolom Kanan - Informasi Waktu & Upload --}}
                        <div class="col-md-6">
                            <div class="field-group">
                                <label class="form-label-universal">Tanggal Mulai <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('tanggal_mulai') is-danger @enderror"
                                           type="datetime-local"
                                           name="tanggal_mulai"
                                           value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($dataAgenda->tanggal_mulai)->format('Y-m-d\TH:i')) }}"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-calendar-clock"></i></span>
                                </div>
                                @error('tanggal_mulai')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="form-label-universal">Tanggal Selesai <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('tanggal_selesai') is-danger @enderror"
                                           type="datetime-local"
                                           name="tanggal_selesai"
                                           value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($dataAgenda->tanggal_selesai)->format('Y-m-d\TH:i')) }}"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-calendar-check"></i></span>
                                </div>
                                @error('tanggal_selesai')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Upload Poster --}}
                            @php
                                $poster = $dataAgenda->media->where('sort_order', 1)->first();
                            @endphp
                            <div class="field-group">
                                <label class="form-label-universal">Poster Agenda</label>

                                {{-- Preview Poster Saat Ini --}}
                                @if($poster)
                                    <div class="mb-3">
                                        <p class="text-sm text-muted">Poster Saat Ini:</p>
                                        <img src="{{ asset('storage/media/agenda/' . $poster->file_name) }}"
                                             alt="Poster {{ $dataAgenda->judul }}"
                                             class="profile-img-preview rounded"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <div class="no-image-preview" style="display: none;">
                                            <div class="no-image-placeholder">
                                                <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-xs text-muted mt-1">{{ $poster->file_name }}</p>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <p class="text-sm text-muted">Belum ada poster</p>
                                        <div class="no-image-placeholder">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                            </svg>
                                        </div>
                                    </div>
                                @endif

                                <div class="control">
                                    <input class="input-universal @error('poster') is-danger @enderror"
                                           type="file"
                                           name="poster"
                                           accept="image/*">
                                </div>
                                <small class="form-text text-muted">
                                    Biarkan kosong jika tidak ingin mengubah poster. Format: JPG, JPEG, PNG, GIF, WebP. Maksimal 2MB.
                                </small>
                                @error('poster')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi - Full Width --}}
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Deskripsi Agenda</label>
                                <div class="control icons-left">
                                    <textarea class="textarea-universal @error('deskripsi') is-danger @enderror"
                                              name="deskripsi"
                                              rows="4"
                                              placeholder="Masukkan deskripsi lengkap agenda (opsional)">{{ old('deskripsi', $dataAgenda->deskripsi) }}</textarea>
                                    <span class="icon left"><i class="mdi mdi-text"></i></span>
                                </div>
                                @error('deskripsi')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Upload Gambar Pendukung Multiple --}}
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Gambar Pendukung Tambahan</label>

                                {{-- Tampilkan Gambar Pendukung Saat Ini --}}
                                @php
                                    $gambarPendukung = $dataAgenda->media->where('sort_order', '>', 1);
                                @endphp

                                @if($gambarPendukung->count() > 0)
                                    <div class="mb-3">
                                        <p class="text-sm text-muted">Gambar Pendukung Saat Ini:</p>
                                        <div class="file-list">
                                            @foreach($gambarPendukung as $gambar)
                                                <div class="file-item d-flex align-items-center justify-content-between mb-2 p-2 bg-light rounded">
                                                    <div class="file-info">
                                                        <img src="{{ asset('storage/media/agenda/' . $gambar->file_name) }}"
                                                             alt="{{ $gambar->file_name }}"
                                                             class="gambar-preview-small me-3"
                                                             onerror="this.style.display='none';">
                                                        <div>
                                                            <span class="file-name">{{ $gambar->file_name }}</span>
                                                            <small class="text-muted d-block">{{ $gambar->mime_type }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="file-actions">
                                                        <a href="{{ asset('storage/media/agenda/' . $gambar->file_name) }}"
                                                           target="_blank"
                                                           class="btn btn-sm btn-primary me-2"
                                                           title="Lihat Gambar">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                                            </svg>
                                                        </a>
                                                        <form action="{{ route('agenda.delete-file', ['agenda' => $dataAgenda->agenda_id, 'file' => $gambar->media_id]) }}"
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Yakin ingin menghapus gambar ini?')"
                                                                    title="Hapus Gambar">
                                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="control">
                                    <input class="input-universal @error('gambar_pendukung') is-danger @enderror"
                                           type="file"
                                           name="gambar_pendukung[]"
                                           multiple
                                           accept="image/*">
                                </div>
                                <small class="form-text text-muted">
                                    Upload gambar tambahan selain poster. Format: JPG, JPEG, PNG, GIF, WebP. Maksimal 5 file, 2MB per file.
                                </small>
                                @error('gambar_pendukung')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                                @error('gambar_pendukung.*')
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
                                        Update Agenda
                                    </button>
                                </div>
                                <div class="control">
                                    <a href="{{ route('agenda.index') }}" class="btn btn-danger-universal btn-universal">
                                        <span class="icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                            </svg>
                                        </span>
                                        Batal
                                    </a>
                                </div>
                                <div class="control">
                                    <a href="{{ route('agenda.show', $dataAgenda->agenda_id) }}" class="btn btn-primary-universal btn-universal">
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
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-danger-universal {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-primary-universal {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-success-universal:hover {
    background-color: #218838;
    transform: translateY(-1px);
}

.btn-danger-universal:hover {
    background-color: #c82333;
    transform: translateY(-1px);
}

.btn-primary-universal:hover {
    background-color: #0056b3;
    transform: translateY(-1px);
}

.profile-img-preview {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    display: block;
}

.gambar-preview-small {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

.text-sm {
    font-size: 14px;
}

.text-xs {
    font-size: 12px;
}

.file-list {
    max-height: 200px;
    overflow-y: auto;
}

.file-item {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background-color: #f8f9fa;
}

.file-name {
    font-weight: 500;
    font-size: 14px;
}

.file-actions {
    display: flex;
    gap: 8px;
}

.file-actions .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 4px;
}

.no-image-placeholder {
    width: 150px;
    height: 150px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}

/* Style khusus untuk input datetime */
input[type="datetime-local"] {
    font-family: inherit;
}

/* Style untuk file input */
.input-universal[type="file"] {
    padding: 8px;
    background-color: #f8f9fa;
    border: 1px dashed #dee2e6;
}

.input-universal[type="file"]:focus {
    border-color: #3b82f6;
    border-style: solid;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate end date is after start date
    const startDateInput = document.querySelector('input[name="tanggal_mulai"]');
    const endDateInput = document.querySelector('input[name="tanggal_selesai"]');

    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;

            if (endDateInput.value && endDateInput.value < this.value) {
                endDateInput.value = this.value;
            }
        });

        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && this.value < startDateInput.value) {
                alert('Tanggal selesai harus setelah tanggal mulai');
                this.value = startDateInput.value;
            }
        });
    }

    // Validasi file size untuk poster
    const posterInput = document.querySelector('input[name="poster"]');
    if (posterInput) {
        posterInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('Ukuran file poster maksimal 2MB');
                    this.value = '';
                }
            }
        });
    }

    // Validasi file size untuk gambar pendukung
    const gambarInput = document.querySelector('input[name="gambar_pendukung[]"]');
    if (gambarInput) {
        gambarInput.addEventListener('change', function() {
            const files = this.files;
            const maxSize = 2 * 1024 * 1024; // 2MB per file
            const maxFiles = 5;

            if (files.length > maxFiles) {
                alert(`Maksimal ${maxFiles} gambar yang dapat diupload`);
                this.value = '';
                return;
            }

            for (let file of files) {
                if (file.size > maxSize) {
                    alert(`Gambar ${file.name} melebihi ukuran maksimal 2MB`);
                    this.value = '';
                    break;
                }

                // Validasi tipe file harus gambar
                if (!file.type.startsWith('image/')) {
                    alert(`File ${file.name} bukan gambar. Hanya file gambar yang diperbolehkan`);
                    this.value = '';
                    break;
                }
            }
        });
    }
});
</script>
@endsection
