@extends('layouts.admin.app')

@section('content')
<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Berita</li>
      <li>Tambah Berita</li>
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
      Tambah Berita Baru
    </h1>
    <a href="{{ route('berita.index') }}" class="button light">
      <span class="icon"><i class="mdi mdi-arrow-left"></i></span>
      <span>Kembali</span>
    </a>
  </div>
</section>

<section class="section main-section">
  @if (session('success'))
    <div class="notification is-success">
      {{ session('success') }}
    </div>
  @endif

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

  <div class="card">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><i class="mdi mdi-newspaper-plus"></i></span>
        Form Tambah Berita Baru
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
          <!-- Kolom Kiri - Informasi Dasar Berita -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Judul Berita <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('judul') is-danger @enderror"
                       type="text"
                       name="judul"
                       value="{{ old('judul') }}"
                       placeholder="Masukkan judul berita"
                       required>
                <span class="icon left"><i class="mdi mdi-format-title"></i></span>
              </div>
              @error('judul')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Slug <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('slug') is-danger @enderror"
                       type="text"
                       name="slug"
                       value="{{ old('slug') }}"
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

            <div class="field">
              <label class="label">Kategori <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <div class="select is-fullwidth @error('kategori_id') is-danger @enderror">
                  <select name="kategori_id" required class="input">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriBerita as $kategori)
                      <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <span class="icon left"><i class="mdi mdi-tag"></i></span>
              </div>
              @error('kategori_id')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Penulis <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('penulis') is-danger @enderror"
                       type="text"
                       name="penulis"
                       value="{{ old('penulis') }}"
                       placeholder="Nama penulis berita"
                       required>
                <span class="icon left"><i class="mdi mdi-account"></i></span>
              </div>
              @error('penulis')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan - Informasi Tambahan & Upload -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Status <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <div class="select is-fullwidth @error('status') is-danger @enderror">
                  <select name="status" required class="input">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="terbit" {{ old('status') == 'terbit' ? 'selected' : '' }}>Terbit</option>
                  </select>
                </div>
                <span class="icon left"><i class="mdi mdi-bullhorn"></i></span>
              </div>
              @error('status')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Tanggal Terbit</label>
              <div class="control icons-left">
                <input class="input @error('terbit_at') is-danger @enderror"
                       type="datetime-local"
                       name="terbit_at"
                       value="{{ old('terbit_at') }}"
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
            <div class="field">
              <label class="label">Cover Foto</label>
              <div class="control">
                <input class="input @error('cover_foto') is-danger @enderror"
                       type="file"
                       name="cover_foto"
                       accept="image/*">
              </div>
              <small class="form-text text-muted">
                Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.
              </small>
              @error('cover_foto')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Upload Gambar Pendukung Multiple -->
            <div class="field">
              <label class="label">Gambar Pendukung</label>
              <div class="control">
                <input class="input @error('gambar_pendukung') is-danger @enderror"
                       type="file"
                       name="gambar_pendukung[]"
                       multiple
                       accept="image/*">
              </div>
              <small class="form-text text-muted">
                Format: JPG, JPEG, PNG, GIF. Maksimal 5 file, masing-masing 2MB.
              </small>
              @error('gambar_pendukung')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Konten Berita - Full Width -->
          <div class="col-12">
            <div class="field">
              <label class="label">Isi Berita (HTML) <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <textarea class="textarea @error('isi_html') is-danger @enderror"
                          name="isi_html"
                          rows="12"
                          placeholder="Tulis isi berita dalam format HTML"
                          required>{{ old('isi_html') }}</textarea>
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

          <!-- Tombol Aksi -->
          <div class="col-12">
            <div class="field grouped">
              <div class="control">
                <button type="submit" class="button green">
                  <span class="icon"><i class="mdi mdi-content-save"></i></span>
                  <span>Simpan Berita</span>
                </button>
              </div>
              <div class="control">
                <button type="reset" class="button light">
                  <span class="icon"><i class="mdi mdi-refresh"></i></span>
                  <span>Reset Form</span>
                </button>
              </div>
              <div class="control">
                <a href="{{ route('berita.index') }}" class="button light">
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
  .select select {
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
  .select select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  .textarea {
    resize: vertical;
    min-height: 150px;
  }

  /* Select styling */
  .select.is-fullwidth {
    width: 100%;
    position: relative;
  }

  .select select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    cursor: pointer;
    padding-right: 2.5rem;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px;
  }

  /* Icons styling untuk input, textarea dan select */
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

  /* Khusus untuk textarea icon */
  .control.icons-left.textarea-icon .icon.left {
    top: 1rem;
    transform: none;
  }

  .control.icons-left .select select {
    padding-left: 3rem;
  }

  .control.icons-left input {
    padding-left: 3rem;
  }

  .control.icons-left textarea {
    padding-left: 3rem;
    padding-top: 0.75rem;
  }

  /* Helper text */
  .form-text.text-muted {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
    display: block;
  }

  /* Error styling */
  .help.is-danger {
    color: #dc2626;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: block;
  }

  .input.is-danger,
  .textarea.is-danger,
  .select.is-danger select {
    border-color: #dc2626;
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

    .control.icons-left input,
    .control.icons-left textarea,
    .control.icons-left .select select {
      padding-left: 2.5rem;
    }

    .control.icons-left .icon.left {
      left: 0.75rem;
    }

    .textarea {
      min-height: 120px;
    }
  }

  /* Specific styling for file inputs */
  input[type="file"] {
    padding: 0.5rem;
    border: 2px dashed #e2e8f0;
    background-color: #f8fafc;
    cursor: pointer;
    width: 100%;
  }

  input[type="file"]:hover {
    border-color: #3b82f6;
    background-color: #f0f9ff;
  }

  input[type="datetime-local"] {
    padding: 0.75rem 1rem;
  }

  /* Notification styling */
  .notification {
    margin-bottom: 1.5rem;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
  }

  .notification.is-success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
  }

  .notification.is-danger {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
  }
</style>

<script>
// Auto-generate slug from judul
document.addEventListener('DOMContentLoaded', function() {
  const judulInput = document.querySelector('input[name="judul"]');
  const slugInput = document.querySelector('input[name="slug"]');

  if (judulInput && slugInput) {
    judulInput.addEventListener('input', function() {
      if (!slugInput.value) {
        const slug = judulInput.value
          .toLowerCase()
          .replace(/[^\w ]+/g, '')
          .replace(/ +/g, '-');
        slugInput.value = slug;
      }
    });

    // Reset form handler
    const resetButton = document.querySelector('button[type="reset"]');
    if (resetButton) {
      resetButton.addEventListener('click', function() {
        setTimeout(() => {
          // Clear any generated slug when resetting
          if (slugInput.value === judulInput.value.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-')) {
            slugInput.value = '';
          }
        }, 100);
      });
    }
  }
});
</script>
@endsection
