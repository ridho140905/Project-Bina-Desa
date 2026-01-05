<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\KategoriBeritaController;




Route::get('/', function () {
    return view('pages.auth.form-login');
});

Route::get('profil',[ProfilController::class,'index']);

Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.showRegister');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::resource('dashboard', DashboardController::class);


Route::resource('profil', ProfilController::class);
Route::resource('berita', BeritaController::class);
Route::resource('user', UserController::class);
Route::resource('warga', WargaController::class);
Route::resource('berita', BeritaController::class);
Route::resource('kategoriberita', KategoriBeritaController::class);
Route::resource('agenda', AgendaController::class);
Route::resource('galeri', GaleriController::class);


// Rute tambahan untuk upload file terpisah profil
Route::post('/profil/{profil}/upload-foto-profil', [ProfilController::class, 'uploadFotoProfil'])
    ->name('profil.upload-foto-profil');

Route::post('/profil/{profil}/upload-files', [ProfilController::class, 'uploadFiles'])
    ->name('profil.upload-files');

Route::delete('/profil/{profil}/file/{file}', [ProfilController::class, 'deleteFile'])
    ->name('profil.delete-file');

// Routes untuk Berita
Route::resource('berita', BeritaController::class);

// Route tambahan untuk menghapus file
Route::delete('berita/{berita}/file/{file}', [BeritaController::class, 'deleteFile'])
    ->name('berita.delete-file');

// Route untuk upload gambar tambahan (jika diperlukan terpisah)
Route::post('berita/{berita}/upload-gambar', [BeritaController::class, 'uploadGambar'])
    ->name('berita.upload-gambar');
Route::post('/berita/{berita}/upload-gambar', [BeritaController::class, 'uploadGambarPendukungFiles'])->name('berita.upload.gambar.pendukung');
    // route agenda
Route::delete('agenda/{agenda}/file/{file}', [AgendaController::class, 'deleteFile'])
    ->name('agenda.delete-file');
Route::post('agenda/{agenda}/upload-images', [AgendaController::class, 'uploadImages'])->name('agenda.upload-images');

// route galeri'
Route::delete('/galeri/{galeri}/files/{file}', [GaleriController::class, 'deleteFile'])->name('galeri.delete-file');
Route::post('/galeri/{galeri}/upload-files', [GaleriController::class, 'uploadFiles'])->name('galeri.upload-files');


Route::group(['middleware' => ['checkislogin','checkrole:Admin']], function () {
    route::get('warga', [WargaController::class, 'index'])->name('warga.index');
    route::get('berita', [BeritaController::class, 'index'])->name('berita.index');
    route::get('profil', [ProfilController::class, 'index'])->name('profil.index');
    route::get('galeri', [GaleriController::class, 'index'])->name('galeri.index');
    route::get('agenda', [AgendaController::class, 'index'])->name('agenda.index');
     route::get('kategoriberita', [KategoriBeritaController::class, 'index'])->name('kategori.index');
});
Route::group(['middleware' => ['checkislogin','checkrole:Super Admin']], function () {
    Route::get('user', [UserController::class, 'index'])->name('user.index');
});
//  Route::group(['middleware' => ['checkislogin']], function () {
//     Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     route::get('user', [UserController::class, 'index'])->name('user.index');
//     route::get('warga', [WargaController::class, 'index'])->name('warga.index');
//     route::get('berita', [BeritaController::class, 'index'])->name('berita.index');
//     route::get('profil', [ProfilController::class, 'index'])->name('profil.index');
//      route::get('galeri', [GaleriController::class, 'index'])->name('galeri.index');
// });

// Identitas Pengembang - menggunakan Controller
Route::get('/developer', [DeveloperController::class, 'index'])->name('developer');
