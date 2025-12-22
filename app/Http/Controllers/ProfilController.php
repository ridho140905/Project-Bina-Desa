<?php
namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $this->uploadFotoProfilFile($request->file('foto_profil'), $profil->profil_id);
        }

        // Upload file pendukung jika ada
        if ($request->hasFile('file_pendukung')) {
            $this->uploadFilePendukung($request->file('file_pendukung'), $profil->profil_id);
        }

        return redirect()->route('profil.index')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['dataProfil'] = Profil::with('media')->findOrFail($id);
        return view('pages.profil.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['dataProfil'] = Profil::with('media')->findOrFail($id);
        return view('pages.profil.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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

        $profil = Profil::findOrFail($id);
        $profil->update($request->all());

        // Upload foto profil baru jika ada (hanya jika melalui form edit)
        if ($request->hasFile('foto_profil') && $request->file('foto_profil')->isValid()) {
            // Hapus foto profil lama jika ada
            $this->deleteFotoProfil($profil->profil_id);
            // Upload foto profil baru
            $this->uploadFotoProfilFile($request->file('foto_profil'), $profil->profil_id);
        }

        // Upload file pendukung baru jika ada (hanya jika melalui form edit)
        if ($request->hasFile('file_pendukung')) {
            $this->uploadFilePendukung($request->file('file_pendukung'), $profil->profil_id);
        }

        return redirect()->route('profil.index')->with('success', 'Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profil = Profil::findOrFail($id);

        // Hapus semua file terkait profil ini
        $this->deleteAllFiles($profil->profil_id);

        $profil->delete();

        return redirect()->route('profil.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * UPLOAD FOTO PROFIL VIA ROUTE TERPISAH
     */
    public function uploadFotoProfil(Request $request, string $id)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $profil = Profil::findOrFail($id);

        // Hapus foto profil lama jika ada
        $this->deleteFotoProfil($profil->profil_id);

        // Upload foto profil baru
        $this->uploadFotoProfilFile($request->file('foto_profil'), $profil->profil_id);

        return redirect()->back()->with('success', 'Foto profil berhasil diupload!');
    }

    /**
     * UPLOAD FILE PENDUKUNG VIA ROUTE TERPISAH
     */
    public function uploadFiles(Request $request, string $id)
    {
        $request->validate([
            'file_pendukung'   => 'required|array',
            'file_pendukung.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:2048',
        ]);

        $profil = Profil::findOrFail($id);

        if ($request->hasFile('file_pendukung')) {
            $this->uploadFilePendukung($request->file('file_pendukung'), $profil->profil_id);
        }

        return redirect()->back()->with('success', 'File pendukung berhasil diupload!');
    }

    /**
     * Helper: Upload foto profil file
     */
    private function uploadFotoProfilFile($file, $profilId)
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
        $sortOrder = Media::where('ref_table', 'profil')
            ->where('ref_id', $profilId)
            ->max('sort_order') ?? 1;

        $sortOrder = $sortOrder >= 1 ? $sortOrder + 1 : 2;

        foreach ($files as $file) {
            if ($file->isValid()) {
                // Generate unique filename
                $filename = 'file-pendukung-' . $profilId . '-' . time() . '-' . $sortOrder . '.' . $file->getClientOriginalExtension();

                // Store file - simpan di folder 'media/profil/files'
                $file->storeAs('media/profil/files', $filename, 'public');

                // Simpan ke tabel media dengan struktur yang baru
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
    public function deleteFile(string $profilId, string $fileId)
    {
        $file = Media::where('media_id', $fileId)
            ->where('ref_table', 'profil')
            ->where('ref_id', $profilId)
            ->firstOrFail();

        // Tentukan path berdasarkan sort_order
        if ($file->sort_order == 1) {
            // Foto profil
            Storage::disk('public')->delete('media/profil/' . $file->file_name);
        } else {
            // File pendukung
            Storage::disk('public')->delete('media/profil/files/' . $file->file_name);
        }

        $file->delete();

        return redirect()->back()->with('success', 'File berhasil dihapus!');
    }
}
