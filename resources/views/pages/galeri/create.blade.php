@extends('layouts.admin.app')

@section('content')

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Galeri</li>
      <li>Tambah Galeri</li>
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
      Tambah Galeri Baru
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
        <span class="icon"><i class="mdi mdi-image-multiple"></i></span>
        Form Tambah Galeri
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" id="galeriForm">
        @csrf

        <div class="row">
          <!-- Kolom Kiri - Informasi Dasar Galeri -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Judul Galeri <span class="text-danger">*</span></label>
              <div class="control has-icons-left">
                <input class="input @error('judul') is-danger @enderror"
                       type="text"
                       name="judul"
                       value="{{ old('judul') }}"
                       placeholder="Masukkan judul galeri"
                       required>
                <span class="icon is-left">
                  <i class="mdi mdi-format-title"></i>
                </span>
              </div>
              @error('judul')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Deskripsi</label>
              <div class="control has-icons-left">
                <textarea class="textarea @error('deskripsi') is-danger @enderror"
                          name="deskripsi"
                          rows="4"
                          placeholder="Masukkan deskripsi galeri (opsional)">{{ old('deskripsi') }}</textarea>
                <span class="icon is-left">
                  <i class="mdi mdi-text"></i>
                </span>
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
              <div class="control has-icons-left">
                <input class="input @error('foto_utama') is-danger @enderror"
                       type="file"
                       name="foto_utama"
                       id="fotoUtama"
                       accept=".jpg,.jpeg,.png,.gif,.webp"
                       required>
                <span class="icon is-left">
                  <i class="mdi mdi-image"></i>
                </span>
              </div>
              <p class="help">Format: JPG, JPEG, PNG, GIF, WEBP. Maksimal 5MB. <strong>Foto utama akan menjadi tampilan utama galeri</strong>.</p>
              @error('foto_utama')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
              <div id="previewFotoUtama" class="mt-2"></div>
            </div>
          </div>

          <!-- Tombol Aksi -->
          <div class="col-12">
            <div class="field grouped">
              <div class="control">
                <button type="submit" class="button green">
                  <span class="icon"><i class="mdi mdi-content-save"></i></span>
                  <span>Simpan Galeri</span>
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

  /* Input file khusus */
  .input[type="file"] {
    padding: 0.75rem 1rem 0.75rem 3.5rem;
    background-color: #f8f9fa;
    border: 1px dashed #dee2e6;
    cursor: pointer;
    height: auto;
    line-height: 1.5;
    position: relative;
  }

  .input[type="file"]:focus {
    border-color: #3b82f6;
    border-style: solid;
  }

  .input:focus,
  .textarea:focus,
  select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  /* Textarea styling */
  .textarea {
    min-height: 120px;
    resize: vertical;
    padding-left: 3.5rem;
  }

  /* Icons styling untuk input - Mengikuti style dari form profil */
  .control.has-icons-left {
    position: relative;
  }

  .control.has-icons-left .icon.is-left {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    z-index: 2;
    pointer-events: none;
    height: 1.5rem;
    width: 1.5rem;
  }

  /* Untuk textarea, atur icon di atas */
  .control.has-icons-left textarea + .icon.is-left {
    top: 1.5rem;
    transform: none;
    align-items: flex-start;
  }

  /* Input dengan icon */
  .control.has-icons-left input {
    padding-left: 3.5rem;
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

  .button.green {
    background-color: #10b981;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    transition: background-color 0.3s ease;
    font-size: 0.875rem;
  }

  .button.light {
    background-color: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 0.875rem;
  }

  .button.green:hover {
    background-color: #059669;
  }

  .button.light:hover {
    background-color: #e5e7eb;
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

  /* Preview styling */
  .file-preview {
    position: relative;
    display: inline-block;
    margin: 5px;
    text-align: center;
    vertical-align: top;
  }

  .file-preview img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #3b82f6;
  }

  .file-preview .file-name {
    font-size: 12px;
    margin-top: 5px;
    color: #666;
    word-break: break-all;
    max-width: 150px;
  }

  /* Notification styling */
  .notification {
    margin-bottom: 1.5rem;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    display: flex;
    align-items: flex-start;
    gap: 12px;
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
    margin-top: 2px;
    flex-shrink: 0;
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

    .control.has-icons-left input,
    .control.has-icons-left textarea {
      padding-left: 3rem;
    }

    .control.has-icons-left .icon.is-left {
      left: 0.75rem;
    }

    .input[type="file"] {
      padding-left: 3rem;
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validasi file untuk foto utama
    const fotoUtamaInput = document.getElementById('fotoUtama');
    const previewContainer = document.getElementById('previewFotoUtama');

    if (fotoUtamaInput) {
        fotoUtamaInput.addEventListener('change', function() {
            const file = this.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB

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
                    img.alt = 'Preview Foto Utama';

                    const name = document.createElement('div');
                    name.className = 'file-name';
                    name.textContent = file.name.length > 25 ? file.name.substring(0, 25) + '...' : file.name;

                    preview.appendChild(img);
                    preview.appendChild(name);
                    previewContainer.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Form submission validation
    const form = document.getElementById('galeriForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Validasi foto utama harus ada
            if (!fotoUtamaInput || !fotoUtamaInput.files.length) {
                e.preventDefault();
                alert('Foto utama wajib diisi!');
                return false;
            }

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
});

// Function to reset form
function resetForm() {
    // Clear previews
    const previewContainer = document.getElementById('previewFotoUtama');
    if (previewContainer) {
        previewContainer.innerHTML = '';
    }

    // Reset submit button state
    const submitBtn = document.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = `
            <span class="icon"><i class="mdi mdi-content-save"></i></span>
            <span>Simpan Galeri</span>
        `;
    }
}
</script>
@endsection
