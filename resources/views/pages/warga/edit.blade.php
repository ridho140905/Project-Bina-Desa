@extends('layouts.admin.app')

@section('content')
<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Data Warga</li>
      <li>Edit Warga</li>
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
      Edit Data Warga - {{ $warga->nama }}
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
        <span class="icon"><i class="mdi mdi-account-edit"></i></span>
        Form Edit Data Warga
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('warga.update', $warga->warga_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
          <!-- Kolom Kiri -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">No KTP <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('no_ktp') is-danger @enderror"
                       type="text"
                       name="no_ktp"
                       value="{{ old('no_ktp', $warga->no_ktp) }}"
                       placeholder="Masukkan nomor KTP (16 digit)"
                       maxlength="16"
                       required>
                <span class="icon left"><i class="mdi mdi-card-account-details"></i></span>
              </div>
              @error('no_ktp')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Nama Lengkap <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('nama') is-danger @enderror"
                       type="text"
                       name="nama"
                       value="{{ old('nama', $warga->nama) }}"
                       placeholder="Masukkan nama lengkap"
                       required>
                <span class="icon left"><i class="mdi mdi-account"></i></span>
              </div>
              @error('nama')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Jenis Kelamin <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <div class="select is-fullwidth @error('jenis_kelamin') is-danger @enderror">
                  <select name="jenis_kelamin" required class="input">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                </div>
                <span class="icon left"><i class="mdi mdi-gender-male-female"></i></span>
              </div>
              @error('jenis_kelamin')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Agama <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <div class="select is-fullwidth @error('agama') is-danger @enderror">
                  <select name="agama" required class="input">
                    <option value="">Pilih Agama</option>
                    <option value="Islam" {{ old('agama', $warga->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ old('agama', $warga->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ old('agama', $warga->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ old('agama', $warga->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ old('agama', $warga->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Konghucu" {{ old('agama', $warga->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                  </select>
                </div>
                <span class="icon left"><i class="mdi mdi-pray"></i></span>
              </div>
              @error('agama')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Pekerjaan <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('pekerjaan') is-danger @enderror"
                       type="text"
                       name="pekerjaan"
                       value="{{ old('pekerjaan', $warga->pekerjaan) }}"
                       placeholder="Masukkan pekerjaan"
                       required>
                <span class="icon left"><i class="mdi mdi-briefcase"></i></span>
              </div>
              @error('pekerjaan')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Telepon</label>
              <div class="control icons-left">
                <input class="input @error('telp') is-danger @enderror"
                       type="text"
                       name="telp"
                       value="{{ old('telp', $warga->telp) }}"
                       placeholder="Contoh: 081234567890"
                       maxlength="15">
                <span class="icon left"><i class="mdi mdi-phone"></i></span>
              </div>
              @error('telp')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Email</label>
              <div class="control icons-left">
                <input class="input @error('email') is-danger @enderror"
                       type="email"
                       name="email"
                       value="{{ old('email', $warga->email) }}"
                       placeholder="contoh: warga@example.com">
                <span class="icon left"><i class="mdi mdi-email"></i></span>
              </div>
              @error('email')
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
                  <span>Update Data</span>
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

  .input,
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
  .select select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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

  /* Icons styling untuk input dan select */
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

  /* Khusus untuk select dengan icon */
  .control.icons-left .select select {
    padding-left: 3rem;
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
    .control.icons-left .select select {
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
@endsection
