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

        <div class="columns is-multiline">
          <!-- No KTP -->
          <div class="column is-half">
            <div class="field">
              <label class="label">No KTP <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('no_ktp') is-danger @enderror"
                       type="text"
                       name="no_ktp"
                       value="{{ old('no_ktp') }}"
                       placeholder="Masukkan nomor KTP (16 digit)"
                       maxlength="16"
                       required>
                <span class="icon left"><i class="mdi mdi-card-account-details"></i></span>
              </div>
              @error('no_ktp')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Nama Lengkap -->
          <div class="column is-half">
            <div class="field">
              <label class="label">Nama Lengkap <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('nama') is-danger @enderror"
                       type="text"
                       name="nama"
                       value="{{ old('nama') }}"
                       placeholder="Masukkan nama lengkap"
                       required>
                <span class="icon left"><i class="mdi mdi-account"></i></span>
              </div>
              @error('nama')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Jenis Kelamin -->
          <div class="column is-half">
            <div class="field">
              <label class="label">Jenis Kelamin <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <div class="select is-fullwidth @error('jenis_kelamin') is-danger @enderror">
                  <select name="jenis_kelamin" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                </div>
                <span class="icon left"><i class="mdi mdi-gender-male-female"></i></span>
              </div>
              @error('jenis_kelamin')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Agama -->
          <div class="column is-half">
            <div class="field">
              <label class="label">Agama <span class="text-danger">*</span></label>
              <div class="control icons-left">
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
                </div>
                <span class="icon left"><i class="mdi mdi-pray"></i></span>
              </div>
              @error('agama')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Pekerjaan -->
          <div class="column is-half">
            <div class="field">
              <label class="label">Pekerjaan <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('pekerjaan') is-danger @enderror"
                       type="text"
                       name="pekerjaan"
                       value="{{ old('pekerjaan') }}"
                       placeholder="Masukkan pekerjaan"
                       required>
                <span class="icon left"><i class="mdi mdi-briefcase"></i></span>
              </div>
              @error('pekerjaan')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Telepon -->
          <div class="column is-half">
            <div class="field">
              <label class="label">Telepon</label>
              <div class="control icons-left">
                <input class="input @error('telp') is-danger @enderror"
                       type="text"
                       name="telp"
                       value="{{ old('telp') }}"
                       placeholder="Contoh: 081234567890"
                       maxlength="15">
                <span class="icon left"><i class="mdi mdi-phone"></i></span>
              </div>
              @error('telp')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Email -->
          <div class="column is-full">
            <div class="field">
              <label class="label">Email</label>
              <div class="control icons-left">
                <input class="input @error('email') is-danger @enderror"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="contoh: warga@example.com">
                <span class="icon left"><i class="mdi mdi-email"></i></span>
              </div>
              @error('email')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <div class="field is-grouped">
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
      </form>
    </div>
  </div>
</section>

<style>
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

  .text-danger {
    color: #dc2626;
  }

  .button.green {
    background-color: #10b981;
    color: white;
    border: none;
  }

  .button.green:hover {
    background-color: #059669;
  }
</style>
@endsection
