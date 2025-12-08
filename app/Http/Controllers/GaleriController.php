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
    public function index()
    {
        $data['dataGaleri'] = Galeri::with('media')->orderBy('created_at', 'desc')->paginate(10);
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
            'foto' => 'required|array',
            'foto.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120', // 5MB max
        ]);

        DB::transaction(function () use ($request) {
            // Simpan data galeri
            $galeri = Galeri::create($request->only([
                'judul',
                'deskripsi'
            ]));

            // Upload foto jika ada
            if ($request->hasFile('foto')) {
                $this->uploadFoto($request->file('foto'), $galeri->galeri_id);
            }
        });

        return redirect()->route('galeri.index')->with('success', 'Penambahan Data Galeri Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['dataGaleri'] = Galeri::with('media')->findOrFail($id);
        return view('pages.galeri.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['dataGaleri'] = Galeri::with('media')->findOrFail($id);
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
            'foto' => 'nullable|array',
            'foto.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120', // 5MB max
        ]);

        $galeri = Galeri::findOrFail($id);

        DB::transaction(function () use ($request, $galeri) {
            // Update data galeri
            $galeri->update($request->only([
                'judul',
                'deskripsi'
            ]));

            // Upload foto baru jika ada
            if ($request->hasFile('foto')) {
                $this->uploadFoto($request->file('foto'), $galeri->galeri_id);
            }
        });

        return redirect()->route('galeri.index')->with('success', 'Perubahan Data Galeri Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $galeri = Galeri::findOrFail($id);

        DB::transaction(function () use ($galeri) {
            // Hapus semua file terkait galeri ini
            $this->deleteAllFiles($galeri->galeri_id);

            $galeri->delete();
        });

        return redirect()->route('galeri.index')->with('success', 'Data Galeri berhasil dihapus');
    }

    /**
     * Upload foto tambahan ke galeri yang sudah ada
     */
    public function uploadFiles(Request $request, string $galeriId)
    {
        $request->validate([
            'foto' => 'required|array',
            'foto.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120', // 5MB max
        ]);

        $galeri = Galeri::findOrFail($galeriId);

        DB::transaction(function () use ($request, $galeri) {
            // Upload foto baru
            if ($request->hasFile('foto')) {
                $this->uploadFoto($request->file('foto'), $galeri->galeri_id);
            }
        });

        return redirect()->route('galeri.show', $galeriId)->with('success', 'Foto berhasil ditambahkan ke galeri!');
    }

    /**
     * Upload foto galeri
     */
    private function uploadFoto($files, $galeriId)
    {
        // Get current max sort_order untuk galeri ini
        $maxSortOrder = Media::where('ref_table', 'galeri')
            ->where('ref_id', $galeriId)
            ->max('sort_order') ?? 0;

        $sortOrder = $maxSortOrder + 1;

        foreach ($files as $file) {
            if ($file->isValid()) {
                // Generate unique filename
                $filename = 'galeri-' . $galeriId . '-' . time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Store file - simpan di folder 'media/galeri'
                $file->storeAs('media/galeri', $filename, 'public');

                // Simpan ke tabel media
                Media::create([
                    'ref_table'     => 'galeri',
                    'ref_id'        => $galeriId,
                    'file_name'     => $filename,
                    'mime_type'     => $file->getMimeType(),
                    'caption'       => 'Foto Galeri',
                    'sort_order'    => $sortOrder,
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
            // Hapus file dari storage
            Storage::disk('public')->delete('media/galeri/' . $file->file_name);
            // Hapus record dari database
            $file->delete();
        }
    }

    /**
     * Delete file individual
     */
    public function deleteFile(string $galeriId, string $fileId)
    {
        $file = Media::where('media_id', $fileId)
            ->where('ref_table', 'galeri')
            ->where('ref_id', $galeriId)
            ->firstOrFail();

        // Hapus file dari storage
        Storage::disk('public')->delete('media/galeri/' . $file->file_name);

        $file->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus!');
    }

    /**
     * Update sort order untuk foto
     */
    public function updateSortOrder(Request $request, string $galeriId)
    {
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

        return response()->json(['success' => true, 'message' => 'Urutan foto berhasil diupdate!']);
    }
}
