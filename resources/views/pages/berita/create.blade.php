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
              <div class="control">
                <div style="position: relative;">
                  <input class="input @error('judul') is-danger @enderror"
                         type="text"
                         name="judul"
                         value="{{ old('judul') }}"
                         placeholder="Masukkan judul berita"
                         required>
                  <i class="mdi mdi-format-title icon-left"></i>
                </div>
              </div>
              @error('judul')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Slug <span class="text-danger">*</span></label>
              <div class="control">
                <div style="position: relative;">
                  <input class="input @error('slug') is-danger @enderror"
                         type="text"
                         name="slug"
                         value="{{ old('slug') }}"
                         placeholder="judul-berita-url"
                         required>
                  <i class="mdi mdi-link icon-left"></i>
                </div>
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
              <div class="control">
                <div class="select-wrapper">
                  <div class="select is-fullwidth @error('kategori_id') is-danger @enderror">
                    <select name="kategori_id" required>
                      <option value="">Pilih Kategori</option>
                      @foreach($kategoriBerita as $kategori)
                        <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                          {{ $kategori->nama }}
                        </option>
                      @endforeach
                    </select>
                    <i class="mdi mdi-tag icon-left"></i>
                  </div>
                </div>
              </div>
              @error('kategori_id')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Upload Cover Foto -->
            <div class="field">
              <label class="label">Cover Foto</label>
              <div class="control">
                <input class="input @error('cover_foto') is-danger @enderror"
                       type="file"
                       name="cover_foto"
                       accept="image/*"
                       id="cover_foto">
              </div>
              <small class="form-text text-muted">
                Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.
              </small>
              @error('cover_foto')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan - Informasi Tambahan & Isi Berita -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Penulis <span class="text-danger">*</span></label>
              <div class="control">
                <div style="position: relative;">
                  <input class="input @error('penulis') is-danger @enderror"
                         type="text"
                         name="penulis"
                         value="{{ old('penulis') }}"
                         placeholder="Nama penulis berita"
                         required>
                  <i class="mdi mdi-account icon-left"></i>
                </div>
              </div>
              @error('penulis')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Status <span class="text-danger">*</span></label>
              <div class="control">
                <div class="select-wrapper">
                  <div class="select is-fullwidth @error('status') is-danger @enderror">
                    <select name="status" required>
                      <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                      <option value="terbit" {{ old('status') == 'terbit' ? 'selected' : '' }}>Terbit</option>
                    </select>
                    <i class="mdi mdi-bullhorn icon-left"></i>
                  </div>
                </div>
              </div>
              @error('status')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Tanggal Terbit</label>
              <div class="control">
                <div style="position: relative;">
                  <input class="input @error('terbit_at') is-danger @enderror"
                         type="datetime-local"
                         name="terbit_at"
                         value="{{ old('terbit_at') }}"
                         placeholder="Tanggal terbit otomatis jika status terbit">
                  <i class="mdi mdi-calendar-clock icon-left"></i>
                </div>
              </div>
              @error('terbit_at')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
              <small class="form-text text-muted">
                Kosongkan untuk menggunakan tanggal saat ini ketika status diubah ke "Terbit"
              </small>
            </div>

            <!-- Isi Berita - Dipindahkan ke kolom kanan di bawah tanggal terbit -->
            <div class="field">
              <label class="label">Isi Berita (HTML) <span class="text-danger">*</span></label>
              <div class="control">
                <div style="position: relative;">
                  <textarea class="textarea @error('isi_html') is-danger @enderror"
                            name="isi_html"
                            rows="12"
                            placeholder="Tulis isi berita dalam format HTML"
                            required>{{ old('isi_html') }}</textarea>
                  <i class="mdi mdi-text icon-left textarea-icon"></i>
                </div>
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

  /* Input, textarea dan select styling */
  .input,
  .textarea,
  .select select {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem !important;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background-color: white;
    font-family: inherit;
    box-sizing: border-box;
  }

  .textarea {
    resize: vertical;
    min-height: 200px;
  }

  .input:focus,
  .textarea:focus,
  .select select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  /* Icon styling konsisten dengan form warga */
  .icon-left {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 20px;
    z-index: 10;
    pointer-events: none;
  }

  /* Untuk textarea, icon perlu diatur ulang */
  .textarea-icon {
    top: 1.5rem;
    transform: none;
  }

  /* Select wrapper untuk icon */
  .select-wrapper {
    position: relative;
    width: 100%;
  }

  .select.is-fullwidth {
    width: 100%;
    position: relative;
  }

  .select select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    cursor: pointer;
    padding-right: 2.5rem !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 16px;
  }

  /* File Input Styling - SIMPLE seperti di form edit */
  input[type="file"] {
    width: 100%;
    padding: 0.75rem !important;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    background-color: white;
    cursor: pointer;
    color: #6b7280;
    transition: all 0.3s ease;
  }

  input[type="file"]:hover {
    border-color: #3b82f6;
    background-color: #f0f9ff;
  }

  /* Hilangkan tampilan tombol biru dari browser */
  input[type="file"]::-webkit-file-upload-button {
    background-color: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    margin-right: 1rem;
    transition: all 0.3s ease;
  }

  input[type="file"]::-webkit-file-upload-button:hover {
    background-color: #e5e7eb;
  }

  /* Untuk Firefox */
  input[type="file"]::file-selector-button {
    background-color: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    margin-right: 1rem;
    transition: all 0.3s ease;
  }

  input[type="file"]::file-selector-button:hover {
    background-color: #e5e7eb;
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
  .select.is-danger select,
  input[type="file"].is-danger {
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

    .textarea {
      min-height: 150px;
    }

    input[type="file"]::-webkit-file-upload-button,
    input[type="file"]::file-selector-button {
      padding: 0.4rem 0.75rem;
      font-size: 13px;
    }
  }

  /* Specific styling untuk datetime-local */
  input[type="datetime-local"] {
    padding: 0.75rem 1rem 0.75rem 3rem !important;
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
          .replace(/[^\w\s]/gi, '')
          .replace(/\s+/g, '-')
          .replace(/--+/g, '-');
        slugInput.value = slug;
      }
    });

    // Reset form handler
    const resetButton = document.querySelector('button[type="reset"]');
    if (resetButton) {
      resetButton.addEventListener('click', function() {
        setTimeout(() => {
          // Clear any generated slug when resetting
          const generatedSlug = judulInput.value
            .toLowerCase()
            .replace(/[^\w\s]/gi, '')
            .replace(/\s+/g, '-')
            .replace(/--+/g, '-');

          if (slugInput.value === generatedSlug) {
            slugInput.value = '';
          }
        }, 100);
      });
    }
  }
});
</script>
@endsection
