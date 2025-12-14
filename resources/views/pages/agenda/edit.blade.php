@extends('layouts.admin.app')

@section('content')

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Agenda</li>
      <li>Edit Agenda</li>
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
      Edit Agenda - {{ $dataAgenda->judul }}
    </h1>
    <a href="{{ route('agenda.index') }}" class="button light">
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
        <span class="icon"><i class="mdi mdi-calendar-edit"></i></span>
        Form Edit Agenda
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('agenda.update', $dataAgenda->agenda_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
          <!-- Kolom Kiri - Informasi Dasar Agenda -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Judul Agenda <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('judul') is-danger @enderror"
                       type="text"
                       name="judul"
                       value="{{ old('judul', $dataAgenda->judul) }}"
                       placeholder="Masukkan judul agenda"
                       required>
                <span class="icon left"><i class="mdi mdi-format-title"></i></span>
              </div>
              @error('judul')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Lokasi <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('lokasi') is-danger @enderror"
                       type="text"
                       name="lokasi"
                       value="{{ old('lokasi', $dataAgenda->lokasi) }}"
                       placeholder="Masukkan lokasi agenda"
                       required>
                <span class="icon left"><i class="mdi mdi-map-marker"></i></span>
              </div>
              @error('lokasi')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Penyelenggara <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('penyelenggara') is-danger @enderror"
                       type="text"
                       name="penyelenggara"
                       value="{{ old('penyelenggara', $dataAgenda->penyelenggara) }}"
                       placeholder="Masukkan nama penyelenggara"
                       required>
                <span class="icon left"><i class="mdi mdi-account-group"></i></span>
              </div>
              @error('penyelenggara')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan - Informasi Waktu & Upload -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Tanggal Mulai <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('tanggal_mulai') is-danger @enderror"
                       type="datetime-local"
                       name="tanggal_mulai"
                       value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($dataAgenda->tanggal_mulai)->format('Y-m-d\TH:i')) }}"
                       required>
                <span class="icon left"><i class="mdi mdi-calendar-clock"></i></span>
              </div>
              @error('tanggal_mulai')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Tanggal Selesai <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('tanggal_selesai') is-danger @enderror"
                       type="datetime-local"
                       name="tanggal_selesai"
                       value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($dataAgenda->tanggal_selesai)->format('Y-m-d\TH:i')) }}"
                       required>
                <span class="icon left"><i class="mdi mdi-calendar-check"></i></span>
              </div>
              @error('tanggal_selesai')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Upload Poster -->
            @php
                $poster = $dataAgenda->media->where('sort_order', 1)->first();
            @endphp
            <div class="field">
              <label class="label">Poster Agenda</label>

              <!-- Preview Poster Saat Ini -->
              @if($poster)
                <div class="mb-3">
                  <p class="text-sm text-muted">Poster Saat Ini:</p>
                  <img src="{{ asset('storage/media/agenda/' . $poster->file_name) }}"
                       alt="Poster {{ $dataAgenda->judul }}"
                       class="profile-img-preview rounded"
                       onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';">
                  <div class="no-image-preview" style="display: none;">
                    <div class="no-image-placeholder">
                      <i class="mdi mdi-image-off"></i>
                    </div>
                  </div>
                  <p class="text-xs text-muted mt-1">{{ $poster->file_name }}</p>
                </div>
              @else
                <div class="mb-3">
                  <p class="text-sm text-muted">Belum ada poster</p>
                  <div class="no-image-placeholder">
                    <i class="mdi mdi-image-off"></i>
                  </div>
                </div>
              @endif

              <div class="control">
                <input class="input @error('poster') is-danger @enderror"
                       type="file"
                       name="poster"
                       accept="image/*">
              </div>
              <p class="help">Biarkan kosong jika tidak ingin mengubah poster. Format: JPG, JPEG, PNG, GIF, WebP. Maksimal 2MB.</p>
              @error('poster')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Deskripsi - Full Width -->
          <div class="col-12">
            <div class="field">
              <label class="label">Deskripsi Agenda</label>
              <div class="control">
                <textarea class="textarea @error('deskripsi') is-danger @enderror"
                          name="deskripsi"
                          rows="4"
                          placeholder="Masukkan deskripsi lengkap agenda (opsional)">{{ old('deskripsi', $dataAgenda->deskripsi) }}</textarea>
              </div>
              @error('deskripsi')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Upload Gambar Pendukung Multiple -->
          <div class="col-12">
            <div class="field">
              <label class="label">Gambar Pendukung Tambahan</label>

              <!-- Tampilkan Gambar Pendukung Saat Ini -->
              @php
                  $gambarPendukung = $dataAgenda->media->where('sort_order', '>', 1);
              @endphp

              @if($gambarPendukung->count() > 0)
                <div class="mb-3">
                  <p class="text-sm text-muted">Gambar Pendukung Saat Ini:</p>
                  <div class="file-list">
                    @foreach($gambarPendukung as $gambar)
                      <div class="file-item d-flex align-items-center justify-content-between mb-2 p-2 bg-light rounded">
                        <div class="file-info d-flex align-items-center">
                          <img src="{{ asset('storage/media/agenda/' . $gambar->file_name) }}"
                               alt="{{ $gambar->file_name }}"
                               class="gambar-preview-small me-3"
                               onerror="this.onerror=null; this.style.display='none';">
                          <div>
                            <span class="file-name">{{ $gambar->file_name }}</span>
                            <small class="text-muted d-block">{{ $gambar->mime_type }}</small>
                          </div>
                        </div>
                        <div class="file-actions">
                          <form action="{{ route('agenda.delete-file', ['agenda' => $dataAgenda->agenda_id, 'file' => $gambar->media_id]) }}"
                                method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="button light"
                                    onclick="return confirm('Yakin ingin menghapus gambar ini?')"
                                    title="Hapus Gambar">
                              <span class="icon"><i class="mdi mdi-delete"></i></span>
                              <span>Hapus</span>
                            </button>
                          </form>
                        </div>
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
              <p class="help">Upload gambar tambahan selain poster. Format: JPG, JPEG, PNG, GIF, WebP. Maksimal 5 file, 2MB per file.</p>
              @error('gambar_pendukung')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
              @error('gambar_pendukung.*')
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
                  <span>Update Agenda</span>
                </button>
              </div>
              <div class="control">
                <button type="reset" class="button light">
                  <span class="icon"><i class="mdi mdi-refresh"></i></span>
                  <span>Reset Form</span>
                </button>
              </div>
              <div class="control">
                <a href="{{ route('agenda.index') }}" class="button light">
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

  /* Style khusus untuk input datetime */
  input[type="datetime-local"] {
    font-family: inherit;
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
  .profile-img-preview {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    display: block;
  }

  .gambar-preview-small {
    width: 50px;
    height: 50px;
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
    max-height: 200px;
    overflow-y: auto;
  }

  .file-item {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
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
    width: 150px;
    height: 150px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 48px;
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
    }

    .file-actions {
      align-self: flex-end;
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate end date is after start date
    const startDateInput = document.querySelector('input[name="tanggal_mulai"]');
    const endDateInput = document.querySelector('input[name="tanggal_selesai"]');

    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;

            if (endDateInput.value && endDateInput.value < this.value) {
                endDateInput.value = this.value;
            }
        });

        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && this.value < startDateInput.value) {
                alert('Tanggal selesai harus setelah tanggal mulai');
                this.value = startDateInput.value;
            }
        });
    }

    // Validasi file size untuk poster
    const posterInput = document.querySelector('input[name="poster"]');
    if (posterInput) {
        posterInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('Ukuran file poster maksimal 2MB');
                    this.value = '';
                }

                // Validasi tipe file harus gambar
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar');
                    this.value = '';
                }
            }
        });
    }

    // Validasi file size untuk gambar pendukung
    const gambarInput = document.querySelector('input[name="gambar_pendukung[]"]');
    if (gambarInput) {
        gambarInput.addEventListener('change', function() {
            const files = this.files;
            const maxSize = 2 * 1024 * 1024; // 2MB per file
            const maxFiles = 5;

            if (files.length > maxFiles) {
                alert(`Maksimal ${maxFiles} gambar yang dapat diupload`);
                this.value = '';
                return;
            }

            for (let file of files) {
                if (file.size > maxSize) {
                    alert(`Gambar ${file.name} melebihi ukuran maksimal 2MB`);
                    this.value = '';
                    break;
                }

                // Validasi tipe file harus gambar
                if (!file.type.startsWith('image/')) {
                    alert(`File ${file.name} bukan gambar. Hanya file gambar yang diperbolehkan`);
                    this.value = '';
                    break;
                }
            }
        });
    }
});
</script>
@endsection
