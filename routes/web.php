<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('profil',[ProfilController::class,'index']);

Route::get('/auth', [AuthController::class, 'index']); // menampilkan form login
Route::post('/auth/login', [AuthController::class, 'login']); // memproses form login

Route::get('/dashboard', function () {
    if (!session()->has('username')) {
        return redirect('/auth')->with('error', 'Silakan login terlebih dahulu.');
    }

    return view('dashboard');
});
