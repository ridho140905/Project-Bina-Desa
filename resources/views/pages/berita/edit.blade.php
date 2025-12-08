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
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </span>
                    Edit Berita - {{ Str::limit($berita->judul, 50) }}
                </h1>
                <p>Form untuk mengubah data berita</p>
            </div>
            <a href="{{ route('berita.index') }}" class="btn btn-light-universal btn-universal">
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
                <form action="{{ route('berita.update', $berita->berita_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Kolom Kiri - Informasi Dasar Berita -->
                        <div class="col-md-6">
                            <div class="field-group">
                                <label class="form-label-universal">Judul Berita <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('judul') is-danger @enderror"
                                           type="text"
                                           name="judul"
                                           value="{{ old('judul', $berita->judul) }}"
                                           placeholder="Masukkan judul berita"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-format-title"></i></span>
                                </div>
                                @error('judul')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="form-label-universal">Slug <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('slug') is-danger @enderror"
                                           type="text"
                                           name="slug"
                                           value="{{ old('slug', $berita->slug) }}"
                                           placeholder="judul-berita-url"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-link"></i></span>
                                </div>
                                @error('slug')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                                <small class="form-text text-muted">
                                    Slug akan digunakan untuk URL berita. Gunakan huruf kecil dan tanda strip (-)
                                </small>
                            </div>

                            <div class="field-group">
                                <label class="form-label-universal">Kategori <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <select class="input-universal @error('kategori_id') is-danger @enderror"
                                            name="kategori_id"
                                            required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoriBerita as $kategori)
                                            <option value="{{ $kategori->kategori_id }}"
                                                {{ old('kategori_id', $berita->kategori_id) == $kategori->kategori_id ? 'selected' : '' }}>
                                                {{ $kategori->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="icon left"><i class="mdi mdi-tag"></i></span>
                                </div>
                                @error('kategori_id')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom Kanan - Informasi Tambahan & Upload -->
                        <div class="col-md-6">
                            <div class="field-group">
                                <label class="form-label-universal">Penulis <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('penulis') is-danger @enderror"
                                           type="text"
                                           name="penulis"
                                           value="{{ old('penulis', $berita->penulis) }}"
                                           placeholder="Nama penulis berita"
                                           required>
                                    <span class="icon left"><i class="mdi mdi-account"></i></span>
                                </div>
                                @error('penulis')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="form-label-universal">Status <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <select class="input-universal @error('status') is-danger @enderror"
                                            name="status"
                                            required>
                                        <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="terbit" {{ old('status', $berita->status) == 'terbit' ? 'selected' : '' }}>Terbit</option>
                                    </select>
                                    <span class="icon left"><i class="mdi mdi-bullhorn"></i></span>
                                </div>
                                @error('status')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field-group">
                                <label class="form-label-universal">Tanggal Terbit</label>
                                <div class="control icons-left">
                                    <input class="input-universal @error('terbit_at') is-danger @enderror"
                                           type="datetime-local"
                                           name="terbit_at"
                                           value="{{ old('terbit_at', $berita->terbit_at ? $berita->terbit_at->format('Y-m-d\TH:i') : '') }}"
                                           placeholder="Tanggal terbit otomatis jika status terbit">
                                    <span class="icon left"><i class="mdi mdi-calendar-clock"></i></span>
                                </div>
                                @error('terbit_at')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                                <small class="form-text text-muted">
                                    Kosongkan untuk menggunakan tanggal saat ini ketika status diubah ke "Terbit"
                                </small>
                            </div>

                            <!-- Upload Cover Foto -->
                            @php
                                $coverFoto = $berita->media->where('sort_order', 1)->first();
                            @endphp
                            <div class="field-group">
                                <label class="form-label-universal">Cover Foto</label>

                                <!-- Preview Cover Saat Ini -->
                                @if($coverFoto)
                                    <div class="mb-3">
                                        <p class="text-sm text-muted">Cover Saat Ini:</p>
                                        <img src="{{ $berita->cover_foto_url }}"
                                             alt="Cover {{ $berita->judul }}"
                                             class="cover-img-preview rounded">
                                        <p class="text-xs text-muted mt-1">{{ $coverFoto->file_name }}</p>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <p class="text-sm text-muted">Belum ada cover foto</p>
                                    </div>
                                @endif

                                <div class="control">
                                    <input class="input-universal @error('cover_foto') is-danger @enderror"
                                           type="file"
                                           name="cover_foto"
                                           accept="image/*">
                                </div>
                                <small class="form-text text-muted">
                                    Biarkan kosong jika tidak ingin mengubah cover. Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.
                                </small>
                                @error('cover_foto')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Konten Berita - Full Width -->
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Isi Berita (HTML) <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <textarea class="textarea-universal @error('isi_html') is-danger @enderror"
                                              name="isi_html"
                                              rows="12"
                                              placeholder="Tulis isi berita dalam format HTML"
                                              required>{{ old('isi_html', $berita->isi_html) }}</textarea>
                                    <span class="icon left"><i class="mdi mdi-text"></i></span>
                                </div>
                                @error('isi_html')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                                <small class="form-text text-muted">
                                    Gunakan format HTML untuk konten berita. Anda dapat menggunakan tag seperti &lt;p&gt;, &lt;h1&gt;, &lt;h2&gt;, &lt;strong&gt;, &lt;em&gt;, dll.
                                </small>
                            </div>
                        </div>

                        <!-- Upload Gambar Pendukung Multiple -->
                        <div class="col-12">
                            <div class="field-group">
                                <label class="form-label-universal">Gambar Pendukung Tambahan</label>

                                <!-- Tampilkan Gambar Pendukung Saat Ini -->
                                @php
                                    $gambarPendukung = $berita->media->where('sort_order', '>', 1);
                                @endphp

                                @if($gambarPendukung->count() > 0)
                                    <div class="mb-3">
                                        <p class="text-sm text-muted">Gambar Pendukung Saat Ini:</p>
                                        <div class="file-list">
                                            @foreach($gambarPendukung as $gambar)
                                                <div class="file-item d-flex align-items-center justify-content-between mb-2 p-2 bg-light rounded">
                                                    <div class="file-info d-flex align-items-center">
                                                        <img src="{{ asset('storage/media/berita/gallery/' . $gambar->file_name) }}"
                                                             alt="{{ $gambar->file_name }}"
                                                             class="gallery-thumb me-3 rounded"
                                                             onerror="this.style.display='none'">
                                                        <div>
                                                            <span class="file-name">{{ $gambar->file_name }}</span>
                                                            <small class="text-muted d-block">{{ $gambar->mime_type }}</small>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('berita.delete-file', ['berita' => $berita->berita_id, 'file' => $gambar->media_id]) }}"
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                                                        Hapus
                                                    </a>
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
                                    Upload gambar tambahan. Format: JPG, JPEG, PNG, GIF. Maksimal 5 file, masing-masing 2MB.
                                </small>
                                @error('gambar_pendukung')
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
                                        Update Berita
                                    </button>
                                </div>
                                <div class="control">
                                    <button type="reset" class="btn btn-warning-universal btn-universal">
                                        <span class="icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
                                            </svg>
                                        </span>
                                        Reset Form
                                    </button>
                                </div>
                                <div class="control">
                                    <a href="{{ route('berita.index') }}" class="btn btn-danger-universal btn-universal">
                                        <span class="icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                            </svg>
                                        </span>
                                        Batal
                                    </a>
                                </div>
                                <div class="control">
                                    <a href="{{ route('berita.show', $berita->berita_id) }}" class="btn btn-primary-universal btn-universal">
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
.control.icons-left textarea,
.control.icons-left select {
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

.btn-warning-universal {
    background-color: #ffc107;
    color: #000;
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

.btn-warning-universal:hover {
    background-color: #e0a800;
}

.btn-danger-universal:hover {
    background-color: #c82333;
}

.btn-primary-universal:hover {
    background-color: #0056b3;
}

.cover-img-preview {
    width: 150px;
    height: 100px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
}

.gallery-thumb {
    width: 50px;
    height: 50px;
    object-fit: cover;
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
}

.file-name {
    font-weight: 500;
    font-size: 14px;
}

.text-danger {
    color: #dc3545;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert-universal {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid transparent;
}

@media (max-width: 768px) {
    .field.grouped {
        flex-direction: column;
        align-items: flex-start;
    }

    .field.grouped .control {
        width: 100%;
    }

    .field.grouped .btn-universal {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// Auto-generate slug from judul
document.addEventListener('DOMContentLoaded', function() {
    const judulInput = document.querySelector('input[name="judul"]');
    const slugInput = document.querySelector('input[name="slug"]');

    judulInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.value === '{{ $berita->slug }}') {
            const slug = judulInput.value
                .toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            slugInput.value = slug;
        }
    });

    // Reset form handler
    const resetButton = document.querySelector('button[type="reset"]');
    resetButton.addEventListener('click', function() {
        setTimeout(() => {
            // Clear any generated slug when resetting
            if (slugInput.value === judulInput.value.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-')) {
                slugInput.value = '{{ $berita->slug }}';
            }
        }, 100);
    });
});
</script>
@endsection
