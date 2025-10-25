<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('profil',[ProfilController::class,'index']);

Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.showRegister');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('profil', ProfilController::class);
Route::resource('berita', BeritaController::class);
Route::resource('user', UserController::class);
Route::resource('warga', WargaController::class);

