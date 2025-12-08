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
                    Tambah Data Agenda
                </h1>
                <p>Form untuk menambahkan data agenda baru</p>
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
                <form action="{{ route('agenda.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Kolom Kiri - Informasi Dasar Agenda -->
                        <div class="col-md-6">
                            <div class="field-group">
                                <label class="form-label-universal">Judul Agenda <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('judul') is-danger @enderror"
                                           type="text"
                                           name="judul"
                                           value="{{ old('judul') }}"
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
                                           value="{{ old('lokasi') }}"
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
                                           value="{{ old('penyelenggara') }}"
                                           placeholder="Masukkan nama penyelenggara"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-account-group"></i></span>
                                </div>
                                @error('penyelenggara')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom Kanan - Informasi Waktu & Upload -->
                        <div class="col-md-6">
                            <div class="field-group">
                                <label class="form-label-universal">Tanggal Mulai <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('tanggal_mulai') is-danger @enderror"
                                           type="datetime-local"
                                           name="tanggal_mulai"
                                           value="{{ old('tanggal_mulai') }}"
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
                                           value="{{ old('tanggal_selesai') }}"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-calendar-check"></i></span>
                                </div>
                                @error('tanggal_selesai')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Upload Poster -->
                            <div class="field-group">
                                <label class="form-label-universal">Poster Agenda</label>
                                <div class="control">
                                    <input class="input-universal @error('poster') is-danger @enderror"
                                           type="file"
                                           name="poster"
                                           accept="image/*">
                                </div>
                                <small class="form-text text-muted">
                                    Format: JPG, JPEG, PNG, GIF, WebP. Maksimal 2MB.
                                </small>
                                @error('poster')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi - Full Width -->
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Deskripsi Agenda</label>
                                <div class="control icons-left">
                                    <textarea class="textarea-universal @error('deskripsi') is-danger @enderror"
                                              name="deskripsi"
                                              rows="4"
                                              placeholder="Masukkan deskripsi lengkap agenda (opsional)">{{ old('deskripsi') }}</textarea>
                                    <span class="icon left"><i class="mdi mdi-text"></i></span>
                                </div>
                                @error('deskripsi')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload Gambar Pendukung Multiple -->
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Gambar Pendukung</label>
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
                                        Simpan Agenda
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

.btn-success-universal:hover {
    background-color: #218838;
    transform: translateY(-1px);
}

.btn-danger-universal:hover {
    background-color: #c82333;
    transform: translateY(-1px);
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
    // Set min datetime for date inputs to current datetime
    const now = new Date();
    const timezoneOffset = now.getTimezoneOffset() * 60000;
    const localISOTime = new Date(now - timezoneOffset).toISOString().slice(0, 16);

    const startDateInput = document.querySelector('input[name="tanggal_mulai"]');
    const endDateInput = document.querySelector('input[name="tanggal_selesai"]');

    // Set minimum date to current datetime
    if (startDateInput) {
        startDateInput.min = localISOTime;
    }

    if (endDateInput) {
        endDateInput.min = localISOTime;
    }

    // Validate end date is after start date
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
