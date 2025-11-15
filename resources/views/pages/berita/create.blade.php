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
        <span class="icon"><i class="mdi mdi-newspaper"></i></span>
        Form Tambah Berita
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('berita.store') }}" method="POST">
        @csrf

        <div class="columns is-multiline">
          <!-- Kolom Kiri - Informasi Dasar Berita -->
          <div class="column is-half">
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
              <p class="help">Slug akan digunakan untuk URL berita. Gunakan huruf kecil dan tanda strip (-)</p>
            </div>

            <div class="field">
              <label class="label">Kategori <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <div class="select is-fullwidth @error('kategori_id') is-danger @enderror">
                  <select name="kategori_id" required>
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
          </div>

          <!-- Kolom Kanan - Informasi Tambahan -->
          <div class="column is-half">
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

            <div class="field">
              <label class="label">Cover Foto</label>
              <div class="control icons-left">
                <input class="input @error('cover_foto') is-danger @enderror"
                       type="text"
                       name="cover_foto"
                       value="{{ old('cover_foto') }}"
                       placeholder="URL gambar cover (opsional)">
                <span class="icon left"><i class="mdi mdi-image"></i></span>
              </div>
              @error('cover_foto')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
              <p class="help">Masukkan URL gambar cover berita (opsional)</p>
            </div>

            <div class="field">
              <label class="label">Status <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <div class="select is-fullwidth @error('status') is-danger @enderror">
                  <select name="status" required>
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
              <p class="help">Kosongkan untuk menggunakan tanggal saat ini ketika status diubah ke "Terbit"</p>
            </div>
          </div>

          <!-- Konten Berita - Full Width -->
          <div class="column is-full">
            <div class="field">
              <label class="label">Isi Berita (HTML) <span class="text-danger">*</span></label>
              <div class="control">
                <textarea class="textarea @error('isi_html') is-danger @enderror"
                          name="isi_html"
                          rows="12"
                          placeholder="Tulis isi berita dalam format HTML"
                          required>{{ old('isi_html') }}</textarea>
              </div>
              @error('isi_html')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
              <p class="help">Gunakan format HTML untuk konten berita. Anda dapat menggunakan tag seperti &lt;p&gt;, &lt;h1&gt;, &lt;h2&gt;, &lt;strong&gt;, &lt;em&gt;, dll.</p>
            </div>
          </div>
        </div>

        <hr>

        <div class="field grouped">
          <div class="control">
            <button type="submit" class="button green">
              <span class="icon"><i class="mdi mdi-content-save"></i></span>
              <span>Simpan Berita</span>
            </button>
          </div>
          <div class="control">
            <button type="reset" class="button yellow">
              <span class="icon"><i class="mdi mdi-refresh"></i></span>
              <span>Reset Form</span>
            </button>
          </div>
          <div class="control">
            <a href="{{ route('berita.index') }}" class="button red">
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

pre {
  background-color: #f5f5f5;
  padding: 1rem;
  border-radius: 4px;
  overflow-x: auto;
  font-size: 0.875rem;
}

code {
  background-color: transparent;
  padding: 0;
}
</style>

<script>
// Auto-generate slug from judul
document.addEventListener('DOMContentLoaded', function() {
  const judulInput = document.querySelector('input[name="judul"]');
  const slugInput = document.querySelector('input[name="slug"]');

  judulInput.addEventListener('input', function() {
    if (!slugInput.value) {
      const slug = judulInput.value
        .toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
      slugInput.value = slug;
    }
  });
});
</script>
@endsection
