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
        // Gunakan scope seperti di Agenda
        $filterableColumns = []; // Tambahkan kolom filter jika ada
        $searchableColumns = ['judul', 'deskripsi'];

        $data['dataGaleri'] = Galeri::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->with(['media' => function($query) {
                $query->where('ref_table', 'galeri')
                      ->orderBy('sort_order');
            }])
            ->latest()
            ->paginate(10)
            ->withQueryString();

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

        // Upload foto utama
        if ($request->hasFile('foto_utama')) {
            $this->uploadFotoUtama($request->file('foto_utama'), $galeri->galeri_id);
        }

        // Upload foto pendukung jika ada
        if ($request->hasFile('foto_pendukung')) {
            $this->uploadFotoPendukung($request->file('foto_pendukung'), $galeri->galeri_id);
        }

        return redirect()->route('galeri.index')->with('success', 'Penambahan Data Galeri Berhasil!');
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
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto_utama' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'foto_pendukung' => 'nullable|array',
            'foto_pendukung.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $galeri = Galeri::findOrFail($id);
        $galeri->update($request->only([
            'judul',
            'deskripsi'
        ]));

        // Upload foto utama baru jika ada
        if ($request->hasFile('foto_utama')) {
            $this->uploadFotoUtama($request->file('foto_utama'), $galeri->galeri_id);
        }

        // Upload foto pendukung baru jika ada
        if ($request->hasFile('foto_pendukung')) {
            $this->uploadFotoPendukung($request->file('foto_pendukung'), $galeri->galeri_id);
        }

        // Handle delete file tertentu jika ada request delete_files
        if ($request->has('delete_files')) {
            foreach ($request->delete_files as $fileId) {
                $file = Media::where('media_id', $fileId)
                    ->where('ref_table', 'galeri')
                    ->where('ref_id', $galeri->galeri_id)
                    ->first();

                if ($file) {
                    // Jangan hapus foto utama (sort_order = 1)
                    if ($file->sort_order != 1) {
                        Storage::disk('public')->delete('media/galeri/' . $file->file_name);
                        $file->delete();
                    }
                }
            }
        }

        return redirect()->route('galeri.index')->with('success', 'Perubahan Data Galeri Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $galeri = Galeri::findOrFail($id);

        // Hapus semua file terkait galeri ini
        $this->deleteAllFiles($galeri->galeri_id);

        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Data Galeri berhasil dihapus');
    }

    /**
     * Upload foto tambahan dari halaman show (untuk foto pendukung)
     */
    public function uploadFiles(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $galeri = Galeri::findOrFail($id);

            $request->validate([
                'foto' => 'required|array',
                'foto.*' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120'
            ]);

            // Cek jumlah file (maksimal 5 file)
            if (count($request->file('foto')) > 5) {
                return redirect()->back()->with('error', 'Maksimal 5 file yang dapat diupload sekaligus');
            }

            // Upload foto pendukung
            if ($request->hasFile('foto')) {
                $this->uploadFotoPendukung($request->file('foto'), $galeri->galeri_id);
            }

            DB::commit();

            return redirect()->route('galeri.show', $galeri->galeri_id)
                ->with('success', 'Foto pendukung berhasil diupload');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('galeri.show', $id)
                ->with('error', 'Gagal upload foto: ' . $e->getMessage());
        }
    }

    /**
     * Upload foto utama (single file)
     */
    private function uploadFotoUtama($file, $galeriId)
    {
        if ($file->isValid()) {
            // Generate unique filename untuk foto utama
            $filename = 'galeri-utama-' . $galeriId . '-' . time() . '.' . $file->getClientOriginalExtension();

            // Store file
            $file->storeAs('media/galeri', $filename, 'public');

            // Cek apakah sudah ada foto utama
            $existingUtama = Media::where('ref_table', 'galeri')
                ->where('ref_id', $galeriId)
                ->where('sort_order', 1)
                ->first();

            if ($existingUtama) {
                // Hapus file lama
                Storage::disk('public')->delete('media/galeri/' . $existingUtama->file_name);
                // Update record yang ada
                $existingUtama->update([
                    'file_name' => $filename,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            } else {
                // Buat record baru
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
        }
    }

    /**
     * Upload foto pendukung (multiple files)
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
     * Delete semua file terkait galeri
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
     * Delete file individual - Cegah hapus foto utama
     */
    public function deleteFile(string $galeriId, string $fileId)
    {
        try {
            DB::beginTransaction();

            $file = Media::where('media_id', $fileId)
                ->where('ref_table', 'galeri')
                ->where('ref_id', $galeriId)
                ->firstOrFail();

            // Cegah hapus foto utama (sort_order = 1)
            if ($file->sort_order == 1) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus foto utama! Silakan ganti foto utama melalui edit galeri.');
            }

            Storage::disk('public')->delete('media/galeri/' . $file->file_name);
            $file->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Foto pendukung berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
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
