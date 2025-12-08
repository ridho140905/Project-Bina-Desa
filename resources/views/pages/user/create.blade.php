@extends('layouts.admin.app')

@section('content')

    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
            <ul>
                <li>Admin</li>
                <li>Data User</li>
                <li>Tambah User</li>
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
                Tambah User Baru
            </h1>
            <a href="{{ route('user.index') }}" class="button light">
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
                    Form Tambah User
                </p>
            </header>
            <div class="card-content">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf

                    <div class="columns is-multiline">
                        <!-- Nama Lengkap -->
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input @error('name') is-danger @enderror" type="text" name="name"
                                        value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
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
                                    <input class="input @error('email') is-danger @enderror" type="email" name="email"
                                        value="{{ old('email') }}" placeholder="contoh: user@example.com" required>
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
                                <label class="label">Password <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input @error('password') is-danger @enderror" type="password"
                                        name="password" placeholder="Masukkan password" required>
                                    <span class="icon left"><i class="mdi mdi-lock"></i></span>
                                </div>
                                @error('password')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="control icons-left">
                                    <input class="input @error('password_confirmation') is-danger @enderror" type="password"
                                        name="password_confirmation" placeholder="Konfirmasi password" required>
                                    <span class="icon left"><i class="mdi mdi-lock-check"></i></span>
                                </div>
                                @error('password_confirmation')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Role <span class="text-danger">*</span></label>
                                <div class="control">
                                    <div class="select is-fullwidth @error('role') is-danger @enderror">
                                        <select name="role" class="input" required>
                                            <option value="">-- Pilih Role --</option>
                                            <option value="Super Admin" {{ old('role') == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="Pelanggan" {{ old('role') == 'Pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                                            <option value="Mitra" {{ old('role') == 'Mitra' ? 'selected' : '' }}>Mitra</option>
                                        </select>
                                    </div>
                                </div>
                                @error('role')
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
                            <a href="{{ route('user.index') }}" class="button light">
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

            /* Styling khusus untuk select agar mirip dengan input */
            .select select.input {
                width: 100%;
                background-color: white;
                border: 1px solid #dbdbdb;
                border-radius: 4px;
                color: #363636;
                height: 2.5em;
                padding-left: 0.75em;
                padding-right: 2.5em;
            }

            .select select.input:focus {
                border-color: #3273dc;
                box-shadow: 0 0 0 0.125em rgba(50, 115, 220, 0.25);
            }

            .select.is-danger select.input {
                border-color: #f14668;
            }

            .select.is-danger select.input:focus {
                box-shadow: 0 0 0 0.125em rgba(241, 70, 104, 0.25);
            }
        </style>
    @endsection
