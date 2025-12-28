<?php
namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Daftar kolom yang bisa difilter sesuai name pada form
        $filterableColumns = ['provinsi'];
        $searchableColumns = ['nama_desa', 'kecamatan', 'kabupaten'];

        // Gunakan scope filter untuk memproses query
        $data['dataProfil'] = Profil::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->with(['media' => function($query) {
                $query->orderBy('sort_order');
            }])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.profil.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.profil.create');
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
                'nama_desa'        => 'required|string|max:255',
                'kecamatan'        => 'required|string|max:255',
                'kabupaten'        => 'required|string|max:255',
                'provinsi'         => 'required|string|max:255',
                'telepon'          => 'required|string|max:20',
                'email'            => 'required|email|max:255',
                'alamat_kantor'    => 'required|string',
                'visi'             => 'required|string',
                'misi'             => 'required|string',
                'foto_profil'      => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'file_pendukung'   => 'nullable|array',
                'file_pendukung.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:2048',
            ]);

            // Simpan data profil
            $profil = Profil::create($request->all());

            // Upload foto profil jika ada
            if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
                $this->uploadFotoProfil($request->file('foto_profil'), $profil->profil_id);
            }

            // Upload file pendukung jika ada
            if ($request->hasFile('file_pendukung')) {
                $this->uploadFilePendukung($request->file('file_pendukung'), $profil->profil_id);
            }

            DB::commit();

            return redirect()->route('profil.index')->with('success', 'Penambahan Data Berhasil!');

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
        $data['dataProfil'] = Profil::with(['media' => function($query) {
            $query->where('ref_table', 'profil')
                  ->orderBy('sort_order');
        }])->findOrFail($id);

        return view('pages.profil.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['dataProfil'] = Profil::with(['media' => function($query) {
            $query->where('ref_table', 'profil')
                  ->orderBy('sort_order');
        }])->findOrFail($id);

        return view('pages.profil.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            // Validasi data
            $request->validate([
                'nama_desa'        => 'required|string|max:255',
                'kecamatan'        => 'required|string|max:255',
                'kabupaten'        => 'required|string|max:255',
                'provinsi'         => 'required|string|max:255',
                'telepon'          => 'required|string|max:20',
                'email'            => 'required|email|max:255',
                'alamat_kantor'    => 'required|string',
                'visi'             => 'required|string',
                'misi'             => 'required|string',
                'foto_profil'      => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            $profil = Profil::findOrFail($id);
            $profil->update($request->all());

            // Upload foto profil baru jika ada
            if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
                // Hapus foto profil lama jika ada
                $this->deleteFotoProfil($profil->profil_id);
                // Upload foto profil baru
                $this->uploadFotoProfil($request->file('foto_profil'), $profil->profil_id);
            }

            // Handle delete file tertentu jika ada request delete_files
            if ($request->has('delete_files')) {
                foreach ($request->delete_files as $fileId) {
                    $file = Media::where('media_id', $fileId)
                        ->where('ref_table', 'profil')
                        ->where('ref_id', $profil->profil_id)
                        ->first();

                    if ($file && $file->sort_order != 1) { // Jangan hapus foto profil (sort_order = 1)
                        // Tentukan path berdasarkan sort_order
                        if ($file->sort_order == 1) {
                            Storage::disk('public')->delete('media/profil/' . $file->file_name);
                        } else {
                            Storage::disk('public')->delete('media/profil/files/' . $file->file_name);
                        }
                        $file->delete();
                    }
                }
            }

            DB::commit();

            return redirect()->route('profil.index')->with('success', 'Data Berhasil Diupdate!');

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

            $profil = Profil::findOrFail($id);

            // Hapus semua file terkait profil ini
            $this->deleteAllFiles($profil->profil_id);

            $profil->delete();

            DB::commit();

            return redirect()->route('profil.index')->with('success', 'Data berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * UPLOAD FOTO PROFIL VIA ROUTE TERPISAH
     */
    public function uploadFotoProfilSeparate(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'foto_profil' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
            ]);

            $profil = Profil::findOrFail($id);

            // Hapus foto profil lama jika ada
            $this->deleteFotoProfil($profil->profil_id);

            // Upload foto profil baru
            $this->uploadFotoProfil($request->file('foto_profil'), $profil->profil_id);

            DB::commit();

            return redirect()->back()->with('success', 'Foto profil berhasil diupload!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal upload foto profil: ' . $e->getMessage());
        }
    }

    /**
     * UPLOAD FILE PENDUKUNG VIA ROUTE TERPISAH
     */
    public function uploadFiles(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'file_pendukung'   => 'required|array',
                'file_pendukung.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:2048',
            ]);

            $profil = Profil::findOrFail($id);

            // Cek jumlah file
            if (count($request->file('file_pendukung')) > 5) {
                return redirect()->back()->with('error', 'Maksimal 5 file yang dapat diupload sekaligus');
            }

            if ($request->hasFile('file_pendukung')) {
                $this->uploadFilePendukung($request->file('file_pendukung'), $profil->profil_id);
            }

            DB::commit();

            return redirect()->back()->with('success', 'File pendukung berhasil diupload!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal upload file pendukung: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Upload foto profil file
     */
    private function uploadFotoProfil($file, $profilId)
    {
        // Generate unique filename
        $filename = 'foto-profil-' . $profilId . '-' . time() . '.' . $file->getClientOriginalExtension();

        // Store file - simpan di folder 'media/profil'
        $file->storeAs('media/profil', $filename, 'public');

        // Simpan ke tabel media dengan struktur yang baru
        Media::create([
            'ref_table'     => 'profil',
            'ref_id'        => $profilId,
            'file_name'     => $filename,
            'mime_type'     => $file->getMimeType(),
            'caption'       => 'Foto Profil Desa',
            'sort_order'    => 1,
        ]);
    }

    /**
     * Helper: Upload file pendukung
     */
    private function uploadFilePendukung($files, $profilId)
    {
        // Cari sort_order maksimum untuk file pendukung (sort_order > 1)
        $maxSortOrder = Media::where('ref_table', 'profil')
            ->where('ref_id', $profilId)
            ->where('sort_order', '>', 1)
            ->max('sort_order');

        // Jika belum ada file pendukung, mulai dari 2
        $sortOrder = $maxSortOrder ? $maxSortOrder + 1 : 2;

        foreach ($files as $file) {
            if ($file->isValid()) {
                // Generate unique filename
                $filename = 'file-pendukung-' . $profilId . '-' . time() . '-' . $sortOrder . '.' . $file->getClientOriginalExtension();

                // Store file - simpan di folder 'media/profil/files'
                $file->storeAs('media/profil/files', $filename, 'public');

                // Simpan ke tabel media
                Media::create([
                    'ref_table'     => 'profil',
                    'ref_id'        => $profilId,
                    'file_name'     => $filename,
                    'mime_type'     => $file->getMimeType(),
                    'caption'       => 'File Pendukung',
                    'sort_order'    => $sortOrder,
                ]);

                $sortOrder++;
            }
        }
    }

    /**
     * Delete foto profil
     */
    private function deleteFotoProfil($profilId)
    {
        $fotoProfil = Media::where('ref_table', 'profil')
            ->where('ref_id', $profilId)
            ->where('sort_order', 1)
            ->first();

        if ($fotoProfil) {
            // Hapus file dari storage
            Storage::disk('public')->delete('media/profil/' . $fotoProfil->file_name);
            // Hapus record dari database
            $fotoProfil->delete();
        }
    }

    /**
     * Delete semua file terkait profil
     */
    private function deleteAllFiles($profilId)
    {
        $files = Media::where('ref_table', 'profil')
            ->where('ref_id', $profilId)
            ->get();

        foreach ($files as $file) {
            // Tentukan path berdasarkan sort_order
            if ($file->sort_order == 1) {
                // Foto profil
                Storage::disk('public')->delete('media/profil/' . $file->file_name);
            } else {
                // File pendukung
                Storage::disk('public')->delete('media/profil/files/' . $file->file_name);
            }
            $file->delete();
        }
    }

    /**
     * Delete file individual
     */
    public function deleteFile(string $profil_id, string $file_id)
    {
        try {
            DB::beginTransaction();

            // Validasi: pastikan profil ada
            $profil = Profil::findOrFail($profil_id);

            // Cari file
            $file = Media::where('media_id', $file_id)
                ->where('ref_table', 'profil')
                ->where('ref_id', $profil_id)
                ->firstOrFail();

            if ($file->sort_order == 1) {
                // Hapus foto profil
                Storage::disk('public')->delete('media/profil/' . $file->file_name);
            } else {
                // Hapus file pendukung
                Storage::disk('public')->delete('media/profil/files/' . $file->file_name);
            }

            $file->delete();

            DB::commit();

            return redirect()->back()->with('success', 'File berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }
}
