@extends('layouts.admin.app')

@section('content')
<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Users</li>
      <li>Edit User</li>
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
      Edit User - {{ $dataUser->name }}
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
        <span class="icon"><i class="mdi mdi-account-edit"></i></span>
        Form Edit User
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('user.update', $dataUser->id) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="row">
          <!-- Kolom Kiri -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Nama Lengkap <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('name') is-danger @enderror" type="text"
                  name="name" value="{{ old('name', $dataUser->name) }}"
                  placeholder="Masukkan nama lengkap" required>
                <span class="icon left"><i class="mdi mdi-account"></i></span>
              </div>
              @error('name')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Email <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <input class="input @error('email') is-danger @enderror" type="email"
                  name="email" value="{{ old('email', $dataUser->email) }}"
                  placeholder="contoh: user@example.com" required>
                <span class="icon left"><i class="mdi mdi-email"></i></span>
              </div>
              @error('email')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Role <span class="text-danger">*</span></label>
              <div class="control icons-left">
                <div class="select is-fullwidth @error('role') is-danger @enderror">
                  <select name="role" required class="input">
                    <option value="">Pilih Role</option>
                    <option value="Super Admin" {{ old('role', $dataUser->role) == 'Super Admin' ? 'selected' : '' }}>
                      Super Admin
                    </option>
                    <option value="Pelanggan" {{ old('role', $dataUser->role) == 'Pelanggan' ? 'selected' : '' }}>
                      Pelanggan
                    </option>
                    <option value="Mitra" {{ old('role', $dataUser->role) == 'Mitra' ? 'selected' : '' }}>
                      Mitra
                    </option>
                  </select>
                </div>
                <span class="icon left"><i class="mdi mdi-account-key"></i></span>
              </div>
              @error('role')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Password -->
            <div class="field">
              <label class="label">Password</label>
              <div class="control icons-left">
                <input class="input @error('password') is-danger @enderror"
                  type="password" name="password"
                  placeholder="Kosongkan jika tidak ingin mengubah password">
                <span class="icon left"><i class="mdi mdi-lock"></i></span>
              </div>
              <p class="help is-info">Biarkan kosong jika tidak ingin mengubah password</p>
              @error('password')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="field">
              <label class="label">Konfirmasi Password</label>
              <div class="control icons-left">
                <input class="input @error('password_confirmation') is-danger @enderror"
                  type="password" name="password_confirmation"
                  placeholder="Konfirmasi password">
                <span class="icon left"><i class="mdi mdi-lock-check"></i></span>
              </div>
              @error('password_confirmation')
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

  .help.is-info {
    color: #6b7280;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    font-style: italic;
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
