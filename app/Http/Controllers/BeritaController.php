<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Models\Berita;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['dataBerita'] = Berita::with('kategori')->get();
        return view('pages.berita.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['kategoriBerita'] = KategoriBerita::all();
        return view('pages.berita.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_berita,kategori_id',
            'judul' => 'required|string|max:255',
            'slug' => 'required|string|max:300|unique:berita,slug',
            'isi_html' => 'required|string',
            'penulis' => 'required|string|max:100',
            'cover_foto' => 'nullable|string|max:255',
            'status' => 'required|in:draft,terbit',
            'terbit_at' => 'nullable|date',
        ]);

        $data = $request->all();

        // Jika status terbit dan terbit_at kosong, set terbit_at ke waktu sekarang
        if ($request->status == 'terbit' && empty($request->terbit_at)) {
            $data['terbit_at'] = now();
        }

        Berita::create($data);

        return redirect()->route('berita.index')->with('success', 'Penambahan Data Berhasil!');
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
        $data['berita'] = Berita::findOrFail($id);
        $data['kategoriBerita'] = KategoriBerita::all();
        return view('pages.berita.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategori_berita,kategori_id',
            'judul' => 'required|string|max:250',
            'slug' => 'required|string|max:300|unique:berita,slug,' . $id . ',berita_id',
            'isi_html' => 'required|string',
            'penulis' => 'required|string|max:100',
            'cover_foto' => 'nullable|string|max:255',
            'status' => 'required|in:draft,terbit',
            'terbit_at' => 'nullable|date',
        ]);

        $data = $request->all();

        // Jika status berubah dari draft ke terbit dan terbit_at kosong, set terbit_at ke waktu sekarang
        if ($request->status == 'terbit' && $berita->status == 'draft' && empty($request->terbit_at)) {
            $data['terbit_at'] = now();
        }

        $berita->update($data);

        return redirect()->route('berita.index')->with('success','Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Data berhasil dihapus');
    }
}
