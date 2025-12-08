<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Models\Berita;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Daftar kolom yang bisa difilter sesuai name pada form
        $filterableColumns = ['status']; // Filter berdasarkan status
        $searchableColumns = ['judul', 'penulis']; // Search berdasarkan judul dan penulis

        // Gunakan query() untuk memastikan chain method bekerja dengan benar
        $data['dataBerita'] = Berita::query()
            ->with(['kategori', 'media'])
            ->filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

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
            'cover_foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'gambar_pendukung' => 'nullable|array',
            'gambar_pendukung.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'status' => 'required|in:draft,terbit',
            'terbit_at' => 'nullable|date',
        ]);

        $data = $request->except(['cover_foto', 'gambar_pendukung']);

        // Jika status terbit dan terbit_at kosong, set terbit_at ke waktu sekarang
        if ($request->status == 'terbit' && empty($request->terbit_at)) {
            $data['terbit_at'] = now();
        }

        $berita = Berita::create($data);

        // Upload cover foto jika ada
        if ($request->hasFile('cover_foto') && $request->file('cover_foto')->isValid()) {
            $this->uploadCoverFoto($request->file('cover_foto'), $berita->berita_id);
        }

        // Upload gambar pendukung jika ada
        if ($request->hasFile('gambar_pendukung')) {
            $this->uploadGambarPendukung($request->file('gambar_pendukung'), $berita->berita_id);
        }

        return redirect()->route('berita.index')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['berita'] = Berita::with(['kategori', 'media'])->findOrFail($id);
        return view('pages.berita.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['berita'] = Berita::with(['kategori', 'media'])->findOrFail($id);
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
            'cover_foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'gambar_pendukung' => 'nullable|array',
            'gambar_pendukung.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'status' => 'required|in:draft,terbit',
            'terbit_at' => 'nullable|date',
        ]);

        $data = $request->except(['cover_foto', 'gambar_pendukung']);

        // Jika status berubah dari draft ke terbit dan terbit_at kosong, set terbit_at ke waktu sekarang
        if ($request->status == 'terbit' && $berita->status == 'draft' && empty($request->terbit_at)) {
            $data['terbit_at'] = now();
        }

        $berita->update($data);

        // Upload cover foto baru jika ada
        if ($request->hasFile('cover_foto') && $request->file('cover_foto')->isValid()) {
            // Hapus cover foto lama jika ada
            $this->deleteCoverFoto($berita->berita_id);
            // Upload cover foto baru
            $this->uploadCoverFoto($request->file('cover_foto'), $berita->berita_id);
        }

        // Upload gambar pendukung baru jika ada
        if ($request->hasFile('gambar_pendukung')) {
            $this->uploadGambarPendukung($request->file('gambar_pendukung'), $berita->berita_id);
        }

        return redirect()->route('berita.index')->with('success','Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus semua file terkait berita ini
        $this->deleteAllFiles($berita->berita_id);

        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Upload cover foto
     */
    private function uploadCoverFoto($file, $beritaId)
    {
        // Generate unique filename
        $filename = 'cover-berita-' . $beritaId . '-' . time() . '.' . $file->getClientOriginalExtension();

        // PERUBAHAN: Store file - simpan di folder 'media/berita' (FOLDER BARU)
        $file->storeAs('media/berita', $filename, 'public');

        // Simpan ke tabel media dengan struktur yang baru
        Media::create([
            'ref_table'     => 'berita',
            'ref_id'        => $beritaId,
            'file_name'     => $filename,
            'mime_type'     => $file->getMimeType(),
            'caption'       => 'Cover Berita',
            'sort_order'    => 1,
        ]);
    }

    /**
     * Upload gambar pendukung
     */
    private function uploadGambarPendukung($files, $beritaId)
    {
        $sortOrder = 2;

        foreach ($files as $file) {
            if ($file->isValid()) {
                // Generate unique filename
                $filename = 'gambar-pendukung-' . $beritaId . '-' . time() . '-' . $sortOrder . '.' . $file->getClientOriginalExtension();

                // PERUBAHAN: Store file - simpan di folder 'media/berita/gallery' (FOLDER BARU)
                $file->storeAs('media/berita/gallery', $filename, 'public');

                // Simpan ke tabel media dengan struktur yang baru
                Media::create([
                    'ref_table'     => 'berita',
                    'ref_id'        => $beritaId,
                    'file_name'     => $filename,
                    'mime_type'     => $file->getMimeType(),
                    'caption'       => 'Gambar Pendukung Berita',
                    'sort_order'    => $sortOrder,
                ]);

                $sortOrder++;
            }
        }
    }

    /**
     * Delete cover foto
     */
    private function deleteCoverFoto($beritaId)
    {
        $coverFoto = Media::where('ref_table', 'berita')
            ->where('ref_id', $beritaId)
            ->where('sort_order', 1)
            ->first();

        if ($coverFoto) {
            // PERUBAHAN: Hapus file dari storage - path baru
            Storage::disk('public')->delete('media/berita/' . $coverFoto->file_name);
            // Hapus record dari database
            $coverFoto->delete();
        }
    }

    /**
     * Delete semua file terkait berita
     */
    private function deleteAllFiles($beritaId)
    {
        $files = Media::where('ref_table', 'berita')
            ->where('ref_id', $beritaId)
            ->get();

        foreach ($files as $file) {
            // Tentukan path berdasarkan sort_order
            if ($file->sort_order == 1) {
                // Cover foto - PERUBAHAN PATH
                Storage::disk('public')->delete('media/berita/' . $file->file_name);
            } else {
                // Gambar pendukung - PERUBAHAN PATH
                Storage::disk('public')->delete('media/berita/gallery/' . $file->file_name);
            }
            $file->delete();
        }
    }

    /**
     * Delete file individual
     */
    public function deleteFile(string $beritaId, string $fileId)
    {
        $file = Media::where('media_id', $fileId)
            ->where('ref_table', 'berita')
            ->where('ref_id', $beritaId)
            ->firstOrFail();

        // Tentukan path berdasarkan sort_order
        if ($file->sort_order == 1) {
            // Cover foto - PERUBAHAN PATH
            Storage::disk('public')->delete('media/berita/' . $file->file_name);
        } else {
            // Gambar pendukung - PERUBAHAN PATH
            Storage::disk('public')->delete('media/berita/gallery/' . $file->file_name);
        }

        $file->delete();

        return redirect()->route('berita.show', $beritaId)->with('success', 'File berhasil dihapus!');
    }
}
