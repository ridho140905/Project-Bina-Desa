@extends('layouts.admin.app')

@php
use Illuminate\Support\Str;
@endphp

<!-- ========== START MAIN CONTENT ========== -->
@section('content')
<!-- Flash Messages - POSISI BARU DI ATAS TENGAH -->
<div class="flash-overlay" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 9999; pointer-events: none; display: flex; justify-content: center; align-items: flex-start; padding-top: 100px;">
    @if(session('success'))
    <div class="success-message" style="background: linear-gradient(135deg, #48bb78, #38a169); color: white; padding: 20px 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); min-width: 400px; text-align: center; pointer-events: auto; animation: slideDown 0.5s ease-out;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 18px; font-weight: 600;">
            <span style="font-size: 24px;">✅</span>
            <span>{{ session('success') }}</span>
        </div>
        <div style="margin-top: 8px; font-size: 14px; opacity: 0.9;">
            Halo selamat datang ke website bina desa
        </div>
    </div>

    <script>
        setTimeout(function() {
            const flash = document.querySelector('.success-message');
            if (flash) {
                flash.style.animation = 'fadeOut 0.5s ease-in forwards';
                setTimeout(() => flash.remove(), 500);
            }
        }, 4000);
    </script>
    @endif

    @if(session('error'))
    <div class="error-message" style="background: linear-gradient(135deg, #f56565, #e53e3e); color: white; padding: 20px 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); min-width: 400px; text-align: center; pointer-events: auto; animation: slideDown 0.5s ease-out;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 18px; font-weight: 600;">
            <span style="font-size: 24px;">❌</span>
            <span>{{ session('error') }}</span>
        </div>
    </div>

    <script>
        setTimeout(function() {
            const flash = document.querySelector('.error-message');
            if (flash) {
                flash.style.animation = 'fadeOut 0.5s ease-in forwards';
                setTimeout(() => flash.remove(), 500);
            }
        }, 4000);
    </script>
    @endif
</div>

<style>
/* Responsive Base Styles */
* {
    box-sizing: border-box;
}

/* Flash Messages Responsive */
@media (max-width: 640px) {
    .flash-overlay {
        padding-top: 80px;
        padding-left: 16px;
        padding-right: 16px;
    }

    .success-message, .error-message {
        min-width: auto !important;
        width: 100%;
        max-width: 100%;
        padding: 16px 20px !important;
    }

    .success-message > div, .error-message > div {
        font-size: 16px !important;
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-50px);
    }
}

/* Slideshow Responsive Styles */
.slideshow-container {
    position: relative;
    max-width: 100%;
    margin: auto;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.slides {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.slide {
    min-width: 100%;
    transition: opacity 0.5s ease;
    position: relative;
    flex-shrink: 0;
}

.slide img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 8px;
}

.slide-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    color: white;
    padding: 20px;
    border-radius: 0 0 8px 8px;
}

.slide-content h3 {
    margin: 0 0 5px 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.slide-content p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

/* Slideshow Responsive */
@media (max-width: 768px) {
    .slide img {
        height: 300px;
    }

    .slide-content {
        padding: 15px;
    }

    .slide-content h3 {
        font-size: 1.2rem;
        margin-bottom: 3px;
    }

    .slide-content p {
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .slide img {
        height: 250px;
    }

    .slide-content {
        padding: 12px;
    }

    .slide-content h3 {
        font-size: 1rem;
    }

    .slide-content p {
        font-size: 0.75rem;
    }
}

/* Navigation buttons responsive */
.slideshow-prev, .slideshow-next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: 50px;
    height: 50px;
    transform: translateY(-50%);
    color: white;
    font-weight: bold;
    font-size: 24px;
    transition: 0.3s;
    border-radius: 50%;
    user-select: none;
    background-color: rgba(0,0,0,0.5);
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
}

.slideshow-next {
    right: 20px;
}

.slideshow-prev {
    left: 20px;
}

.slideshow-prev:hover, .slideshow-next:hover {
    background-color: rgba(0,0,0,0.8);
    transform: translateY(-50%) scale(1.1);
}

@media (max-width: 768px) {
    .slideshow-prev, .slideshow-next {
        width: 40px;
        height: 40px;
        font-size: 20px;
    }

    .slideshow-next {
        right: 15px;
    }

    .slideshow-prev {
        left: 15px;
    }
}

@media (max-width: 480px) {
    .slideshow-prev, .slideshow-next {
        width: 36px;
        height: 36px;
        font-size: 18px;
    }

    .slideshow-next {
        right: 10px;
    }

    .slideshow-prev {
        left: 10px;
    }
}

/* Header buttons responsive */
@media (max-width: 768px) {
    .card-header .flex.items-center {
        flex-wrap: nowrap;
    }

    .card-header .button.small {
        padding: 6px 8px;
    }

    .card-header .button.small .icon {
        margin-right: 0;
    }

    .card-header .button.small span:not(.icon) {
        display: none;
    }
}

/* Dots indicators responsive */
.dots-container {
    text-align: center;
    padding: 15px;
    position: absolute;
    bottom: 10px;
    width: 100%;
    z-index: 10;
}

.dot {
    cursor: pointer;
    height: 12px;
    width: 12px;
    margin: 0 4px;
    background-color: rgba(255,255,255,0.5);
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.3s ease;
}

.dot.active, .dot:hover {
    background-color: white;
}

@media (max-width: 480px) {
    .dots-container {
        padding: 10px;
    }

    .dot {
        height: 10px;
        width: 10px;
        margin: 0 3px;
    }
}

/* Stats Widgets Responsive */
@media (max-width: 768px) {
    .widget-icon {
        font-size: 36px !important;
    }

    .widget-label h1 {
        font-size: 1.8rem;
    }

    .widget-label h3 {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .grid.grid-cols-1.md\:grid-cols-3 {
        gap: 12px;
    }

    .widget-icon {
        font-size: 32px !important;
    }

    .widget-label h1 {
        font-size: 1.6rem;
    }

    .widget-label h3 {
        font-size: 0.8rem;
    }
}

/* Notification Responsive */
.notification.blue {
    margin-bottom: 16px;
}

@media (max-width: 768px) {
    .notification.blue .flex {
        align-items: flex-start;
    }

    .notification.blue .button.small.textual {
        padding: 4px 8px;
        font-size: 12px;
        margin-top: 8px;
    }
}

/* Tables Responsive */
.card.has-table {
    overflow: hidden;
}

.card.has-table .card-content {
    padding: 0;
    overflow-x: auto;
}

.card.has-table table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

.card.has-table th {
    background-color: #f9fafb;
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
    white-space: nowrap;
}

.card.has-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: middle;
}

.card.has-table tr:last-child td {
    border-bottom: none;
}


/* Hover effect untuk tabel */
tr:hover {
    background-color: #f3f4f6 !important;
    transition: background-color 0.2s ease;
}

/* Responsive table adjustments */
@media (max-width: 1024px) {
    .card.has-table table {
        min-width: 700px;
    }
}

@media (max-width: 768px) {
    .card.has-table table {
        min-width: 600px;
    }

    .card.has-table th,
    .card.has-table td {
        padding: 10px 12px;
        font-size: 14px;
    }

    .card.has-table td .text-xs {
        font-size: 12px;
    }
}

@media (max-width: 640px) {
    .card.has-table table {
        min-width: 500px;
    }

    .card.has-table th,
    .card.has-table td {
        padding: 8px 10px;
        font-size: 13px;
    }

    .card.has-table td .font-medium {
        font-size: 14px;
    }

    .card.has-table td .text-xs {
        font-size: 11px;
    }
}

/* Mobile-first table (optional for better mobile experience) */
@media (max-width: 480px) {
    .card.has-table .card-content {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .card-header-title {
        font-size: 1rem;
    }

    .card-header-title .icon {
        margin-right: 6px;
    }
}

/* Pagination responsive */
.table-pagination {
    padding: 16px;
    border-top: 1px solid #e5e7eb;
    background-color: #f9fafb;
}

.buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.button.active {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

@media (max-width: 768px) {
    .table-pagination {
        padding: 12px;
    }

    .table-pagination .flex {
        flex-direction: column;
        gap: 12px;
        align-items: flex-start;
    }

    .buttons {
        align-self: stretch;
        justify-content: center;
    }

    .table-pagination small {
        font-size: 12px;
        text-align: center;
        width: 100%;
    }
}

/* General Section Responsive */
.section.main-section {
    padding: 1.5rem;
}

@media (max-width: 768px) {
    .section.main-section {
        padding: 1rem;
    }

    .is-title-bar,
    .is-hero-bar {
        padding: 1rem;
    }

    .is-title-bar .text-sm {
        font-size: 0.875rem;
    }

    .is-hero-bar .title {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .section.main-section {
        padding: 0.75rem;
    }

    .is-title-bar,
    .is-hero-bar {
        padding: 0.75rem;
    }

    .is-title-bar .text-sm {
        font-size: 0.75rem;
    }

    .is-hero-bar .title {
        font-size: 1.25rem;
    }

    .button.light {
        padding: 8px 12px;
        font-size: 14px;
    }
}



/* Truncate text for mobile */
.truncate-mobile {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 200px;
}

@media (max-width: 768px) {
    .truncate-mobile {
        max-width: 150px;
    }
}

@media (max-width: 480px) {
    .truncate-mobile {
        max-width: 120px;
    }
}
</style>

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
    <ul>
      <li class="text-lg md:text-xl">Portal Desa</li>
    </ul>
    <div class="text-xs md:text-sm text-gray-600 text-center md:text-right">
      {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </div>
  </div>
</section>

<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
    <h1 class="title text-2xl md:text-3xl">
      Dashboard
    </h1>
    <button class="button light text-sm md:text-base" onclick="location.reload()">
      <span class="icon"><i class="mdi mdi-refresh"></i></span>
      <span>Refresh</span>
    </button>
  </div>
</section>

<section class="section main-section">
    {{-- Slideshow Section --}}
    <div class="card mb-4 md:mb-6">
      <header class="card-header">
        <p class="card-header-title text-base md:text-lg">
          <span class="icon"><i class="mdi mdi-image-multiple"></i></span>
          Galeri Desa
        </p>
        <div class="flex items-center">
          <button class="button small mr-2" onclick="prevSlide()">
            <span class="icon"><i class="mdi mdi-chevron-left"></i></span>
            <span class="hidden md:inline">Sebelumnya</span>
          </button>
          <button class="button small" onclick="nextSlide()">
            <span class="icon"><i class="mdi mdi-chevron-right"></i></span>
            <span class="hidden md:inline">Selanjutnya</span>
          </button>
        </div>
      </header>
      <div class="card-content p-2 md:p-4">
        <div class="slideshow-container">
          <div class="slides" id="slides">
            @foreach($slideshowImages as $index => $image)
            <div class="slide">
              <img src="{{ $image['url'] }}" alt="{{ $image['title'] }}"
                   onerror="this.src='https://images.unsplash.com/photo-1579033014042-5c7b42c525a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'">
              <div class="slide-content">
                <h3>{{ $image['title'] }}</h3>
                <p>{{ $image['description'] }}</p>
              </div>
            </div>
            @endforeach
          </div>
          <!-- Navigation buttons inside slideshow -->
          <button class="slideshow-prev" onclick="prevSlide()">❮</button>
          <button class="slideshow-next" onclick="nextSlide()">❯</button>
          <div class="dots-container">
            @foreach($slideshowImages as $index => $image)
            <span class="dot {{ $index == 0 ? 'active' : '' }}" onclick="currentSlide({{ $index + 1 }})"></span>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    {{-- Stats Widgets --}}
    <div class="grid gap-4 md:gap-6 grid-cols-1 md:grid-cols-3 mb-4 md:mb-6">
      <div class="card">
        <div class="card-content p-4 md:p-6">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3 class="text-sm md:text-base font-medium text-gray-600">
                Total Desa
              </h3>
              <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                {{ $totalProfil }}
              </h1>
            </div>
            <span class="icon widget-icon text-green-500"><i class="mdi mdi-home-city mdi-36px md:mdi-48px"></i></span>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-content p-4 md:p-6">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3 class="text-sm md:text-base font-medium text-gray-600">
                Agenda Aktif
              </h3>
              <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                {{ $totalAgenda }}
              </h1>
            </div>
            <span class="icon widget-icon text-blue-500"><i class="mdi mdi-calendar-check mdi-36px md:mdi-48px"></i></span>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-content p-4 md:p-6">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3 class="text-sm md:text-base font-medium text-gray-600">
                Total Berita
              </h3>
              <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                {{ $totalBerita }}
              </h1>
            </div>
            <span class="icon widget-icon text-red-500"><i class="mdi mdi-newspaper mdi-36px md:mdi-48px"></i></span>
          </div>
        </div>
      </div>
    </div>

    {{-- Profil Desa --}}
    <div class="notification blue mb-2 md:mb-3">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-2 md:space-y-0">
        <div>
          <span class="icon"><i class="mdi mdi-home"></i></span>
          <b class="text-sm md:text-base">Data Profil Desa Terbaru</b>
        </div>
        <a href="{{ route('profil.index') }}" class="button small textual text-xs md:text-sm">
          Lihat Semua
        </a>
      </div>
    </div>

    {{-- Profil Table dengan warna-warni --}}
    <div class="card has-table mb-4 md:mb-6">
      <header class="card-header">
        <p class="card-header-title text-base md:text-lg">
          <span class="icon"><i class="mdi mdi-home"></i></span>
          Profil Desa
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <div class="overflow-x-auto">
          <table>
            <thead>
            <tr>
              <th class="text-center text-sm md:text-base">#</th>
              <th class="text-sm md:text-base">Nama Desa</th>
              <th class="text-sm md:text-base">Kecamatan</th>
              <th class="text-sm md:text-base">Kabupaten</th>
              <th class="text-sm md:text-base">Provinsi</th>
              <th class="text-sm md:text-base">Email</th>
              <th class="text-sm md:text-base">Telepon</th>
            </tr>
            </thead>
            <tbody>
            @forelse($profilTerbaru as $index => $item)
            <tr class="table-row-{{ ($index % 10) + 1 }}">
              <td class="text-center text-sm md:text-base">{{ $loop->iteration }}</td>
              <td data-label="Nama Desa">
                <div class="font-medium text-sm md:text-base">{{ $item->nama_desa ?? 'N/A' }}</div>
                <div class="text-xs md:text-sm text-gray-500">ID: {{ $item->profil_id ?? 'N/A' }}</div>
              </td>
              <td data-label="Kecamatan" class="text-sm md:text-base truncate-mobile">{{ $item->kecamatan ?? 'N/A' }}</td>
              <td data-label="Kabupaten" class="text-sm md:text-base truncate-mobile">{{ $item->kabupaten ?? 'N/A' }}</td>
              <td data-label="Provinsi" class="text-sm md:text-base truncate-mobile">{{ $item->provinsi ?? 'N/A' }}</td>
              <td data-label="Email" class="text-sm md:text-base">
                <div class="text-blue-600 truncate-mobile">{{ $item->email ?? '-' }}</div>
              </td>
              <td data-label="Telepon" class="text-sm md:text-base">
                <div class="truncate-mobile">{{ $item->telepon ?? '-' }}</div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-4 md:py-8">
                <div class="flex flex-col items-center justify-center">
                  <i class="mdi mdi-database-off text-gray-400 text-3xl md:text-4xl mb-2 md:mb-4"></i>
                  <p class="text-gray-500 text-sm md:text-base">Belum ada data profil</p>
                </div>
              </td>
            </tr>
            @endforelse
            </tbody>
          </table>
        </div>
        @if(count($profilTerbaru) > 0)
        <div class="table-pagination">
          <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
            <div class="buttons">
              <button type="button" class="button active text-sm md:text-base">1</button>
              <button type="button" class="button text-sm md:text-base">2</button>
              <button type="button" class="button text-sm md:text-base">3</button>
            </div>
            <small class="text-xs md:text-sm">Menampilkan {{ count($profilTerbaru) }} dari {{ $totalProfil }} desa</small>
          </div>
        </div>
        @endif
      </div>
    </div>

    {{-- Agenda Kegiatan --}}
    <div class="notification blue mb-2 md:mb-3">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-2 md:space-y-0">
        <div>
          <span class="icon"><i class="mdi mdi-calendar"></i></span>
          <b class="text-sm md:text-base">Agenda Kegiatan Terbaru</b>
        </div>
        <a href="{{ route('agenda.index') }}" class="button small textual text-xs md:text-sm">
          Lihat Semua
        </a>
      </div>
    </div>

    {{-- Agenda Table dengan warna-warni --}}
    <div class="card has-table mb-4 md:mb-6">
      <header class="card-header">
        <p class="card-header-title text-base md:text-lg">
          <span class="icon"><i class="mdi mdi-calendar"></i></span>
          Agenda Kegiatan
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <div class="overflow-x-auto">
          <table>
            <thead>
            <tr>
              <th class="text-center text-sm md:text-base">#</th>
              <th class="text-sm md:text-base">Judul Agenda</th>
              <th class="text-sm md:text-base">Tanggal</th>
              <th class="text-sm md:text-base">Lokasi</th>
              <th class="text-sm md:text-base">Penyelenggara</th>
              <th class="text-sm md:text-base">Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse($agendaTerbaru as $index => $item)
            <tr class="table-row-{{ ($index % 10) + 1 }}">
              <td class="text-center text-sm md:text-base">{{ $loop->iteration }}</td>
              <td data-label="Judul Agenda">
                <div class="font-medium text-sm md:text-base">{{ $item->judul ?? 'N/A' }}</div>
                <div class="text-xs md:text-sm text-gray-500 truncate max-w-xs">{{ $item->deskripsi ?? 'Tidak ada deskripsi' }}</div>
              </td>
              <td data-label="Tanggal" class="text-sm md:text-base">
                <div class="flex flex-col">
                  <div class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }}</div>
                  <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('H:i') }}</div>
                </div>
              </td>
              <td data-label="Lokasi" class="text-sm md:text-base truncate-mobile">{{ $item->lokasi ?? 'N/A' }}</td>
              <td data-label="Penyelenggara" class="text-sm md:text-base truncate-mobile">{{ $item->penyelenggara ?? 'N/A' }}</td>
              <td data-label="Status" class="text-sm md:text-base">
                @php
                  $now = now();
                  $start = \Carbon\Carbon::parse($item->tanggal_mulai);
                  $end = \Carbon\Carbon::parse($item->tanggal_selesai);

                  if ($now->lt($start)) {
                    $status = 'Akan Datang';
                  } elseif ($now->between($start, $end)) {
                    $status = 'Berlangsung';
                  } else {
                    $status = 'Selesai';
                  }
                @endphp
                {{ $status }}
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4 md:py-8">
                <div class="flex flex-col items-center justify-center">
                  <i class="mdi mdi-calendar-blank text-gray-400 text-3xl md:text-4xl mb-2 md:mb-4"></i>
                  <p class="text-gray-500 text-sm md:text-base">Belum ada agenda kegiatan</p>
                </div>
              </td>
            </tr>
            @endforelse
            </tbody>
          </table>
        </div>
        @if(count($agendaTerbaru) > 0)
        <div class="table-pagination">
          <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
            <div class="buttons">
              <button type="button" class="button active text-sm md:text-base">1</button>
              <button type="button" class="button text-sm md:text-base">2</button>
              <button type="button" class="button text-sm md:text-base">3</button>
            </div>
            <small class="text-xs md:text-sm">Menampilkan {{ count($agendaTerbaru) }} dari {{ $totalAgenda }} agenda</small>
          </div>
        </div>
        @endif
      </div>
    </div>

    {{-- Berita Terbaru --}}
    <div class="notification blue mb-2 md:mb-3">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-2 md:space-y-0">
        <div>
          <span class="icon"><i class="mdi mdi-newspaper"></i></span>
          <b class="text-sm md:text-base">Berita Terbaru</b>
        </div>
        <a href="{{ route('berita.index') }}" class="button small textual text-xs md:text-sm">
          Lihat Semua
        </a>
      </div>
    </div>

    {{-- Berita Table --}}
    <div class="card has-table mb-4 md:mb-6">
      <header class="card-header">
        <p class="card-header-title text-base md:text-lg">
          <span class="icon"><i class="mdi mdi-newspaper"></i></span>
          Berita
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <div class="overflow-x-auto">
          <table>
            <thead>
            <tr>
              <th class="text-center text-sm md:text-base">#</th>
              <th class="text-sm md:text-base">Judul Berita</th>
              <th class="text-sm md:text-base">Kategori</th>
              <th class="text-sm md:text-base">Penulis</th>
              <th class="text-sm md:text-base">Status</th>
              <th class="text-sm md:text-base">Tanggal Terbit</th>
            </tr>
            </thead>
            <tbody>
            @forelse($beritaTerbaru as $index => $item)
            <tr class="table-row-{{ ($index % 10) + 1 }}">
              <td class="text-center text-sm md:text-base">{{ $loop->iteration }}</td>
              <td data-label="Judul Berita">
                <div class="font-medium text-sm md:text-base">{{ $item->judul ?? 'N/A' }}</div>
                <div class="text-xs md:text-sm text-gray-500 truncate max-w-xs">{{ Str::limit(strip_tags($item->isi_html), 100) ?? 'Tidak ada konten' }}</div>
              </td>
              <td data-label="Kategori" class="text-sm md:text-base truncate-mobile">{{ $item->kategori->nama ?? 'Tanpa Kategori' }}</td>
              <td data-label="Penulis" class="text-sm md:text-base truncate-mobile">{{ $item->penulis ?? 'N/A' }}</td>
              <td data-label="Status" class="text-sm md:text-base">
                @if($item->status == 'published')
                Terbit
                @elseif($item->status == 'draft')
                Draft
                @else
                {{ $item->status ?? 'N/A' }}
                @endif
              </td>
              <td data-label="Tanggal Terbit" class="text-sm md:text-base">
                <div class="flex flex-col">
                  <div class="font-medium">{{ \Carbon\Carbon::parse($item->terbit_at ?? $item->created_at)->format('d M Y') }}</div>
                  <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->terbit_at ?? $item->created_at)->format('H:i') }}</div>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4 md:py-8">
                <div class="flex flex-col items-center justify-center">
                  <i class="mdi mdi-newspaper-variant-outline text-gray-400 text-3xl md:text-4xl mb-2 md:mb-4"></i>
                  <p class="text-gray-500 text-sm md:text-base">Belum ada berita</p>
                </div>
              </td>
            </tr>
            @endforelse
            </tbody>
          </table>
        </div>
        @if(count($beritaTerbaru) > 0)
        <div class="table-pagination">
          <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
            <div class="buttons">
              <button type="button" class="button active text-sm md:text-base">1</button>
              <button type="button" class="button text-sm md:text-base">2</button>
              <button type="button" class="button text-sm md:text-base">3</button>
            </div>
            <small class="text-xs md:text-sm">Menampilkan {{ count($beritaTerbaru) }} dari {{ $totalBerita }} berita</small>
          </div>
        </div>
        @endif
      </div>
    </div>

    {{-- Kategori Berita --}}
    <div class="notification blue mb-2 md:mb-3">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-2 md:space-y-0">
        <div>
          <span class="icon"><i class="mdi mdi-tag-multiple"></i></span>
          <b class="text-sm md:text-base">Kategori Berita</b>
        </div>
        <a href="{{ route('kategori.index') }}" class="button small textual text-xs md:text-sm">
          Lihat Semua
        </a>
      </div>
    </div>

    {{-- Kategori Berita Table --}}
    <div class="card has-table">
      <header class="card-header">
        <p class="card-header-title text-base md:text-lg">
          <span class="icon"><i class="mdi mdi-tag-multiple"></i></span>
          Kategori Berita
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <div class="overflow-x-auto">
          <table>
            <thead>
            <tr>
              <th class="text-center text-sm md:text-base">#</th>
              <th class="text-sm md:text-base">Nama Kategori</th>
              <th class="text-sm md:text-base">Deskripsi</th>
              <th class="text-sm md:text-base">Jumlah Berita</th>
              <th class="text-sm md:text-base">Tanggal Dibuat</th>
            </tr>
            </thead>
            <tbody>
            @forelse($kategoriBeritaTerbaru as $index => $item)
            <tr class="table-row-{{ ($index % 10) + 1 }}">
              <td class="text-center text-sm md:text-base">{{ $loop->iteration }}</td>
              <td data-label="Nama Kategori">
                <div class="font-medium text-sm md:text-base">{{ $item->nama ?? 'N/A' }}</div>
                <div class="text-xs md:text-sm text-gray-500">Slug: {{ $item->slug ?? '-' }}</div>
              </td>
              <td data-label="Deskripsi" class="text-sm md:text-base truncate-mobile">{{ $item->deskripsi ?? 'Tidak ada deskripsi' }}</td>
              <td data-label="Jumlah Berita" class="text-sm md:text-base">{{ $item->berita_count ?? 0 }} berita</td>
              <td data-label="Tanggal Dibuat" class="text-sm md:text-base">
                <div class="flex flex-col">
                  <div class="font-medium">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</div>
                  <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}</div>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-4 md:py-8">
                <div class="flex flex-col items-center justify-center">
                  <i class="mdi mdi-tag-off text-gray-400 text-3xl md:text-4xl mb-2 md:mb-4"></i>
                  <p class="text-gray-500 text-sm md:text-base">Belum ada kategori berita</p>
                </div>
              </td>
            </tr>
            @endforelse
            </tbody>
          </table>
        </div>
        @if(count($kategoriBeritaTerbaru) > 0)
        <div class="table-pagination">
          <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
            <div class="buttons">
              <button type="button" class="button active text-sm md:text-base">1</button>
              <button type="button" class="button text-sm md:text-base">2</button>
              <button type="button" class="button text-sm md:text-base">3</button>
            </div>
            <small class="text-xs md:text-sm">Menampilkan {{ count($kategoriBeritaTerbaru) }} dari {{ $totalKategoriBerita }} kategori</small>
          </div>
        </div>
        @endif
      </div>
    </div>
  </section>

<script>
// Slideshow functionality
let slideIndex = 1;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
const slidesContainer = document.getElementById('slides');

function showSlides(n) {
  if (n > slides.length) { slideIndex = 1 }
  if (n < 1) { slideIndex = slides.length }

  slidesContainer.style.transform = `translateX(-${(slideIndex - 1) * 100}%)`;

  dots.forEach(dot => dot.classList.remove('active'));
  if (dots[slideIndex - 1]) {
    dots[slideIndex - 1].classList.add('active');
  }
}

function nextSlide() {
  showSlides(slideIndex += 1);
}

function prevSlide() {
  showSlides(slideIndex -= 1);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

// Auto slideshow
let slideInterval = setInterval(() => {
  nextSlide();
}, 5000);

// Pause on hover
const slideshow = document.querySelector('.slideshow-container');
slideshow.addEventListener('mouseenter', () => clearInterval(slideInterval));
slideshow.addEventListener('mouseleave', () => {
  slideInterval = setInterval(() => { nextSlide(); }, 5000);
});

// Initialize
showSlides(slideIndex);

// Touch/swipe support for slideshow
let startX = 0;
let endX = 0;

slideshow.addEventListener('touchstart', (e) => {
  startX = e.touches[0].clientX;
});

slideshow.addEventListener('touchend', (e) => {
  endX = e.changedTouches[0].clientX;
  handleSwipe();
});

function handleSwipe() {
  const threshold = 50; // Minimum swipe distance

  if (startX - endX > threshold) {
    // Swipe left - next slide
    nextSlide();
  } else if (endX - startX > threshold) {
    // Swipe right - previous slide
    prevSlide();
  }
}

// Keyboard navigation
document.addEventListener('keydown', (e) => {
  if (e.key === 'ArrowLeft') {
    prevSlide();
  } else if (e.key === 'ArrowRight') {
    nextSlide();
  }
});

// Responsive table handling
function handleTableResponsive() {
  const tables = document.querySelectorAll('.card.has-table table');
  const screenWidth = window.innerWidth;

  tables.forEach(table => {
    if (screenWidth < 768) {
      // Add horizontal scroll for mobile
      if (!table.parentElement.classList.contains('overflow-x-auto')) {
        table.parentElement.classList.add('overflow-x-auto');
      }
    } else {
      // Remove horizontal scroll for desktop
      table.parentElement.classList.remove('overflow-x-auto');
    }
  });
}

// Initialize on load
window.addEventListener('DOMContentLoaded', handleTableResponsive);

// Update on resize
window.addEventListener('resize', handleTableResponsive);
</script>
@endsection
<!-- ========== END MAIN CONTENT ========== -->
