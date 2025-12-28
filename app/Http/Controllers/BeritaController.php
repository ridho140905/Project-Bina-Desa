<?php
namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Daftar kolom yang bisa difilter sesuai name pada form
        $filterableColumns = ['status'];
        $searchableColumns = ['judul', 'penulis'];

        // Gunakan scope filter untuk memproses query
        $query = Berita::query()
            ->with(['kategori', 'media'])
            ->filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->orderBy('created_at', 'desc');

        // ===== CURSOR VERSI LARAVEL =====
        $beritas = $query->get();
        foreach ($beritas as $berita) {
            // proses satu per satu (cursor)
            if ($berita->status === 'terbit' && $berita->terbit_at === null) {
                $berita->terbit_at = now();
                $berita->save();
            }
        }
        // ===== END CURSOR =====

        // Data tetap sama ke view
        $data['dataBerita'] = $query->paginate(10)->withQueryString();

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
        try {
            DB::beginTransaction();

            // Validasi data
            $request->validate([
                'kategori_id'        => 'required|exists:kategori_berita,kategori_id',
                'judul'              => 'required|string|max:255',
                'slug'               => 'required|string|max:300|unique:berita,slug',
                'isi_html'           => 'required|string',
                'penulis'            => 'required|string|max:100',
                'cover_foto'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'gambar_pendukung'   => 'nullable|array',
                'gambar_pendukung.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                'status'             => 'required|in:draft,terbit',
                'terbit_at'          => 'nullable|date',
            ]);

            $data = $request->except(['cover_foto', 'gambar_pendukung']);

            // Jika status terbit dan terbit_at kosong, set terbit_at ke waktu sekarang
            if ($request->status == 'terbit' && empty($request->terbit_at)) {
                $data['terbit_at'] = now();
            }

            // Simpan data berita
            $berita = Berita::create($data);

            // Upload cover foto jika ada
            if ($request->hasFile('cover_foto') && $request->file('cover_foto')->isValid()) {
                $this->uploadCoverFoto($request->file('cover_foto'), $berita->berita_id);
            }

            // Upload gambar pendukung jika ada
            if ($request->hasFile('gambar_pendukung')) {
                $this->uploadGambarPendukung($request->file('gambar_pendukung'), $berita->berita_id);
            }

            DB::commit();

            return redirect()->route('berita.index')->with('success', 'Penambahan Data Berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['berita'] = Berita::with(['kategori', 'media' => function($query) {
            $query->where('ref_table', 'berita')
                  ->orderBy('sort_order');
        }])->findOrFail($id);

        return view('pages.berita.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['berita']         = Berita::with(['kategori', 'media' => function($query) {
            $query->where('ref_table', 'berita')
                  ->orderBy('sort_order');
        }])->findOrFail($id);

        $data['kategoriBerita'] = KategoriBerita::all();
        return view('pages.berita.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $berita = Berita::findOrFail($id);

            $request->validate([
                'kategori_id'        => 'required|exists:kategori_berita,kategori_id',
                'judul'              => 'required|string|max:250',
                'slug'               => 'required|string|max:300|unique:berita,slug,' . $id . ',berita_id',
                'isi_html'           => 'required|string',
                'penulis'            => 'required|string|max:100',
                'cover_foto'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'gambar_pendukung'   => 'nullable|array',
                'gambar_pendukung.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                'status'             => 'required|in:draft,terbit',
                'terbit_at'          => 'nullable|date',
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

            // Handle delete file tertentu jika ada request delete_files
            if ($request->has('delete_files')) {
                foreach ($request->delete_files as $fileId) {
                    $file = Media::where('media_id', $fileId)
                        ->where('ref_table', 'berita')
                        ->where('ref_id', $berita->berita_id)
                        ->first();

                    if ($file && $file->sort_order != 1) { // Jangan hapus cover foto (sort_order = 1)
                        // Tentukan path berdasarkan sort_order
                        if ($file->sort_order == 1) {
                            Storage::disk('public')->delete('media/berita/' . $file->file_name);
                        } else {
                            Storage::disk('public')->delete('media/berita/gallery/' . $file->file_name);
                        }
                        $file->delete();
                    }
                }
            }

            DB::commit();

            return redirect()->route('berita.index')->with('success', 'Data Berhasil Diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $berita = Berita::findOrFail($id);

            // Hapus semua file terkait berita ini
            $this->deleteAllFiles($berita->berita_id);

            $berita->delete();

            DB::commit();

            return redirect()->route('berita.index')->with('success', 'Data berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * UPLOAD COVER FOTO VIA ROUTE TERPISAH
     */
    public function uploadCoverFotoSeparate(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'cover_foto' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            $berita = Berita::findOrFail($id);

            // Hapus cover foto lama jika ada
            $this->deleteCoverFoto($berita->berita_id);

            // Upload cover foto baru
            $this->uploadCoverFoto($request->file('cover_foto'), $berita->berita_id);

            DB::commit();

            return redirect()->back()->with('success', 'Cover foto berhasil diupload!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal upload cover foto: ' . $e->getMessage());
        }
    }

    /**
     * UPLOAD GAMBAR PENDUKUNG VIA ROUTE TERPISAH
     */
    public function uploadGambarPendukungFiles(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'gambar_pendukung'   => 'required|array',
                'gambar_pendukung.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            $berita = Berita::findOrFail($id);

            // Cek jumlah file
            if (count($request->file('gambar_pendukung')) > 10) {
                return redirect()->back()->with('error', 'Maksimal 10 gambar yang dapat diupload sekaligus');
            }

            if ($request->hasFile('gambar_pendukung')) {
                $this->uploadGambarPendukung($request->file('gambar_pendukung'), $berita->berita_id);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Gambar pendukung berhasil diupload!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal upload gambar pendukung: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Upload cover foto file
     */
    private function uploadCoverFoto($file, $beritaId)
    {
        // Generate unique filename
        $filename = 'cover-berita-' . $beritaId . '-' . time() . '.' . $file->getClientOriginalExtension();

        // Store file - simpan di folder 'media/berita'
        $file->storeAs('media/berita', $filename, 'public');

        // Simpan ke tabel media dengan struktur yang baru
        Media::create([
            'ref_table'  => 'berita',
            'ref_id'     => $beritaId,
            'file_name'  => $filename,
            'mime_type'  => $file->getMimeType(),
            'caption'    => 'Cover Berita',
            'sort_order' => 1,
        ]);
    }

    /**
     * Helper: Upload gambar pendukung
     */
    private function uploadGambarPendukung($files, $beritaId)
    {
        // Cari sort_order maksimum untuk gambar pendukung (sort_order > 1)
        $maxSortOrder = Media::where('ref_table', 'berita')
            ->where('ref_id', $beritaId)
            ->where('sort_order', '>', 1)
            ->max('sort_order');

        // Jika belum ada gambar pendukung, mulai dari 2
        $sortOrder = $maxSortOrder ? $maxSortOrder + 1 : 2;

        foreach ($files as $file) {
            if ($file->isValid()) {
                // Generate unique filename
                $filename = 'gambar-pendukung-' . $beritaId . '-' . time() . '-' . $sortOrder . '.' . $file->getClientOriginalExtension();

                // Store file - simpan di folder 'media/berita/gallery'
                $file->storeAs('media/berita/gallery', $filename, 'public');

                // Simpan ke tabel media dengan struktur yang baru
                Media::create([
                    'ref_table'  => 'berita',
                    'ref_id'     => $beritaId,
                    'file_name'  => $filename,
                    'mime_type'  => $file->getMimeType(),
                    'caption'    => 'Gambar Pendukung Berita',
                    'sort_order' => $sortOrder,
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
            // Hapus file dari storage
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
                // Cover foto
                Storage::disk('public')->delete('media/berita/' . $file->file_name);
            } else {
                // Gambar pendukung
                Storage::disk('public')->delete('media/berita/gallery/' . $file->file_name);
            }
            $file->delete();
        }
    }

    /**
     * Delete file individual
     */
    public function deleteFile(string $berita_id, string $file_id)
    {
        try {
            DB::beginTransaction();

            // Validasi: pastikan berita ada
            $berita = Berita::findOrFail($berita_id);

            // Cari file
            $file = Media::where('media_id', $file_id)
                ->where('ref_table', 'berita')
                ->where('ref_id', $berita_id)
                ->firstOrFail();

            // Tentukan path berdasarkan sort_order
            if ($file->sort_order == 1) {
                // Cover foto
                Storage::disk('public')->delete('media/berita/' . $file->file_name);
            } else {
                // Gambar pendukung
                Storage::disk('public')->delete('media/berita/gallery/' . $file->file_name);
            }

            $file->delete();

            DB::commit();

            return redirect()->back()->with('success', 'File berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }

    /**
     * Delete semua gambar pendukung (kecuali cover)
     */
    public function deleteAllGambarPendukung(string $id)
    {
        try {
            DB::beginTransaction();

            $gambarPendukung = Media::where('ref_table', 'berita')
                ->where('ref_id', $id)
                ->where('sort_order', '>', 1)
                ->get();

            foreach ($gambarPendukung as $gambar) {
                Storage::disk('public')->delete('media/berita/gallery/' . $gambar->file_name);
                $gambar->delete();
            }

            DB::commit();

            return redirect()->route('berita.show', $id)->with('success', 'Semua gambar pendukung berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus gambar pendukung: ' . $e->getMessage());
        }
    }
}
