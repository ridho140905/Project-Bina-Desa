@extends('layouts.admin.app')

@section('content')

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Galeri</li>
      <li>Edit Galeri</li>
    </ul>
    <a href="https://justboil.me/" onclick="alert('Coming soon'); return false" target="_blank" class="button blue">
      <span class="icon"><i class="mdi mdi-credit-card-outline"></i></span>
      <span>Premium Demo</span>
    </a>
  </div>
</section>

<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Edit Galeri - {{ $dataGaleri->judul }}
    </h1>
    <a href="{{ route('galeri.index') }}" class="button light">
      <span class="icon"><i class="mdi mdi-arrow-left"></i></span>
      <span>Kembali</span>
    </a>
  </div>
</section>

<section class="section main-section">
  @if ($errors->any())
    <div class="notification is-danger">
      <strong>Error!</strong> Terdapat kesalahan dalam pengisian form:
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if (session('success'))
    <div class="notification is-success">
      <i class="mdi mdi-check-circle"></i>
      {{ session('success') }}
    </div>
  @endif

  <div class="card">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><i class="mdi mdi-image-edit"></i></span>
        Form Edit Galeri
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('galeri.update', $dataGaleri->galeri_id) }}" method="POST" enctype="multipart/form-data" id="galeriForm">
        @csrf
        @method('PUT')

        <div class="row">
          <!-- Kolom Kiri - Informasi Dasar Galeri -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Judul Galeri <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('judul') is-danger @enderror"
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

            <div class="field">
              <label class="label">Deskripsi</label>
              <div class="control">
                <textarea class="textarea @error('deskripsi') is-danger @enderror"
                          name="deskripsi"
                          rows="4"
                          placeholder="Masukkan deskripsi galeri (opsional)">{{ old('deskripsi', $dataGaleri->deskripsi) }}</textarea>
              </div>
              @error('deskripsi')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan - Upload Foto -->
          <div class="col-md-6">
            <!-- Foto Utama -->
            <div class="field">
              <label class="label">Foto Utama <span class="text-danger">*</span></label>
              @php
                $fotoUtama = $dataGaleri->media->where('sort_order', 1)->first();
              @endphp

              @if($fotoUtama)
                <div class="mb-3">
                  <div class="current-photo-container">
                    <img src="{{ asset('storage/media/galeri/' . $fotoUtama->file_name) }}"
                         alt="Foto Utama Saat Ini"
                         class="current-photo mb-2">
                    <p class="text-sm text-muted">Foto utama saat ini</p>
                  </div>
                </div>
              @else
                <div class="mb-3">
                  <div class="no-photo-placeholder">
                    <i class="mdi mdi-image-off"></i>
                    <p class="text-sm text-muted">Belum ada foto utama</p>
                  </div>
                </div>
              @endif

              <div class="control">
                <input class="input @error('foto_utama') is-danger @enderror"
                       type="file"
                       name="foto_utama"
                       id="fotoUtama"
                       accept=".jpg,.jpeg,.png,.gif,.webp">
              </div>
              <p class="help">Biarkan kosong jika tidak ingin mengganti foto utama. Format: JPG, JPEG, PNG, GIF, WEBP. Maksimal 5MB.</p>
              @error('foto_utama')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
              <div id="previewFotoUtama" class="mt-2"></div>
            </div>

            <!-- Foto Pendukung Baru -->
            <div class="field">
              <label class="label">Tambah Foto Pendukung Baru</label>
              <div class="control">
                <input class="input @error('foto_pendukung') is-danger @enderror"
                       type="file"
                       name="foto_pendukung[]"
                       id="fotoPendukung"
                       multiple
                       accept=".jpg,.jpeg,.png,.gif,.webp">
              </div>
              <p class="help">Biarkan kosong jika tidak ingin menambah foto. Format: JPG, JPEG, PNG, GIF, WEBP. Maksimal 5MB per file.</p>
              @error('foto_pendukung')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
              @error('foto_pendukung.*')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
              <div id="previewFotoPendukung" class="mt-2"></div>
            </div>
          </div>

          <!-- Foto Pendukung Saat Ini - Full Width -->
          <div class="col-12">
            <div class="field">
              <label class="label">Foto Pendukung Saat Ini</label>

              @php
                $fotoPendukung = $dataGaleri->media->where('sort_order', '>', 1);
              @endphp

              @if($fotoPendukung->count() > 0)
                <div class="mb-4">
                  <p class="text-sm text-muted mb-3">Daftar foto pendukung:</p>
                  <div class="file-list">
                    @foreach($fotoPendukung as $foto)
                      <div class="file-item d-flex align-items-center justify-content-between mb-2 p-3 bg-light rounded">
                        <div class="file-info d-flex align-items-center">
                          <img src="{{ asset('storage/media/galeri/' . $foto->file_name) }}"
                               alt="{{ $foto->file_name }}"
                               class="gambar-preview-small me-3"
                               onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                          <div class="no-image-placeholder me-3" style="display: none;">
                            <i class="mdi mdi-image-off"></i>
                          </div>
                          <div>
                            <span class="file-name">{{ $foto->file_name }}</span>
                            <small class="text-muted d-block">{{ $foto->mime_type }} • {{ round($foto->file_size / 1024) }} KB</small>
                          </div>
                        </div>
                        <div class="file-actions">
                          <a href="{{ route('galeri.delete-file', ['galeri' => $dataGaleri->galeri_id, 'file' => $foto->media_id]) }}"
                             class="button light btn-hapus-foto"
                             data-filename="{{ $foto->file_name }}"
                             title="Hapus Foto">
                            <span class="icon"><i class="mdi mdi-delete"></i></span>
                            <span>Hapus</span>
                          </a>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              @else
                <div class="mb-3">
                  <p class="text-sm text-muted">Belum ada foto pendukung</p>
                  <div class="no-image-placeholder">
                    <i class="mdi mdi-image-off"></i>
                  </div>
                </div>
              @endif
            </div>
          </div>

          <!-- Tombol Aksi -->
          <div class="col-12">
            <div class="field grouped">
              <div class="control">
                <button type="submit" class="button green">
                  <span class="icon"><i class="mdi mdi-content-save"></i></span>
                  <span>Update Galeri</span>
                </button>
              </div>
              <div class="control">
                <button type="reset" class="button light" onclick="resetForm()">
                  <span class="icon"><i class="mdi mdi-refresh"></i></span>
                  <span>Reset Form</span>
                </button>
              </div>
              <div class="control">
                <a href="{{ route('galeri.index') }}" class="button light">
                  <span class="icon"><i class="mdi mdi-close"></i></span>
                  <span>Batal</span>
                </a>
              </div>
              <div class="control">
                <a href="{{ route('galeri.show', $dataGaleri->galeri_id) }}" class="button primary">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                  <span>Lihat Detail</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<style>
  /* Style dasar untuk form */
  .field {
    margin-bottom: 1.5rem;
  }

  .label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
    font-size: 0.875rem;
  }

  .input,
  .textarea,
  select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background-color: white;
    font-family: inherit;
  }

  .input:focus,
  .textarea:focus,
  select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  /* Style khusus untuk input file */
  input[type="file"] {
    padding: 0.5rem;
    background-color: #f8f9fa;
    border: 1px dashed #dee2e6;
  }

  input[type="file"]:focus {
    border-color: #3b82f6;
    border-style: solid;
  }

  /* Textarea styling */
  .textarea {
    min-height: 120px;
    resize: vertical;
  }

  /* Icons styling untuk input */
  .control.icons-left {
    position: relative;
  }

  .control.icons-left .icon.left {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    z-index: 2;
    pointer-events: none;
  }

  .control.icons-left input {
    padding-left: 3rem;
  }

  /* Error styling */
  .help.is-danger {
    color: #dc2626;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: block;
  }

  .input.is-danger,
  .textarea.is-danger {
    border-color: #dc2626;
  }

  .help {
    color: #6b7280;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: block;
  }

  /* Button styling */
  .field.grouped {
    display: flex;
    gap: 1rem;
    align-items: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
  }

  .button {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 0.875rem;
    text-decoration: none;
    border: 1px solid transparent;
  }

  .button.green {
    background-color: #10b981;
    color: white;
    border: none;
  }

  .button.light {
    background-color: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
  }

  .button.primary {
    background-color: #3b82f6;
    color: white;
    border: none;
  }

  .button.green:hover {
    background-color: #059669;
  }

  .button.light:hover {
    background-color: #e5e7eb;
  }

  .button.primary:hover {
    background-color: #2563eb;
  }

  /* Row and column styling */
  .row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
  }

  .col-md-6 {
    padding-right: 15px;
    padding-left: 15px;
    flex: 0 0 50%;
    max-width: 50%;
  }

  .col-12 {
    padding-right: 15px;
    padding-left: 15px;
    flex: 0 0 100%;
    max-width: 100%;
  }

  /* Card styling */
  .card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
  }

  .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    padding: 1rem 1.5rem;
  }

  .card-header-title {
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .card-content {
    padding: 1.5rem;
  }

  /* Required field indicator */
  .text-danger {
    color: #dc2626;
  }

  /* Current photo styling */
  .current-photo {
    width: 200px;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #3b82f6;
  }

  .current-photo-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .no-photo-placeholder {
    width: 200px;
    height: 150px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 32px;
  }

  .no-photo-placeholder p {
    margin-top: 8px;
    font-size: 14px;
  }

  /* Preview styling */
  .preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
  }

  .file-preview {
    position: relative;
    display: inline-block;
    margin: 5px;
    text-align: center;
    vertical-align: top;
  }

  .file-preview img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #ddd;
  }

  .file-preview .file-name {
    font-size: 10px;
    margin-top: 2px;
    color: #666;
    word-break: break-all;
    max-width: 80px;
  }

  /* Foto utama preview khusus */
  #previewFotoUtama img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #3b82f6;
  }

  /* Notification styling */
  .notification {
    margin-bottom: 1.5rem;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
  }

  .notification.is-danger {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
  }

  .notification.is-success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
  }

  .notification.is-success i {
    margin-right: 0.5rem;
  }

  /* Image preview styling */
  .gambar-preview-small {
    width: 60px;
    height: 60px;
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
    max-height: 300px;
    overflow-y: auto;
  }

  .file-item {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
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

  .file-info {
    display: flex;
    align-items: center;
  }

  .no-image-placeholder {
    width: 60px;
    height: 60px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 24px;
  }

  /* Responsive design */
  @media (max-width: 768px) {
    .col-md-6 {
      flex: 0 0 100%;
      max-width: 100%;
    }

    .field.grouped {
      flex-direction: column;
      gap: 0.75rem;
    }

    .field.grouped .control {
      width: 100%;
    }

    .field.grouped .button {
      width: 100%;
      justify-content: center;
    }

    .card-content {
      padding: 1rem;
    }

    .control.icons-left input {
      padding-left: 2.5rem;
    }

    .control.icons-left .icon.left {
      left: 0.75rem;
    }

    .file-item {
      flex-direction: column;
      align-items: flex-start;
    }

    .file-info {
      margin-bottom: 0.5rem;
      width: 100%;
    }

    .file-actions {
      align-self: flex-end;
      width: 100%;
      justify-content: flex-end;
    }

    .file-actions .button {
      width: 100%;
      justify-content: center;
    }

    .current-photo {
      width: 150px;
      height: 120px;
    }

    .no-photo-placeholder {
      width: 150px;
      height: 120px;
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validasi file untuk foto utama
    const fotoUtamaInput = document.getElementById('fotoUtama');
    const fotoPendukungInput = document.getElementById('fotoPendukung');

    if (fotoUtamaInput) {
        fotoUtamaInput.addEventListener('change', function() {
            const file = this.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB
            const previewContainer = document.getElementById('previewFotoUtama');

            // Clear previous preview
            previewContainer.innerHTML = '';

            if (file) {
                // Validasi ukuran
                if (file.size > maxSize) {
                    alert(`Gambar ${file.name} melebihi ukuran maksimal 5MB`);
                    this.value = '';
                    return;
                }

                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert(`File ${file.name} bukan format yang diperbolehkan. Hanya JPG, JPEG, PNG, GIF, WEBP yang diperbolehkan`);
                    this.value = '';
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'file-preview';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview Foto Utama Baru';

                    const name = document.createElement('div');
                    name.className = 'file-name';
                    name.textContent = file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name;

                    preview.appendChild(img);
                    preview.appendChild(name);
                    previewContainer.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Validasi file untuk foto pendukung
    if (fotoPendukungInput) {
        fotoPendukungInput.addEventListener('change', function() {
            const files = this.files;
            const maxSize = 5 * 1024 * 1024; // 5MB per file
            const maxFiles = 20; // Maksimal 20 file
            const previewContainer = document.getElementById('previewFotoPendukung');

            // Clear previous preview
            previewContainer.innerHTML = '';

            if (files.length > maxFiles) {
                alert(`Maksimal ${maxFiles} gambar yang dapat diupload sebagai foto pendukung`);
                this.value = '';
                return;
            }

            for (let file of files) {
                if (file.size > maxSize) {
                    alert(`Gambar ${file.name} melebihi ukuran maksimal 5MB`);
                    this.value = '';
                    return;
                }

                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert(`File ${file.name} bukan format yang diperbolehkan. Hanya JPG, JPEG, PNG, GIF, WEBP yang diperbolehkan`);
                    this.value = '';
                    return;
                }

                // Create preview untuk setiap file
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.createElement('div');
                        preview.className = 'file-preview';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Preview Foto Pendukung Baru';

                        const name = document.createElement('div');
                        name.className = 'file-name';
                        name.textContent = file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name;

                        preview.appendChild(img);
                        preview.appendChild(name);
                        previewContainer.appendChild(preview);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    }

    // Form submission validation
    const form = document.getElementById('galeriForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Optional: Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <span class="icon"><i class="mdi mdi-loading mdi-spin"></i></span>
                    <span>Menyimpan...</span>
                `;
            }
        });
    }

    // Konfirmasi hapus foto pendukung
    const deleteButtons = document.querySelectorAll('.btn-hapus-foto');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const filename = this.getAttribute('data-filename');
            if (!confirm(`Yakin ingin menghapus foto "${filename}"?`)) {
                e.preventDefault();
            }
        });
    });
});

// Function to reset form
function resetForm() {
    // Clear previews
    const fotoUtamaPreview = document.getElementById('previewFotoUtama');
    const fotoPendukungPreview = document.getElementById('previewFotoPendukung');

    if (fotoUtamaPreview) fotoUtamaPreview.innerHTML = '';
    if (fotoPendukungPreview) fotoPendukungPreview.innerHTML = '';

    // Reset submit button state
    const submitBtn = document.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = `
            <span class="icon"><i class="mdi mdi-content-save"></i></span>
            <span>Update Galeri</span>
        `;
    }
}
</script>
@endsection
