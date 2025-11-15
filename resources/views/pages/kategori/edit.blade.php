@extends('layouts.admin.app')

@section('content')

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Kategori Berita</li>
      <li>Edit Kategori</li>
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
      Edit Kategori - {{ $kategori->nama }}
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

  @if (session('success'))
  <div class="notification is-success">
    <i class="mdi mdi-check-circle"></i>
    {{ session('success') }}
  </div>
  @endif

  <div class="card">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><i class="mdi mdi-tag-plus"></i></span>
        Form Edit Kategori
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('kategoriberita.update', $kategori->kategori_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="columns is-multiline">
          <!-- Kolom Kiri -->
          <div class="column is-half">
            <div class="field">
              <label class="label">Nama Kategori <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('nama') is-danger @enderror"
                       type="text"
                       name="nama"
                       value="{{ old('nama', $kategori->nama) }}"
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
          <div class="column is-half">
            <div class="field">
              <label class="label">Slug <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('slug') is-danger @enderror"
                       type="text"
                       name="slug"
                       value="{{ old('slug', $kategori->slug) }}"
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
          <div class="column is-full">
            <div class="field">
              <label class="label">Deskripsi</label>
              <div class="control">
                <textarea class="textarea @error('deskripsi') is-danger @enderror"
                          name="deskripsi"
                          rows="4"
                          placeholder="Masukkan deskripsi kategori (opsional)">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
              </div>
              @error('deskripsi')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <hr>

        <div class="field grouped">
          <div class="control">
            <button type="submit" class="button green">
              <span class="icon"><i class="mdi mdi-content-save"></i></span>
              <span>Update Kategori</span>
            </button>
          </div>
          <div class="control">
            <button type="reset" class="button yellow">
              <span class="icon"><i class="mdi mdi-refresh"></i></span>
              <span>Reset Form</span>
            </button>
          </div>
          <div class="control">
            <a href="{{ route('kategoriberita.index') }}" class="button red">
              <span class="icon"><i class="mdi mdi-close"></i></span>
              <span>Batal</span>
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Additional Information -->
  <div class="columns is-multiline mt-6">
    <div class="column is-full">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-information"></i></span>
            Informasi Kategori
          </p>
        </header>
        <div class="card-content">
          <div class="content">
            <p><strong>Detail Kategori:</strong></p>
            <ul>
              <li>Dibuat: {{ $kategori->created_at->format('d M Y H:i') }}</li>
              <li>Diupdate: {{ $kategori->updated_at->format('d M Y H:i') }}</li>
              <li>Jumlah Berita: {{ $kategori->berita->count() }} berita</li>
              <li>Slug: <code>{{ $kategori->slug }}</code></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.text-danger {
  color: #ff3860;
}

.help.is-danger {
  color: #ff3860;
}

.input.is-danger, .textarea.is-danger, .select.is-danger select {
  border-color: #ff3860;
}

.notification.is-danger {
  background-color: #ff3860;
  color: #fff;
}

.notification.is-success {
  background-color: #48c78e;
  color: #fff;
}

.field.grouped {
  display: flex;
  gap: 0.75rem;
  flex-wrap: wrap;
}

.card {
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.card-header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #e9ecef;
}

.field {
  margin-bottom: 1.5rem;
}

.label {
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
}

.textarea {
  resize: vertical;
  min-height: 80px;
}

.button.green {
  background-color: #10b981;
  color: white;
  border: none;
}

.button.green:hover {
  background-color: #059669;
}

.button.red {
  background-color: #ef4444;
  color: white;
  border: none;
}

.button.red:hover {
  background-color: #dc2626;
}

.button.yellow {
  background-color: #f59e0b;
  color: white;
  border: none;
}

.button.yellow:hover {
  background-color: #d97706;
}

code {
  background-color: #f5f5f5;
  padding: 2px 6px;
  border-radius: 3px;
  font-family: monospace;
}

@media (max-width: 768px) {
  .field.grouped {
    flex-direction: column;
    align-items: flex-start;
  }

  .field.grouped .control {
    width: 100%;
  }

  .field.grouped .button {
    width: 100%;
    justify-content: center;
  }
}
</style>

<script>
// Auto-generate slug from nama
document.addEventListener('DOMContentLoaded', function() {
  const namaInput = document.querySelector('input[name="nama"]');
  const slugInput = document.querySelector('input[name="slug"]');

  namaInput.addEventListener('input', function() {
    if (!slugInput.value || slugInput.value === '{{ $kategori->slug }}') {
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
