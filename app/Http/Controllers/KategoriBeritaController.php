<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBerita;

class KategoriBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['dataKategori'] = KategoriBerita::all();
        return view('pages.kategori.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'slug' => 'required|string|max:120|unique:kategori_berita,slug',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->all();
        KategoriBerita::create($data);

        return redirect()->route('kategoriberita.index')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['kategori'] = KategoriBerita::findOrFail($id);
        return view('pages.kategori.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = KategoriBerita::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'slug' => 'required|string|max:120|unique:kategori_berita,slug,' . $id . ',kategori_id',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategoriberita.index')->with('success','Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = KategoriBerita::findOrFail($id);

        // Cek apakah kategori memiliki berita terkait
        if ($kategori->berita()->count() > 0) {
            return redirect()->route('kategoriberita.index')
                ->with('error', 'Tidak dapat menghapus kategori karena masih memiliki berita terkait!');
        }

        $kategori->delete();

        return redirect()->route('kategoriberita.index')->with('success', 'Data berhasil dihapus');
    }
}
