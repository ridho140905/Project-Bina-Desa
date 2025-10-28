@extends('layouts.admin.app')

@section('title', 'Edit Profil Desa')
@section('description', 'Form untuk mengedit data profil desa yang sudah ada')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">
                    <span class="icon"><i class="mdi mdi-home"></i></span>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('profil.index') }}">Profil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Profil</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit Profil Desa</h1>
            <p class="mb-0">Form untuk mengedit data profil desa {{ $dataProfil->nama_desa }}</p>
        </div>
        <div>
            <a href="{{ route('profil.index') }}" class="button light">
                <span class="icon"><i class="mdi mdi-arrow-left"></i></span>
                <span>Kembali</span>
            </a>
        </div>
    </div>
</div>

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
<div class="notification is-info">
    {!! session('success') !!}
</div>
@endif

<div class="card">
    <header class="card-header">
        <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-ballot"></i></span>
            Form Edit Profil Desa
        </p>
    </header>
    <div class="card-content">
        <form action="{{ route('profil.update', $dataProfil->profil_id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Informasi Utama -->
            <div class="field">
                <label class="label">Nama Desa</label>
                <div class="control icons-left">
                    <input class="input @error('nama_desa') is-danger @enderror"
                           type="text"
                           name="nama_desa"
                           value="{{ old('nama_desa', $dataProfil->nama_desa) }}"
                           placeholder="Masukkan nama desa"
                           required>
                    <span class="icon left"><i class="mdi mdi-home-city"></i></span>
                </div>
                @error('nama_desa')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="columns is-multiline">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Kecamatan</label>
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
                </div>

                <div class="column is-half">
                    <div class="field">
                        <label class="label">Kabupaten</label>
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

                <div class="column is-half">
                    <div class="field">
                        <label class="label">Provinsi</label>
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
                </div>

                <div class="column is-half">
                    <div class="field">
                        <label class="label">Telepon</label>
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
                </div>
            </div>

            <div class="field">
                <label class="label">Email</label>
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

            <div class="field">
                <label class="label">Alamat Kantor</label>
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

            <div class="field">
                <label class="label">Visi</label>
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

            <div class="field">
                <label class="label">Misi</label>
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

            <hr>

            <div class="field is-grouped">
                <div class="control">
                    <button type="submit" class="button green">
                        <span class="icon"><i class="mdi mdi-content-save"></i></span>
                        <span>Update Data</span>
                    </button>
                </div>
                <div class="control">
                    <a href="{{ route('profil.index') }}" class="button light">
                        <span class="icon"><i class="mdi mdi-close"></i></span>
                        <span>Batal</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
