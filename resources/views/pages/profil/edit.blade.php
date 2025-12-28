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
        <span class="icon"><i class="mdi mdi-home-edit"></i></span>
        Form Edit Profil Desa
      </p>
    </header>
    <div class="card-content">
      <form action="{{ route('profil.update', $dataProfil->profil_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
          <!-- Kolom Kiri - Informasi Dasar -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Nama Desa <span class="text-danger">*</span></label>
              <div class="control has-icons-left">
                <input class="input @error('nama_desa') is-danger @enderror"
                       type="text" name="nama_desa" value="{{ old('nama_desa', $dataProfil->nama_desa) }}"
                       placeholder="Masukkan nama desa" required>
                <span class="icon is-left">
                  <i class="mdi mdi-home"></i>
                </span>
              </div>
              @error('nama_desa')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Kecamatan <span class="text-danger">*</span></label>
              <div class="control has-icons-left">
                <input class="input @error('kecamatan') is-danger @enderror"
                       type="text" name="kecamatan" value="{{ old('kecamatan', $dataProfil->kecamatan) }}"
                       placeholder="Masukkan nama kecamatan" required>
                <span class="icon is-left">
                  <i class="mdi mdi-map-marker"></i>
                </span>
              </div>
              @error('kecamatan')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Kabupaten <span class="text-danger">*</span></label>
              <div class="control has-icons-left">
                <input class="input @error('kabupaten') is-danger @enderror"
                       type="text" name="kabupaten" value="{{ old('kabupaten', $dataProfil->kabupaten) }}"
                       placeholder="Masukkan nama kabupaten" required>
                <span class="icon is-left">
                  <i class="mdi mdi-city"></i>
                </span>
              </div>
              @error('kabupaten')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Provinsi <span class="text-danger">*</span></label>
              <div class="control has-icons-left">
                <input class="input @error('provinsi') is-danger @enderror"
                       type="text" name="provinsi" value="{{ old('provinsi', $dataProfil->provinsi) }}"
                       placeholder="Masukkan nama provinsi" required>
                <span class="icon is-left">
                  <i class="mdi mdi-earth"></i>
                </span>
              </div>
              @error('provinsi')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="field">
              <label class="label">Telepon <span class="text-danger">*</span></label>
              <div class="control has-icons-left">
                <input class="input @error('telepon') is-danger @enderror"
                       type="text" name="telepon" value="{{ old('telepon', $dataProfil->telepon) }}"
                       placeholder="Contoh: 081234567890" required>
                <span class="icon is-left">
                  <i class="mdi mdi-phone"></i>
                </span>
              </div>
              @error('telepon')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Kolom Kanan - Informasi Kontak & Visi/Misi -->
          <div class="col-md-6">
            <div class="field">
              <label class="label">Email <span class="text-danger">*</span></label>
              <div class="control has-icons-left">
                <input class="input @error('email') is-danger @enderror" type="email"
                       name="email" value="{{ old('email', $dataProfil->email) }}"
                       placeholder="contoh: desa@example.com" required>
                <span class="icon is-left">
                  <i class="mdi mdi-email"></i>
                </span>
              </div>
              @error('email')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Upload Foto Profil -->
            @php
              $fotoProfil = $dataProfil->media->where('sort_order', 1)->first();
            @endphp
            <div class="field">
              <label class="label">Foto Profil</label>

              @if($fotoProfil)
                <div class="mb-3">
                  <p class="text-sm text-muted mb-2">Foto Saat Ini:</p>
                  <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('storage/media/profil/' . $fotoProfil->file_name) }}"
                         alt="Foto Profil {{ $dataProfil->nama_desa }}"
                         class="profile-img-preview rounded me-3"
                         onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div class="no-image-preview" style="display: none;">
                      <div class="no-image-placeholder">
                        <i class="mdi mdi-image-off"></i>
                      </div>
                    </div>
                    <div>
                      <p class="text-sm mb-1">{{ $fotoProfil->file_name }}</p>
                      <small class="text-muted d-block">{{ $fotoProfil->mime_type }}</small>
                    </div>
                  </div>
                </div>
              @else
                <div class="mb-3">
                  <p class="text-sm text-muted mb-2">Belum ada foto profil</p>
                  <div class="no-image-placeholder mb-3">
                    <i class="mdi mdi-image-off"></i>
                  </div>
                </div>
              @endif

              <div class="control has-icons-left has-icons-right">
                <input class="input @error('foto_profil') is-danger @enderror"
                       type="file" name="foto_profil" accept="image/*">
                <span class="icon is-left">
                  <i class="mdi mdi-image"></i>
                </span>
                <span class="icon is-right file-icon">
                  <i class="mdi mdi-upload"></i>
                </span>
              </div>
              <small class="form-text text-muted">
                Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.
              </small>
              @error('foto_profil')
                <p class="help is-danger">{{ $message }}</p>
              @enderror
            </div>

            <!-- Visi & Misi Side by Side -->
            <div class="row">
              <div class="col-md-6">
                <div class="field">
                  <label class="label">Visi <span class="text-danger">*</span></label>
                  <div class="control has-icons-left">
                    <textarea class="textarea @error('visi') is-danger @enderror" name="visi" rows="5"
                              placeholder="Tuliskan visi desa" required>{{ old('visi', $dataProfil->visi) }}</textarea>
                    <span class="icon is-left">
                      <i class="mdi mdi-target"></i>
                    </span>
                  </div>
                  @error('visi')
                    <p class="help is-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="field">
                  <label class="label">Misi <span class="text-danger">*</span></label>
                  <div class="control has-icons-left">
                    <textarea class="textarea @error('misi') is-danger @enderror" name="misi" rows="5"
                              placeholder="Tuliskan misi desa" required>{{ old('misi', $dataProfil->misi) }}</textarea>
                    <span class="icon is-left">
                      <i class="mdi mdi-bullseye-arrow"></i>
                    </span>
                  </div>
                  @error('misi')
                    <p class="help is-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <!-- Kolom Bawah Full Width - Alamat Kantor -->
          <div class="col-12">
            <div class="field">
              <label class="label">Alamat Kantor <span class="text-danger">*</span></label>
              <div class="control has-icons-left">
                <textarea class="textarea @error('alamat_kantor') is-danger @enderror" name="alamat_kantor" rows="3"
                          placeholder="Masukkan alamat lengkap kantor desa" required>{{ old('alamat_kantor', $dataProfil->alamat_kantor) }}</textarea>
                <span class="icon is-left">
                  <i class="mdi mdi-office-building"></i>
                </span>
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
                <button type="reset" class="button light">
                  <span class="icon"><i class="mdi mdi-refresh"></i></span>
                  <span>Reset Form</span>
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

  /* Style khusus untuk input file */
  input[type="file"] {
    padding: 0.5rem;
    background-color: #f8f9fa;
    border: 1px dashed #dee2e6;
    cursor: pointer;
  }

  input[type="file"]:focus {
    border-color: #3b82f6;
    border-style: solid;
  }

  /* Textarea styling */
  .textarea {
    min-height: 100px;
    resize: vertical;
  }

  /* Icons styling untuk input */
  .control.has-icons-left {
    position: relative;
  }

  .control.has-icons-left .icon.is-left {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    z-index: 2;
    pointer-events: none;
  }

  /* Icon untuk textarea perlu diatur secara khusus */
  .control.has-icons-left .textarea + .icon.is-left {
    top: 1.25rem;
    transform: none;
    align-items: flex-start;
  }

  /* Icon untuk input file di sebelah kanan */
  .control.has-icons-right .icon.is-right.file-icon {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    z-index: 2;
    pointer-events: none;
  }

  /* Input dengan icon kiri */
  .control.has-icons-left .input,
  .control.has-icons-left .textarea {
    padding-left: 2.75rem;
  }

  /* Input file dengan icon kanan */
  .control.has-icons-right .input[type="file"] {
    padding-right: 2.75rem;
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

  .help {
    color: #6b7280;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: block;
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

  .button {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 0.875rem;
    text-decoration: none;
    border: 1px solid transparent;
  }

  .button.green {
    background-color: #10b981;
    color: white;
    border: none;
  }

  .button.light {
    background-color: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
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

  .notification.is-success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
  }

  .notification.is-success i {
    margin-right: 0.5rem;
  }

  /* Image preview styling */
  .profile-img-preview {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    display: block;
  }

  .text-sm {
    font-size: 14px;
  }

  .no-image-placeholder {
    width: 150px;
    height: 150px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 48px;
  }

  /* Bootstrap-like utility classes */
  .d-flex {
    display: flex !important;
  }

  .align-items-center {
    align-items: center !important;
  }

  .me-3 {
    margin-right: 1rem !important;
  }

  .mb-1 {
    margin-bottom: 0.25rem !important;
  }

  .mb-2 {
    margin-bottom: 0.5rem !important;
  }

  .mb-3 {
    margin-bottom: 1rem !important;
  }

  .bg-light {
    background-color: #f8f9fa !important;
  }

  .rounded {
    border-radius: 0.375rem !important;
  }

  .d-block {
    display: block !important;
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
      width: 120px;
      height: 120px;
    }

    .d-flex.align-items-center.mb-3 {
      flex-direction: column;
      align-items: flex-start;
    }

    .d-flex.align-items-center.mb-3 img,
    .d-flex.align-items-center.mb-3 .no-image-preview {
      margin-bottom: 0.5rem;
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validasi ukuran file foto profil
    const fotoProfilInput = document.querySelector('input[name="foto_profil"]');

    if (fotoProfilInput) {
        fotoProfilInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB

                if (file.size > maxSize) {
                    alert('Ukuran file maksimal 2MB');
                    this.value = '';
                }

                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file harus JPG, JPEG, PNG, atau GIF');
                    this.value = '';
                }
            }
        });
    }
});
</script>
@endsection
