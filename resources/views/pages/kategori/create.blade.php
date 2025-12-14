@extends('layouts.admin.app')

@section('content')

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Kategori Berita</li>
      <li>Tambah Kategori</li>
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
      Tambah Kategori Baru
    </h1>
    <a href="{{ route('kategoriberita.index') }}" class="button light">
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

  <div class="card">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><i class="mdi mdi-tag-plus"></i></span>
        Form Tambah Kategori
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('kategoriberita.store') }}" method="POST">
        @csrf

        <div class="row">
          <!-- Kolom Kiri -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Nama Kategori <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('nama') is-danger @enderror"
                       type="text"
                       name="nama"
                       value="{{ old('nama') }}"
                       placeholder="Masukkan nama kategori"
                       required>
                <span class="icon left"><i class="mdi mdi-tag"></i></span>
              </div>
              @error('nama')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Slug <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('slug') is-danger @enderror"
                       type="text"
                       name="slug"
                       value="{{ old('slug') }}"
                       placeholder="nama-kategori-url"
                       required>
                <span class="icon left"><i class="mdi mdi-link"></i></span>
              </div>
              @error('slug')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
              <p class="help">Slug akan digunakan untuk URL kategori. Gunakan huruf kecil dan tanda strip (-)</p>
            </div>
          </div>

          <!-- Deskripsi - Full Width -->
          <div class="col-12">
            <div class="field">
              <label class="label">Deskripsi</label>
              <div class="control">
                <textarea class="textarea @error('deskripsi') is-danger @enderror"
                          name="deskripsi"
                          rows="4"
                          placeholder="Masukkan deskripsi kategori (opsional)">{{ old('deskripsi') }}</textarea>
              </div>
              @error('deskripsi')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Tombol Aksi -->
          <div class="col-12">
            <div class="field grouped">
              <div class="control">
                <button type="submit" class="button green">
                  <span class="icon"><i class="mdi mdi-content-save"></i></span>
                  <span>Simpan Kategori</span>
                </button>
              </div>
              <div class="control">
                <button type="reset" class="button light">
                  <span class="icon"><i class="mdi mdi-refresh"></i></span>
                  <span>Reset Form</span>
                </button>
              </div>
              <div class="control">
                <a href="{{ route('kategoriberita.index') }}" class="button light">
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
  .select select,
  .textarea {
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
  .select select:focus,
  .textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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

    .control.icons-left input {
      padding-left: 2.5rem;
    }

    .control.icons-left .icon.left {
      left: 0.75rem;
    }
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
</style>

<script>
// Auto-generate slug from nama
document.addEventListener('DOMContentLoaded', function() {
  const namaInput = document.querySelector('input[name="nama"]');
  const slugInput = document.querySelector('input[name="slug"]');

  namaInput.addEventListener('input', function() {
    if (!slugInput.value) {
      const slug = namaInput.value
        .toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
      slugInput.value = slug;
    }
  });
});
</script>
@endsection
