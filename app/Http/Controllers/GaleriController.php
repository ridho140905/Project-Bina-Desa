<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // PAKAI YANG SUDAH ADA (jangan diubah konsep filter seperti di user)
        $query = Galeri::query()->with(['media' => function($query) {
            $query->where('ref_table', 'galeri')
                  ->orderBy('sort_order');
        }]);

        // Filter berdasarkan search (judul atau deskripsi)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan huruf pertama judul
        if ($request->filled('filter_galeri')) {
            if ($request->filter_galeri == 'a') {
                $query->whereRaw('LOWER(SUBSTRING(judul, 1, 1)) BETWEEN "a" AND "m"');
            } elseif ($request->filter_galeri == 'n') {
                $query->whereRaw('LOWER(SUBSTRING(judul, 1, 1)) BETWEEN "n" AND "z"');
            }
        }

        $query->latest();
        $data['dataGaleri'] = $query->paginate(10);
        $data['dataGaleri']->appends($request->query());

        return view('pages.galeri.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'foto_utama' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120', // 5MB max
                'foto_pendukung' => 'nullable|array',
                'foto_pendukung.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            ]);

            // Simpan data galeri
            $galeri = Galeri::create($request->only([
                'judul',
                'deskripsi'
            ]));

            // Upload foto utama jika ada
            if ($request->hasFile('foto_utama') && $request->file('foto_utama')->isValid()) {
                $this->uploadFotoUtama($request->file('foto_utama'), $galeri->galeri_id);
            }

            // Upload foto pendukung jika ada
            if ($request->hasFile('foto_pendukung')) {
                $this->uploadFotoPendukung($request->file('foto_pendukung'), $galeri->galeri_id);
            }

            DB::commit();

            return redirect()->route('galeri.index')->with('success', 'Penambahan Data Galeri Berhasil!');

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
        $data['dataGaleri'] = Galeri::with(['media' => function($query) {
            $query->where('ref_table', 'galeri')
                  ->orderBy('sort_order');
        }])->findOrFail($id);

        return view('pages.galeri.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['dataGaleri'] = Galeri::with(['media' => function($query) {
            $query->where('ref_table', 'galeri')
                  ->orderBy('sort_order');
        }])->findOrFail($id);

        return view('pages.galeri.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'foto_utama' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            ]);

            $galeri = Galeri::findOrFail($id);
            $galeri->update($request->only([
                'judul',
                'deskripsi'
            ]));

            // Upload foto utama baru jika ada
            if ($request->hasFile('foto_utama') && $request->file('foto_utama')->isValid()) {
                // Hapus foto utama lama jika ada
                $this->deleteFotoUtama($galeri->galeri_id);
                // Upload foto utama baru
                $this->uploadFotoUtama($request->file('foto_utama'), $galeri->galeri_id);
            }

            // Handle delete file tertentu jika ada request delete_files
            if ($request->has('delete_files')) {
                foreach ($request->delete_files as $fileId) {
                    $file = Media::where('media_id', $fileId)
                        ->where('ref_table', 'galeri')
                        ->where('ref_id', $galeri->galeri_id)
                        ->first();

                    if ($file && $file->sort_order != 1) { // Jangan hapus foto utama (sort_order = 1)
                        Storage::disk('public')->delete('media/galeri/' . $file->file_name);
                        $file->delete();
                    }
                }
            }

            DB::commit();

            return redirect()->route('galeri.index')->with('success', 'Perubahan Data Galeri Berhasil!');

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

            $galeri = Galeri::findOrFail($id);

            // Hapus semua file terkait galeri ini
            $this->deleteAllFiles($galeri->galeri_id);

            $galeri->delete();

            DB::commit();

            return redirect()->route('galeri.index')->with('success', 'Data Galeri berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * UPLOAD FOTO UTAMA VIA ROUTE TERPISAH
     */
    public function uploadFotoUtamaSeparate(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'foto_utama' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120'
            ]);

            $galeri = Galeri::findOrFail($id);

            // Hapus foto utama lama jika ada
            $this->deleteFotoUtama($galeri->galeri_id);

            // Upload foto utama baru
            $this->uploadFotoUtama($request->file('foto_utama'), $galeri->galeri_id);

            DB::commit();

            return redirect()->back()->with('success', 'Foto utama berhasil diupload!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal upload foto utama: ' . $e->getMessage());
        }
    }

    /**
     * UPLOAD FOTO PENDUKUNG VIA ROUTE TERPISAH
     */
    public function uploadFiles(Request $request, string $galeri)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'foto_pendukung' => 'required|array',
                'foto_pendukung.*' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120'
            ]);

            $galeriModel = Galeri::findOrFail($galeri);

            // Cek jumlah file (maksimal 5 file)
            if (count($request->file('foto_pendukung')) > 5) {
                return redirect()->back()->with('error', 'Maksimal 5 file yang dapat diupload sekaligus');
            }

            // Upload foto pendukung
            if ($request->hasFile('foto_pendukung')) {
                $this->uploadFotoPendukung($request->file('foto_pendukung'), $galeriModel->galeri_id);
            }

            DB::commit();

            return redirect()->route('galeri.show', $galeriModel->galeri_id)
                ->with('success', 'Foto pendukung berhasil diupload');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('galeri.show', $galeri)
                ->with('error', 'Gagal upload foto: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Upload foto utama
     */
    private function uploadFotoUtama($file, $galeriId)
    {
        // Generate unique filename untuk foto utama
        $filename = 'galeri-utama-' . $galeriId . '-' . time() . '.' . $file->getClientOriginalExtension();

        // Store file
        $file->storeAs('media/galeri', $filename, 'public');

        // Simpan ke tabel media
        Media::create([
            'ref_table'     => 'galeri',
            'ref_id'        => $galeriId,
            'file_name'     => $filename,
            'mime_type'     => $file->getMimeType(),
            'caption'       => 'Foto Utama Galeri',
            'sort_order'    => 1, // Foto utama selalu sort_order = 1
            'file_size'     => $file->getSize(),
        ]);
    }

    /**
     * Helper: Upload foto pendukung
     */
    private function uploadFotoPendukung($files, $galeriId)
    {
        // Cari sort_order terakhir untuk foto pendukung (dimulai dari 2)
        $lastSortOrder = Media::where('ref_table', 'galeri')
            ->where('ref_id', $galeriId)
            ->max('sort_order') ?? 1;

        $sortOrder = ($lastSortOrder == 1) ? 2 : $lastSortOrder + 1;

        foreach ($files as $file) {
            if ($file->isValid()) {
                // Generate unique filename
                $filename = 'galeri-pendukung-' . $galeriId . '-' . time() . '-' . $sortOrder . '.' . $file->getClientOriginalExtension();

                // Store file
                $file->storeAs('media/galeri', $filename, 'public');

                // Simpan ke tabel media
                Media::create([
                    'ref_table'     => 'galeri',
                    'ref_id'        => $galeriId,
                    'file_name'     => $filename,
                    'mime_type'     => $file->getMimeType(),
                    'caption'       => 'Foto Pendukung Galeri',
                    'sort_order'    => $sortOrder,
                    'file_size'     => $file->getSize(),
                ]);

                $sortOrder++;
            }
        }
    }

    /**
     * Helper: Hapus foto utama
     */
    private function deleteFotoUtama($galeriId)
    {
        $fotoUtama = Media::where('ref_table', 'galeri')
            ->where('ref_id', $galeriId)
            ->where('sort_order', 1)
            ->first();

        if ($fotoUtama) {
            // Hapus file dari storage
            Storage::disk('public')->delete('media/galeri/' . $fotoUtama->file_name);
            // Hapus record dari database
            $fotoUtama->delete();
        }
    }

    /**
     * Helper: Hapus semua file terkait galeri
     */
    private function deleteAllFiles($galeriId)
    {
        $files = Media::where('ref_table', 'galeri')
            ->where('ref_id', $galeriId)
            ->get();

        foreach ($files as $file) {
            Storage::disk('public')->delete('media/galeri/' . $file->file_name);
            $file->delete();
        }
    }

    /**
     * DELETE FILE INDIVIDUAL - PERBAIKAN: BOLEH HAPUS FOTO UTAMA
     */
   public function deleteFile(string $galeri, string $file)
{
    try {
        DB::beginTransaction();

        // Cari file berdasarkan galeri_id dan media_id
        $media = Media::where('media_id', $file)
            ->where('ref_table', 'galeri')
            ->where('ref_id', $galeri)
            ->firstOrFail();

        // Hapus file dari storage
        Storage::disk('public')->delete('media/galeri/' . $media->file_name);

        // Hapus record dari database
        $media->delete();

        DB::commit();

        return redirect()->back()->with('success', 'Foto berhasil dihapus!');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Delete file error: ' . $e->getMessage(), [
            'galeri' => $galeri,
            'file' => $file,
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()->with('error', 'Gagal menghapus file: ' . $e->getMessage());
    }
}

    /**
     * Update sort order untuk foto
     */
    public function updateSortOrder(Request $request, string $galeriId)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'sort_order' => 'required|array',
                'sort_order.*' => 'integer'
            ]);

            foreach ($request->sort_order as $mediaId => $sortOrder) {
                Media::where('media_id', $mediaId)
                    ->where('ref_table', 'galeri')
                    ->where('ref_id', $galeriId)
                    ->update(['sort_order' => $sortOrder]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Urutan foto berhasil diupdate!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal update urutan: ' . $e->getMessage()], 500);
        }
    }
}
