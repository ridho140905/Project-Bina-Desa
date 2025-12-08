<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Daftar kolom yang bisa difilter sesuai name pada form
        $filterableColumns = ['penyelenggara', 'lokasi'];
        $searchableColumns = ['judul', 'deskripsi'];

        // Gunakan scope filter untuk memproses query
        $data['dataAgenda'] = Agenda::filter($request, $filterableColumns)
            ->search($request, $searchableColumns)
            ->with(['media' => function($query) {
                $query->orderBy('sort_order');
            }])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.agenda.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.agenda.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'penyelenggara' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gambar_pendukung' => 'nullable|array',
            'gambar_pendukung.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Simpan data agenda
        $agenda = Agenda::create($request->all());

        // Upload poster jika ada
        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            $this->uploadPoster($request->file('poster'), $agenda->agenda_id);
        }

        // Upload gambar pendukung jika ada
        if ($request->hasFile('gambar_pendukung')) {
            $this->uploadGambarPendukung($request->file('gambar_pendukung'), $agenda->agenda_id);
        }

        return redirect()->route('agenda.index')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['dataAgenda'] = Agenda::with(['media' => function($query) {
            $query->where('ref_table', 'agenda')
                  ->orderBy('sort_order');
        }])->findOrFail($id);

        return view('pages.agenda.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['dataAgenda'] = Agenda::with(['media' => function($query) {
            $query->where('ref_table', 'agenda')
                  ->orderBy('sort_order');
        }])->findOrFail($id);

        return view('pages.agenda.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data
        $request->validate([
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'penyelenggara' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gambar_pendukung' => 'nullable|array',
            'gambar_pendukung.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $agenda = Agenda::findOrFail($id);
        $agenda->update($request->all());

        // Upload poster baru jika ada
        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            // Hapus poster lama jika ada
            $this->deletePoster($agenda->agenda_id);
            // Upload poster baru
            $this->uploadPoster($request->file('poster'), $agenda->agenda_id);
        }

        // Upload gambar pendukung baru jika ada
        if ($request->hasFile('gambar_pendukung')) {
            $this->uploadGambarPendukung($request->file('gambar_pendukung'), $agenda->agenda_id);
        }

        // Handle delete file tertentu jika ada request delete_files
        if ($request->has('delete_files')) {
            foreach ($request->delete_files as $fileId) {
                $file = Media::where('media_id', $fileId)
                    ->where('ref_table', 'agenda')
                    ->where('ref_id', $agenda->agenda_id)
                    ->first();

                if ($file && $file->sort_order != 1) {
                    Storage::disk('public')->delete('media/agenda/' . $file->file_name);
                    $file->delete();
                }
            }
        }

        return redirect()->route('agenda.index')->with('success', 'Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agenda = Agenda::findOrFail($id);

        // Hapus semua file terkait agenda ini
        $this->deleteAllFiles($agenda->agenda_id);

        $agenda->delete();

        return redirect()->route('agenda.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Upload gambar pendukung tambahan dari halaman show
     */
    public function uploadImages(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $agenda = Agenda::findOrFail($id);

            $request->validate([
                'gambar_pendukung' => 'required|array',
                'gambar_pendukung.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            // Cek jumlah file
            if (count($request->file('gambar_pendukung')) > 5) {
                return redirect()->back()->with('error', 'Maksimal 5 file yang dapat diupload sekaligus');
            }

            // Upload gambar pendukung
            if ($request->hasFile('gambar_pendukung')) {
                $this->uploadGambarPendukung($request->file('gambar_pendukung'), $agenda->agenda_id);
            }

            DB::commit();

            return redirect()->route('agenda.show', $agenda->agenda_id)
                ->with('success', 'Gambar pendukung berhasil diupload');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('agenda.show', $id)
                ->with('error', 'Gagal upload gambar: ' . $e->getMessage());
        }
    }

    /**
     * Upload poster (gambar utama)
     */
    private function uploadPoster($file, $agendaId)
    {
        // Generate unique filename
        $filename = 'poster-agenda-' . $agendaId . '-' . time() . '.' . $file->getClientOriginalExtension();

        // Store file - simpan di folder 'media/agenda'
        $file->storeAs('media/agenda', $filename, 'public');

        // Simpan ke tabel media dengan struktur yang baru
        Media::create([
            'ref_table'     => 'agenda',
            'ref_id'        => $agendaId,
            'file_name'     => $filename,
            'mime_type'     => $file->getMimeType(),
            'caption'       => 'Poster Agenda',
            'sort_order'    => 1,
        ]);
    }

    /**
     * Upload gambar pendukung
     */
    private function uploadGambarPendukung($files, $agendaId)
    {
        // Cari sort_order terakhir untuk gambar pendukung
        $lastSortOrder = Media::where('ref_table', 'agenda')
            ->where('ref_id', $agendaId)
            ->max('sort_order') ?? 1;

        $sortOrder = $lastSortOrder + 1;

        foreach ($files as $file) {
            if ($file->isValid()) {
                // Generate unique filename
                $filename = 'gambar-pendukung-' . $agendaId . '-' . time() . '-' . $sortOrder . '.' . $file->getClientOriginalExtension();

                // Store file - simpan di folder 'media/agenda'
                $file->storeAs('media/agenda', $filename, 'public');

                // Simpan ke tabel media dengan struktur yang baru
                Media::create([
                    'ref_table'     => 'agenda',
                    'ref_id'        => $agendaId,
                    'file_name'     => $filename,
                    'mime_type'     => $file->getMimeType(),
                    'caption'       => 'Gambar Pendukung Agenda',
                    'sort_order'    => $sortOrder,
                ]);

                $sortOrder++;
            }
        }
    }

    /**
     * Delete poster
     */
    private function deletePoster($agendaId)
    {
        $poster = Media::where('ref_table', 'agenda')
            ->where('ref_id', $agendaId)
            ->where('sort_order', 1)
            ->first();

        if ($poster) {
            // Hapus file dari storage
            Storage::disk('public')->delete('media/agenda/' . $poster->file_name);
            // Hapus record dari database
            $poster->delete();
        }
    }

    /**
     * Delete semua file terkait agenda
     */
    private function deleteAllFiles($agendaId)
    {
        $files = Media::where('ref_table', 'agenda')
            ->where('ref_id', $agendaId)
            ->get();

        foreach ($files as $file) {
            // Semua file disimpan di folder yang sama
            Storage::disk('public')->delete('media/agenda/' . $file->file_name);
            $file->delete();
        }
    }

    /**
     * Delete file individual
     */
    public function deleteFile(string $agendaId, string $fileId)
    {
        try {
            DB::beginTransaction();

            $file = Media::where('media_id', $fileId)
                ->where('ref_table', 'agenda')
                ->where('ref_id', $agendaId)
                ->firstOrFail();

            // Semua file disimpan di folder yang sama
            Storage::disk('public')->delete('media/agenda/' . $file->file_name);

            $file->delete();

            DB::commit();

            return redirect()->back()->with('success', 'File berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }
}
