@extends('layouts.admin.app')

@section('content')
<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Data Warga</li>
      <li>Tambah Warga</li>
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
      Tambah Data Warga
    </h1>
    <a href="{{ route('warga.index') }}" class="button light">
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
        <span class="icon"><i class="mdi mdi-account-plus"></i></span>
        Form Tambah Data Warga
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('warga.store') }}" method="POST">
        @csrf

        <div class="row">
          <!-- Kolom Kiri -->
          <div class="col-md-6">
            <!-- No KTP -->
            <div class="field">
              <label class="label">No KTP <span class="text-danger">*</span></label>
              <div class="control">
                <div style="position: relative;">
                  <input class="input @error('no_ktp') is-danger @enderror"
                         type="text"
                         name="no_ktp"
                         value="{{ old('no_ktp') }}"
                         placeholder="Masukkan nomor KTP (16 digit)"
                         maxlength="16"
                         required>
                  <i class="mdi mdi-card-account-details icon-left"></i>
                </div>
              </div>
              @error('no_ktp')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Nama Lengkap -->
            <div class="field">
              <label class="label">Nama Lengkap <span class="text-danger">*</span></label>
              <div class="control">
                <div style="position: relative;">
                  <input class="input @error('nama') is-danger @enderror"
                         type="text"
                         name="nama"
                         value="{{ old('nama') }}"
                         placeholder="Masukkan nama lengkap"
                         required>
                  <i class="mdi mdi-account icon-left"></i>
                </div>
              </div>
              @error('nama')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div class="field">
              <label class="label">Jenis Kelamin <span class="text-danger">*</span></label>
              <div class="control">
                <div class="select-wrapper">
                  <div class="select is-fullwidth @error('jenis_kelamin') is-danger @enderror">
                    <select name="jenis_kelamin" required>
                      <option value="">Pilih Jenis Kelamin</option>
                      <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                      <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <i class="mdi mdi-gender-male-female icon-left"></i>
                  </div>
                </div>
              </div>
              @error('jenis_kelamin')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Agama -->
            <div class="field">
              <label class="label">Agama <span class="text-danger">*</span></label>
              <div class="control">
                <div class="select-wrapper">
                  <div class="select is-fullwidth @error('agama') is-danger @enderror">
                    <select name="agama" required>
                      <option value="">Pilih Agama</option>
                      <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                      <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                      <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                      <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                      <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                      <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    <i class="mdi mdi-pray icon-left"></i>
                  </div>
                </div>
              </div>
              @error('agama')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan -->
          <div class="col-md-6">
            <!-- Pekerjaan -->
            <div class="field">
              <label class="label">Pekerjaan <span class="text-danger">*</span></label>
              <div class="control">
                <div style="position: relative;">
                  <input class="input @error('pekerjaan') is-danger @enderror"
                         type="text"
                         name="pekerjaan"
                         value="{{ old('pekerjaan') }}"
                         placeholder="Masukkan pekerjaan"
                         required>
                  <i class="mdi mdi-briefcase icon-left"></i>
                </div>
              </div>
              @error('pekerjaan')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Telepon -->
            <div class="field">
              <label class="label">Telepon</label>
              <div class="control">
                <div style="position: relative;">
                  <input class="input @error('telp') is-danger @enderror"
                         type="text"
                         name="telp"
                         value="{{ old('telp') }}"
                         placeholder="Contoh: 081234567890"
                         maxlength="15">
                  <i class="mdi mdi-phone icon-left"></i>
                </div>
              </div>
              @error('telp')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Email -->
            <div class="field">
              <label class="label">Email</label>
              <div class="control">
                <div style="position: relative;">
                  <input class="input @error('email') is-danger @enderror"
                         type="email"
                         name="email"
                         value="{{ old('email') }}"
                         placeholder="contoh: warga@example.com">
                  <i class="mdi mdi-email icon-left"></i>
                </div>
              </div>
              @error('email')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Alamat -->
            <div class="field">
              <label class="label">Alamat</label>
              <div class="control">
                <div style="position: relative;">
                  <textarea class="textarea @error('alamat') is-danger @enderror"
                            name="alamat"
                            placeholder="Masukkan alamat lengkap"
                            rows="3">{{ old('alamat') }}</textarea>
                  <i class="mdi mdi-home icon-left"></i>
                </div>
              </div>
              @error('alamat')
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
                  <span>Simpan Data</span>
                </button>
              </div>
              <div class="control">
                <a href="{{ route('warga.index') }}" class="button light">
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
    min-height: 80px;
  }

  .input:focus,
  .textarea:focus,
  .select select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  /* Icon styling */
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
  .textarea + .icon-left {
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
  }
</style>

<!-- Load Material Design Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
@endsection
