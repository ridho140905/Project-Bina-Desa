@extends('layouts.admin.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">
                    <span class="icon"><i class="mdi mdi-home"></i></span>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Data User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
    </nav>
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

<div class="card">
    <header class="card-header">
        <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-edit"></i></span>
            Form Edit User
        </p>
    </header>
    <div class="card-content">
        <form action="{{ route('user.update', $dataUser->id) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="columns is-multiline">
                <!-- Nama Lengkap -->
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Nama Lengkap <span class="text-danger">*</span></label>
                        <div class="control icons-left">
                            <input class="input @error('name') is-danger @enderror"
                                   type="text"
                                   name="name"
                                   value="{{ old('name', $dataUser->name) }}"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            <span class="icon left"><i class="mdi mdi-account"></i></span>
                        </div>
                        @error('name')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Email <span class="text-danger">*</span></label>
                        <div class="control icons-left">
                            <input class="input @error('email') is-danger @enderror"
                                   type="email"
                                   name="email"
                                   value="{{ old('email', $dataUser->email) }}"
                                   placeholder="contoh: user@example.com"
                                   required>
                            <span class="icon left"><i class="mdi mdi-email"></i></span>
                        </div>
                        @error('email')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control icons-left">
                            <input class="input @error('password') is-danger @enderror"
                                   type="password"
                                   name="password"
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                            <span class="icon left"><i class="mdi mdi-lock"></i></span>
                        </div>
                        <p class="help is-info">Biarkan kosong jika tidak ingin mengubah password</p>
                        @error('password')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Konfirmasi Password</label>
                        <div class="control icons-left">
                            <input class="input @error('password_confirmation') is-danger @enderror"
                                   type="password"
                                   name="password_confirmation"
                                   placeholder="Konfirmasi password">
                            <span class="icon left"><i class="mdi mdi-lock-check"></i></span>
                        </div>
                        @error('password_confirmation')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <button type="submit" class="button green">
                        <span class="icon"><i class="mdi mdi-content-save"></i></span>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
                <div class="control">
                    <a href="{{ route('user.index') }}" class="button light">
                        <span class="icon"><i class="mdi mdi-close"></i></span>
                        <span>Batal</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
