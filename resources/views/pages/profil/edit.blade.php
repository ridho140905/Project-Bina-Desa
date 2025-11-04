@extends('layouts.admin.app')

@section('content')

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Profil Desa</li>
      <li>Edit Profil</li>
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
      Edit Profil Desa - {{ $dataProfil->nama_desa }}
    </h1>
    <a href="{{ route('profil.index') }}" class="button light">
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
        <span class="icon"><i class="mdi mdi-home-city"></i></span>
        Form Edit Profil Desa
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('profil.update', $dataProfil->profil_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="columns is-multiline">
          <!-- Kolom Kiri - Informasi Dasar Desa -->
          <div class="column is-half">
            <div class="field">
              <label class="label">Nama Desa <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('nama_desa') is-danger @enderror"
                       type="text"
                       name="nama_desa"
                       value="{{ old('nama_desa', $dataProfil->nama_desa) }}"
                       placeholder="Masukkan nama desa"
                       required>
                <span class="icon left"><i class="mdi mdi-home"></i></span>
              </div>
              @error('nama_desa')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Kecamatan <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('kecamatan') is-danger @enderror"
                       type="text"
                       name="kecamatan"
                       value="{{ old('kecamatan', $dataProfil->kecamatan) }}"
                       placeholder="Masukkan nama kecamatan"
                       required>
                <span class="icon left"><i class="mdi mdi-map-marker"></i></span>
              </div>
              @error('kecamatan')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Kabupaten <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('kabupaten') is-danger @enderror"
                       type="text"
                       name="kabupaten"
                       value="{{ old('kabupaten', $dataProfil->kabupaten) }}"
                       placeholder="Masukkan nama kabupaten"
                       required>
                <span class="icon left"><i class="mdi mdi-city"></i></span>
              </div>
              @error('kabupaten')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan - Informasi Wilayah -->
          <div class="column is-half">
            <div class="field">
              <label class="label">Provinsi <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('provinsi') is-danger @enderror"
                       type="text"
                       name="provinsi"
                       value="{{ old('provinsi', $dataProfil->provinsi) }}"
                       placeholder="Masukkan nama provinsi"
                       required>
                <span class="icon left"><i class="mdi mdi-earth"></i></span>
              </div>
              @error('provinsi')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Telepon <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('telepon') is-danger @enderror"
                       type="text"
                       name="telepon"
                       value="{{ old('telepon', $dataProfil->telepon) }}"
                       placeholder="Contoh: 081234567890"
                       required>
                <span class="icon left"><i class="mdi mdi-phone"></i></span>
              </div>
              @error('telepon')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Email <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('email') is-danger @enderror"
                       type="email"
                       name="email"
                       value="{{ old('email', $dataProfil->email) }}"
                       placeholder="contoh: desa@example.com"
                       required>
                <span class="icon left"><i class="mdi mdi-email"></i></span>
              </div>
              @error('email')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Alamat Kantor - Full Width -->
          <div class="column is-full">
            <div class="field">
              <label class="label">Alamat Kantor <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <textarea class="textarea @error('alamat_kantor') is-danger @enderror"
                          name="alamat_kantor"
                          rows="3"
                          placeholder="Masukkan alamat lengkap kantor desa"
                          required>{{ old('alamat_kantor', $dataProfil->alamat_kantor) }}</textarea>
                <span class="icon left"><i class="mdi mdi-office-building"></i></span>
              </div>
              @error('alamat_kantor')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kiri - Visi -->
          <div class="column is-half">
            <div class="field">
              <label class="label">Visi <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <textarea class="textarea @error('visi') is-danger @enderror"
                          name="visi"
                          rows="4"
                          placeholder="Tuliskan visi desa"
                          required>{{ old('visi', $dataProfil->visi) }}</textarea>
                <span class="icon left"><i class="mdi mdi-target"></i></span>
              </div>
              @error('visi')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan - Misi -->
          <div class="column is-half">
            <div class="field">
              <label class="label">Misi <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <textarea class="textarea @error('misi') is-danger @enderror"
                          name="misi"
                          rows="4"
                          placeholder="Tuliskan misi desa"
                          required>{{ old('misi', $dataProfil->misi) }}</textarea>
                <span class="icon left"><i class="mdi mdi-bullseye-arrow"></i></span>
              </div>
              @error('misi')
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
              <span>Update Data</span>
            </button>
          </div>
          <div class="control">
            <a href="{{ route('profil.index') }}" class="button red">
              <span class="icon"><i class="mdi mdi-close"></i></span>
              <span>Batal</span>
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>

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

  .textarea {
    resize: vertical;
    min-height: 80px;
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

  .button.red {
    background-color: #ef4444;
    color: white;
    border: none;
  }

  .button.red:hover {
    background-color: #dc2626;
  }
</style>
@endsection
