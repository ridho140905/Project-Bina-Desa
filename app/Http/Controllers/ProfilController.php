<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        // Data statis dalam satu variabel array
        $profil = [
            [
                'id' => 1,
                'judul' => 'Profil Desa Sukamaju',
                'deskripsi' => 'Ini adalah deskripsi singkat tentang desa Sukamaju yang sangat panjang...'
            ],
            [
                'id' => 2,
                'judul' => 'Profil Desa Sejahtera',
                'deskripsi' => 'Desa Sejahtera memiliki visi menjadi desa modern yang mandiri...'
            ],
            [
                'id' => 3,
                'judul' => 'Profil Desa Makmur',
                'deskripsi' => 'Deskripsi singkat desa Makmur untuk contoh saja...'
            ]
        ];

        // kirim ke view
        return view('profil/index', ['profil'=> $profil]);
    }
}
