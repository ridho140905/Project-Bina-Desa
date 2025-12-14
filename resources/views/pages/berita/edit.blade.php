@extends('layouts.admin.app')

@section('content')
<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Berita</li>
      <li>Edit Berita</li>
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
      Edit Berita - {{ Str::limit($berita->judul, 50) }}
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
        <span class="icon"><i class="mdi mdi-newspaper-edit"></i></span>
        Form Edit Berita
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('berita.update', $berita->berita_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
          <!-- Kolom Kiri - Informasi Dasar Berita -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Judul Berita <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('judul') is-danger @enderror"
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

            <div class="field">
              <label class="label">Slug <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('slug') is-danger @enderror"
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

            <div class="field">
              <label class="label">Kategori <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <div class="select is-fullwidth @error('kategori_id') is-danger @enderror">
                  <select name="kategori_id" required class="input">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriBerita as $kategori)
                      <option value="{{ $kategori->kategori_id }}"
                        {{ old('kategori_id', $berita->kategori_id) == $kategori->kategori_id ? 'selected' : '' }}>
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
                       value="{{ old('penulis', $berita->penulis) }}"
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
                    <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="terbit" {{ old('status', $berita->status) == 'terbit' ? 'selected' : '' }}>Terbit</option>
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
            <div class="field">
              <label class="label">Cover Foto</label>

              <!-- Preview Cover Saat Ini -->
              @if($coverFoto)
                <div class="mb-3">
                  <p class="text-sm text-muted mb-2">Cover Saat Ini:</p>
                  <div class="flex items-start gap-4">
                    <img src="{{ $berita->cover_foto_url }}"
                         alt="Cover {{ $berita->judul }}"
                         class="cover-img-preview rounded-lg border">
                    <div class="flex-1">
                      <p class="font-medium mb-1">{{ $coverFoto->file_name }}</p>
                      <small class="text-gray-500 block mb-2">{{ $coverFoto->mime_type }}</small>
                      <a href="{{ route('berita.delete-file', ['berita' => $berita->berita_id, 'file' => $coverFoto->media_id]) }}"
                         class="button is-small is-danger"
                         onclick="return confirm('Yakin ingin menghapus cover foto ini?')">
                        <span class="icon"><i class="mdi mdi-delete"></i></span>
                        <span>Hapus Cover</span>
                      </a>
                    </div>
                  </div>
                </div>
              @else
                <div class="mb-3">
                  <p class="text-sm text-muted">Belum ada cover foto</p>
                </div>
              @endif

              <div class="control">
                <input class="input @error('cover_foto') is-danger @enderror"
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

            <!-- Upload Gambar Pendukung Multiple -->
            @php
              $gambarPendukung = $berita->media->where('sort_order', '>', 1);
            @endphp
            <div class="field">
              <label class="label">Gambar Pendukung Tambahan</label>

              <!-- Tampilkan Gambar Pendukung Saat Ini -->
              @if($gambarPendukung->count() > 0)
                <div class="mb-3">
                  <p class="text-sm text-muted mb-2">Gambar Pendukung Saat Ini:</p>
                  <div class="space-y-2">
                    @foreach($gambarPendukung as $gambar)
                      <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div class="flex items-center gap-3">
                          <img src="{{ asset('storage/media/berita/gallery/' . $gambar->file_name) }}"
                               alt="{{ $gambar->file_name }}"
                               class="gallery-thumb rounded border"
                               onerror="this.style.display='none'">
                          <div>
                            <span class="font-medium block">{{ $gambar->file_name }}</span>
                            <small class="text-gray-500">{{ $gambar->mime_type }}</small>
                          </div>
                        </div>
                        <a href="{{ route('berita.delete-file', ['berita' => $berita->berita_id, 'file' => $gambar->media_id]) }}"
                           class="button is-small is-danger"
                           onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                          <span class="icon"><i class="mdi mdi-delete"></i></span>
                        </a>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif

              <div class="control">
                <input class="input @error('gambar_pendukung') is-danger @enderror"
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

          <!-- Konten Berita - Full Width -->
          <div class="col-12">
            <div class="field">
              <label class="label">Isi Berita (HTML) <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <textarea class="textarea @error('isi_html') is-danger @enderror"
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

          <!-- Tombol Aksi -->
          <div class="col-12">
            <div class="field grouped">
              <div class="control">
                <button type="submit" class="button green">
                  <span class="icon"><i class="mdi mdi-content-save"></i></span>
                  <span>Update Berita</span>
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

  .button.is-danger {
    background-color: #ef4444;
    color: white;
    border: none;
  }

  .button.is-small {
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
  }

  .button.green:hover {
    background-color: #059669;
  }

  .button.light:hover {
    background-color: #e5e7eb;
  }

  .button.is-danger:hover {
    background-color: #dc2626;
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

  /* Image preview styling */
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
    font-size: 0.875rem;
  }

  /* Utility classes */
  .flex {
    display: flex;
  }

  .items-center {
    align-items: center;
  }

  .items-start {
    align-items: flex-start;
  }

  .justify-between {
    justify-content: space-between;
  }

  .gap-3 {
    gap: 0.75rem;
  }

  .gap-4 {
    gap: 1rem;
  }

  .space-y-2 > * + * {
    margin-top: 0.5rem;
  }

  .mb-2 {
    margin-bottom: 0.5rem;
  }

  .mb-3 {
    margin-bottom: 1rem;
  }

  .p-3 {
    padding: 0.75rem;
  }

  .bg-gray-50 {
    background-color: #f9fafb;
  }

  .rounded {
    border-radius: 0.375rem;
  }

  .rounded-lg {
    border-radius: 0.5rem;
  }

  .border {
    border: 1px solid #e5e7eb;
  }

  .block {
    display: block;
  }

  .font-medium {
    font-weight: 500;
  }

  .text-gray-500 {
    color: #6b7280;
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

    .cover-img-preview {
      width: 120px;
      height: 80px;
    }

    .flex.items-start.gap-4 {
      flex-direction: column;
      gap: 1rem;
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
    if (resetButton) {
      resetButton.addEventListener('click', function() {
        setTimeout(() => {
          // Clear any generated slug when resetting
          if (slugInput.value === judulInput.value.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-')) {
            slugInput.value = '{{ $berita->slug }}';
          }
        }, 100);
      });
    }
  }
});
</script>
@endsection
