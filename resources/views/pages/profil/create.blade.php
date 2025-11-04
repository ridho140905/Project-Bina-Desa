@extends('layouts.admin.app')

@section('content')

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Profil Desa</li>
      <li>Tambah Profil</li>
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
      Tambah Profil Desa
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

  <div class="card">
    <header class="card-header">
      <p class="card-header-title">
        <span class="icon"><i class="mdi mdi-home-city"></i></span>
        Form Tambah Profil Desa
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('profil.store') }}" method="POST">
        @csrf

        <div class="columns is-multiline">
          <!-- Kolom Kiri - Informasi Dasar Desa -->
          <div class="column is-half">
            <div class="field">
              <label class="label">Nama Desa <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('nama_desa') is-danger @enderror"
                       type="text"
                       name="nama_desa"
                       value="{{ old('nama_desa') }}"
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
                       value="{{ old('kecamatan') }}"
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
                       value="{{ old('kabupaten') }}"
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
                       value="{{ old('provinsi') }}"
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
                       value="{{ old('telepon') }}"
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
                       value="{{ old('email') }}"
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
                          required>{{ old('alamat_kantor') }}</textarea>
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
                          required>{{ old('visi') }}</textarea>
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
                          required>{{ old('misi') }}</textarea>
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
              <span>Simpan Data</span>
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

  <!-- Additional Cards Section -->
  <div class="columns is-multiline mt-6">
    <!-- Card Pertanyaan Umum -->
    <div class="column is-half">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-help-circle"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
