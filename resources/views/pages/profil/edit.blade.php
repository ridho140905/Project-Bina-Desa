@extends('layouts.admin.app')

@section('content')
<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Profil Desa</li>
      <li>Edit Profil Desa</li>
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
  @if (session('success'))
    <div class="notification is-success">
      {{ session('success') }}
    </div>
  @endif

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
        <span class="icon"><i class="mdi mdi-home-edit"></i></span>
        Form Edit Profil Desa
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('profil.update', $dataProfil->profil_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
          <!-- Kolom Kiri - Informasi Dasar & File Pendukung -->
          <div class="col-md-6">
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

            <!-- Visi - di kiri bawah -->
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

            <!-- File Pendukung - di kiri bawah -->
            @php
              $filePendukung = $dataProfil->media->where('sort_order', '>', 1);
            @endphp
            <div class="field">
              <label class="label">File Pendukung Tambahan</label>

              {{-- Tampilkan File Pendukung Saat Ini --}}
              @if($filePendukung->count() > 0)
                <div class="mb-3">
                  <p class="text-sm text-muted mb-2">File Pendukung Saat Ini:</p>
                  <div class="space-y-2">
                    @foreach($filePendukung as $file)
                      <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div>
                          <span class="font-medium block">{{ $file->file_name }}</span>
                          <small class="text-gray-500">{{ $file->mime_type }}</small>
                        </div>
                        <a href="{{ route('profil.delete-file', ['profil' => $dataProfil->profil_id, 'file' => $file->media_id]) }}"
                           class="button is-small is-danger"
                           onclick="return confirm('Yakin ingin menghapus file ini?')">
                          <span class="icon"><i class="mdi mdi-delete"></i></span>
                        </a>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif

              <div class="control">
                <input class="input @error('file_pendukung') is-danger @enderror"
                       type="file"
                       name="file_pendukung[]"
                       multiple
                       accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
              </div>
              <small class="form-text text-muted">
                Upload file tambahan. Format: JPG, JPEG, PNG, GIF, PDF, DOC, DOCX. Maksimal 5 file.
              </small>
              @error('file_pendukung')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan - Informasi Kontak & Foto Profil -->
          <div class="col-md-6">
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

            <!-- Foto Profil - di kanan -->
            @php
              $fotoProfil = $dataProfil->media->where('sort_order', 1)->first();
            @endphp
            <div class="field">
              <label class="label">Foto Profil</label>

              {{-- Preview Foto Saat Ini --}}
              @if($fotoProfil)
                <div class="mb-3">
                  <p class="text-sm text-muted mb-2">Foto Saat Ini:</p>
                  <div class="flex items-start gap-4">
                    <img src="{{ asset('storage/media/profil/' . $fotoProfil->file_name) }}"
                         alt="Foto Profil {{ $dataProfil->nama_desa }}"
                         class="profile-img-preview rounded-lg border">
                    <div class="flex-1">
                      <p class="font-medium mb-1">{{ $fotoProfil->file_name }}</p>
                      <small class="text-gray-500 block mb-2">{{ $fotoProfil->mime_type }}</small>
                      <a href="{{ route('profil.delete-file', ['profil' => $dataProfil->profil_id, 'file' => $fotoProfil->media_id]) }}"
                         class="button is-small is-danger"
                         onclick="return confirm('Yakin ingin menghapus foto profil ini?')">
                        <span class="icon"><i class="mdi mdi-delete"></i></span>
                        <span>Hapus Foto</span>
                      </a>
                    </div>
                  </div>
                </div>
              @else
                <div class="mb-3">
                  <p class="text-sm text-muted">Belum ada foto profil</p>
                </div>
              @endif

              <div class="control">
                <input class="input @error('foto_profil') is-danger @enderror"
                       type="file"
                       name="foto_profil"
                       accept="image/*">
              </div>
              <small class="form-text text-muted">
                Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.
              </small>
              @error('foto_profil')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Misi - di kanan bawah -->
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

          <!-- Alamat Kantor - Full Width -->
          <div class="col-12">
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
                <a href="{{ route('profil.index') }}" class="button light">
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
  .textarea {
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
  .textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  .textarea {
    resize: vertical;
    min-height: 120px;
  }

  /* Icons styling */
  .control.icons-left {
    position: relative;
  }

  .control.icons-left .icon.left {
    position: absolute;
    left: 1rem;
    top: 1rem;
    color: #6b7280;
    z-index: 1;
  }

  .control.icons-left input,
  .control.icons-left textarea {
    padding-left: 3rem;
  }

  /* Helper text */
  .form-text.text-muted {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
    display: block;
  }

  /* Error styling */
  .help.is-danger {
    color: #dc3545;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: block;
  }

  .input.is-danger,
  .textarea.is-danger {
    border-color: #dc3545;
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

  .button.is-danger {
    background-color: #ef4444;
    color: white;
    border: none;
  }

  .button.is-small {
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
  }

  .button.green:hover {
    background-color: #059669;
  }

  .button.light:hover {
    background-color: #e5e7eb;
  }

  .button.is-danger:hover {
    background-color: #dc2626;
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

  /* Image preview styling */
  .profile-img-preview {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
  }

  .text-sm {
    font-size: 0.875rem;
  }

  /* Utility classes */
  .flex {
    display: flex;
  }

  .items-center {
    align-items: center;
  }

  .items-start {
    align-items: flex-start;
  }

  .justify-between {
    justify-content: space-between;
  }

  .gap-4 {
    gap: 1rem;
  }

  .space-y-2 > * + * {
    margin-top: 0.5rem;
  }

  .mb-1 {
    margin-bottom: 0.25rem;
  }

  .mb-2 {
    margin-bottom: 0.5rem;
  }

  .mb-3 {
    margin-bottom: 1rem;
  }

  .p-3 {
    padding: 0.75rem;
  }

  .bg-gray-50 {
    background-color: #f9fafb;
  }

  .rounded {
    border-radius: 0.375rem;
  }

  .rounded-lg {
    border-radius: 0.5rem;
  }

  .border {
    border: 1px solid #e5e7eb;
  }

  .block {
    display: block;
  }

  .font-medium {
    font-weight: 500;
  }

  .text-gray-500 {
    color: #6b7280;
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

    .profile-img-preview {
      width: 100px;
      height: 100px;
    }

    .flex.items-start.gap-4 {
      flex-direction: column;
      gap: 1rem;
    }
  }

  /* Specific styling for file inputs */
  input[type="file"] {
    padding: 0.5rem;
    border: 2px dashed #e2e8f0;
    background-color: #f8fafc;
    cursor: pointer;
    width: 100%;
  }

  input[type="file"]:hover {
    border-color: #3b82f6;
    background-color: #f0f9ff;
  }

  /* Notification styling */
  .notification {
    margin-bottom: 1.5rem;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
  }

  .notification.is-success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
  }

  .notification.is-danger {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
  }
</style>
@endsection
