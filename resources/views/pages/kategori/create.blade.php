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

        <div class="columns is-multiline">
          <!-- Kolom Kiri -->
          <div class="column is-half">
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
          <div class="column is-half">
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
          <div class="column is-full">
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
        </div>

        <hr>

        <div class="field grouped">
          <div class="control">
            <button type="submit" class="button green">
              <span class="icon"><i class="mdi mdi-content-save"></i></span>
              <span>Simpan Kategori</span>
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

.field.grouped {
  display: flex;
  gap: 0.75rem;
  flex-wrap: wrap;
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
