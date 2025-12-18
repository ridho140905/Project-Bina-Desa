<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profil;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Warga;
use App\Models\KategoriBerita;
use App\Models\Media;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()){
            return redirect()->route('auth.index');
        }

        // Data Statistik Utama
        $totalProfil = Profil::count();
        $totalAgenda = Agenda::count();
        $totalBerita = Berita::count();
        $totalGaleri = Galeri::count();
        $totalWarga = warga::count();
        $totalKategoriBerita = KategoriBerita::count();

        // Hitung total semua media
        $totalMedia = Media::count();

        // Agenda yang sedang berlangsung
        $agendaBerlangsung = Agenda::where('tanggal_mulai', '<=', Carbon::now())
            ->where('tanggal_selesai', '>=', Carbon::now())
            ->count();

        // Agenda akan datang (7 hari ke depan)
        $agendaAkanDatang = Agenda::where('tanggal_mulai', '>', Carbon::now())
            ->where('tanggal_mulai', '<=', Carbon::now()->addDays(7))
            ->count();

        // Berita terbit hari ini
        $beritaHariIni = Berita::whereDate('created_at', Carbon::today())
            ->count();

        // Data Terbaru untuk Dashboard (5 data terbaru)
        $profilTerbaru = Profil::latest()
            ->take(5)
            ->get();

        $agendaTerbaru = Agenda::where(function($query) {
                $query->where('tanggal_selesai', '>=', Carbon::now())
                    ->orWhere('tanggal_mulai', '>=', Carbon::now()->subDays(30));
            })
            ->latest()
            ->take(5)
            ->get();

        // Data Berita Terbaru (5 terbaru)
        $beritaTerbaru = Berita::with('kategori')
            ->latest()
            ->take(5)
            ->get();

        // Data Kategori Berita Terbaru (5 terbaru)
        $kategoriBeritaTerbaru = KategoriBerita::withCount('berita')
            ->latest()
            ->take(5)
            ->get();

        $galeriTerbaru = Galeri::latest()
            ->take(4)
            ->get()
            ->map(function($galeri) {
                // Ambil foto utama dari media jika ada
                $fotoUtama = Media::where('ref_table', 'galeri')
                    ->where('ref_id', $galeri->galeri_id)
                    ->where('sort_order', 1)
                    ->first();

                $galeri->foto_utama_url = $fotoUtama
                    ? asset('storage/media/galeri/' . $fotoUtama->file_name)
                    : asset('images/default-gallery.png');

                // Hitung jumlah foto di galeri ini
                $galeri->jumlah_foto = Media::where('ref_table', 'galeri')
                    ->where('ref_id', $galeri->galeri_id)
                    ->count();

                return $galeri;
            });

        // Data untuk slideshow - ambil 5 gambar dari galeri terbaru
        $slideshowImages = [];
        foreach ($galeriTerbaru as $galeri) {
            if (isset($galeri->foto_utama_url)) {
                $slideshowImages[] = [
                    'url' => $galeri->foto_utama_url,
                    'title' => $galeri->judul,
                    'description' => $galeri->deskripsi
                ];
            }
        }

        // Jika tidak ada gambar di galeri, gunakan gambar default
        if (empty($slideshowImages)) {
            $slideshowImages = [
                [
                    'url' => 'https://images.unsplash.com/photo-1579033014042-5c7b42c525a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                    'title' => 'Keindahan Desa Indonesia',
                    'description' => 'Potret kehidupan masyarakat desa yang harmonis'
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                    'title' => 'Pertanian Desa',
                    'description' => 'Kegiatan pertanian sebagai tulang punggung ekonomi desa'
                ]
            ];
        }

        // Data statistik per provinsi
        $profilPerProvinsi = Profil::selectRaw('provinsi, COUNT(*) as total')
            ->groupBy('provinsi')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        return view('pages.dashboard', compact(
            // Statistik
            'totalProfil',
            'totalAgenda',
            'totalBerita',
            'totalGaleri',
            'totalWarga',
            'totalKategoriBerita',
            'totalMedia',
            'agendaBerlangsung',
            'agendaAkanDatang',
            'beritaHariIni',

            // Data Terbaru
            'profilTerbaru',
            'agendaTerbaru',
            'beritaTerbaru',
            'kategoriBeritaTerbaru',
            'galeriTerbaru',

            // Slideshow
            'slideshowImages',

            // Chart Data
            'profilPerProvinsi'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
