@extends('layouts.admin.app')

@section('content')

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Agenda</li>
      <li>Tambah Agenda</li>
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
      Tambah Agenda Baru
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
        <span class="icon"><i class="mdi mdi-calendar-plus"></i></span>
        Form Tambah Agenda
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('agenda.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
          <!-- Kolom Kiri - Informasi Dasar Agenda -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Judul Agenda <span class="text-danger">*</span></label>
              <div class="control">
                <div class="input-with-icon">
                  <input class="input @error('judul') is-danger @enderror"
                         type="text"
                         name="judul"
                         value="{{ old('judul') }}"
                         placeholder="Masukkan judul agenda"
                         required>
                  <span class="input-icon">
                    <i class="mdi mdi-format-title"></i>
                  </span>
                </div>
              </div>
              @error('judul')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Lokasi <span class="text-danger">*</span></label>
              <div class="control">
                <div class="input-with-icon">
                  <input class="input @error('lokasi') is-danger @enderror"
                         type="text"
                         name="lokasi"
                         value="{{ old('lokasi') }}"
                         placeholder="Masukkan lokasi agenda"
                         required>
                  <span class="input-icon">
                    <i class="mdi mdi-map-marker"></i>
                  </span>
                </div>
              </div>
              @error('lokasi')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Penyelenggara <span class="text-danger">*</span></label>
              <div class="control">
                <div class="input-with-icon">
                  <input class="input @error('penyelenggara') is-danger @enderror"
                         type="text"
                         name="penyelenggara"
                         value="{{ old('penyelenggara') }}"
                         placeholder="Masukkan nama penyelenggara"
                         required>
                  <span class="input-icon">
                    <i class="mdi mdi-account-group"></i>
                  </span>
                </div>
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
              <div class="control">
                <div class="input-with-icon">
                  <input class="input @error('tanggal_mulai') is-danger @enderror"
                         type="datetime-local"
                         name="tanggal_mulai"
                         value="{{ old('tanggal_mulai') }}"
                         required>
                  <span class="input-icon">
                    <i class="mdi mdi-calendar-clock"></i>
                  </span>
                </div>
              </div>
              @error('tanggal_mulai')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Tanggal Selesai <span class="text-danger">*</span></label>
              <div class="control">
                <div class="input-with-icon">
                  <input class="input @error('tanggal_selesai') is-danger @enderror"
                         type="datetime-local"
                         name="tanggal_selesai"
                         value="{{ old('tanggal_selesai') }}"
                         required>
                  <span class="input-icon">
                    <i class="mdi mdi-calendar-check"></i>
                  </span>
                </div>
              </div>
              @error('tanggal_selesai')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Upload Poster - INPUT FILE DEFAULT BROWSER -->
            <div class="field">
              <label class="label">Poster Agenda</label>
              <div class="control">
                <input class="input @error('poster') is-danger @enderror"
                       type="file"
                       name="poster"
                       accept="image/*">
              </div>
              <small class="form-text text-muted">
                Format: JPG, JPEG, PNG, GIF, WebP. Maksimal 2MB.
              </small>
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
                <div class="textarea-with-icon">
                  <textarea class="textarea @error('deskripsi') is-danger @enderror"
                            name="deskripsi"
                            rows="4"
                            placeholder="Masukkan deskripsi lengkap agenda (opsional)">{{ old('deskripsi') }}</textarea>
                  <span class="textarea-icon">
                    <i class="mdi mdi-text"></i>
                  </span>
                </div>
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
                  <span>Simpan Agenda</span>
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

  /* Input dengan icon */
  .input-with-icon,
  .textarea-with-icon {
    position: relative;
    width: 100%;
  }

  .input-with-icon .input,
  .textarea-with-icon .textarea {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background-color: white;
    font-family: inherit;
  }

  .input-with-icon .input-icon,
  .textarea-with-icon .textarea-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    z-index: 2;
    pointer-events: none;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    height: 1.5rem;
  }

  /* Khusus untuk textarea icon */
  .textarea-with-icon .textarea-icon {
    top: 1.25rem;
    transform: none;
    align-items: flex-start;
  }

  .textarea-with-icon .textarea {
    min-height: 120px;
    resize: vertical;
  }

  /* Input file default - TANPA STYLING CUSTOM */
  input[type="file"] {
    width: 100%;
    padding: 0.5rem;
    background-color: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
  }

  /* Focus state */
  .input:focus,
  .textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  /* Helper text */
  .form-text.text-muted {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.5rem;
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
  .textarea.is-danger {
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
    border: none;
    text-decoration: none;
  }

  .button.green {
    background-color: #10b981;
    color: white;
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

    .input-with-icon .input,
    .textarea-with-icon .textarea {
      padding-left: 2.5rem;
    }

    .input-with-icon .input-icon,
    .textarea-with-icon .textarea-icon {
      left: 0.5rem;
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set min datetime for date inputs to current datetime
    const now = new Date();
    const timezoneOffset = now.getTimezoneOffset() * 60000;
    const localISOTime = new Date(now - timezoneOffset).toISOString().slice(0, 16);

    const startDateInput = document.querySelector('input[name="tanggal_mulai"]');
    const endDateInput = document.querySelector('input[name="tanggal_selesai"]');

    // Set minimum date to current datetime
    if (startDateInput) {
        startDateInput.min = localISOTime;
    }

    if (endDateInput) {
        endDateInput.min = localISOTime;
    }

    // Validate end date is after start date
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
});
</script>
@endsection
