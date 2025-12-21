<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class CreateGaleriDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function up(): void
    {
        $faker = Factory::create('id_ID');

        // Data untuk galeri desa
        $kategoriGaleri = [
            'Kegiatan Desa', 'Infrastruktur', 'Alam Desa', 'Budaya Lokal',
            'Pembangunan', 'Gotong Royong', 'Acara Resmi', 'Kearifan Lokal',
            'Pertanian', 'Peternakan', 'Perikanan', 'Kerajinan Tangan',
            'Pendidikan', 'Kesehatan', 'Olahraga', 'Seni dan Budaya',
            'Wisata', 'Sejarah', 'Arsitektur Tradisional', 'Flora Fauna'
        ];

        $lokasiDesa = [
            'Desa Sukamaju', 'Desa Mekarsari', 'Desa Harapan Jaya', 'Desa Tirtasari',
            'Desa Cempaka Putih', 'Desa Bumi Ayu', 'Desa Sumber Rejo', 'Desa Margo Mulyo',
            'Desa Tanjung Sari', 'Desa Pasir Putih', 'Desa Sindang Sari', 'Desa Wangi Jaya',
            'Desa Cikarang', 'Desa Pematang', 'Desa Sidomulyo', 'Desa Tirto Asri',
            'Desa Bangun Jaya', 'Desa Suka Damai', 'Desa Tunas Harapan', 'Desa Mulya Sari'
        ];

        for ($i = 1; $i <= 100; $i++) {
            $kategori = $faker->randomElement($kategoriGaleri);
            $lokasi = $faker->randomElement($lokasiDesa);

            DB::table('galeri')->insert([
                'judul' => $this->generateJudulGaleri($kategori, $lokasi, $faker),
                'deskripsi' => $this->generateDeskripsiGaleri($kategori, $lokasi, $faker),
                'created_at' => $this->generateTanggalAcak($faker),
                'updated_at' => now(),
            ]);

            // Progress indicator
            if ($i % 10 == 0) {
                echo "Generated {$i}/100 data galeri\n";
            }
        }

        echo "Seeder galeri selesai!\n";
    }

    /**
     * Generate judul galeri
     */
    private function generateJudulGaleri($kategori, $lokasi, $faker): string
    {
        $prefix = $faker->randomElement([
            'Dokumentasi', 'Koleksi Foto', 'Album', 'Portofolio', 'Arsip Visual',
            'Galeri', 'Kumpulan Gambar', 'Rekaman Visual', 'Potret', 'Snapshot'
        ]);

        $tahun = $faker->numberBetween(2018, 2024);
        $bulan = $faker->monthName;

        $patterns = [
            "{$prefix} {$kategori} {$lokasi} {$tahun}",
            "{$kategori} di {$lokasi} - {$bulan} {$tahun}",
            "{$prefix}: {$kategori} Desa {$lokasi}",
            "Visualisasi {$kategori} {$lokasi} Tahun {$tahun}",
            "Momen {$kategori} di {$lokasi}",
        ];

        return $faker->randomElement($patterns);
    }

    /**
     * Generate deskripsi galeri
     */
    private function generateDeskripsiGaleri($kategori, $lokasi, $faker): string
    {
        $templates = [
            "Koleksi foto dokumentasi {$kategori} yang dilaksanakan di {$lokasi}. " .
            "Foto-foto ini merekam momen penting dalam kegiatan pembangunan dan kehidupan masyarakat desa.",

            "Galeri ini menampilkan berbagai aktivitas {$kategori} di wilayah {$lokasi}. " .
            "Setiap gambar memiliki cerita dan makna tersendiri bagi perkembangan desa.",

            "Album visual yang berisi rekaman kegiatan {$kategori} di {$lokasi}. " .
            "Dokumentasi ini menjadi bukti nyata kemajuan dan dinamika kehidupan desa.",

            "Portofolio foto yang mengabadikan momen-momen {$kategori} di {$lokasi}. " .
            "Galeri ini dibuat untuk menginspirasi dan memberikan gambaran nyata tentang kehidupan desa.",

            "Kumpulan gambar yang merekam perjalanan {$kategori} di desa {$lokasi}. " .
            "Setiap foto adalah cerita tentang semangat gotong royong dan kebersamaan warga.",
        ];

        $deskripsi = $faker->randomElement($templates);

        // Tambahkan detail konten galeri
        $detail = [
            "Galeri ini terdiri dari berbagai angle dan perspektif yang menarik.",
            "Foto-foto diambil oleh tim dokumentasi desa yang berdedikasi.",
            "Setiap gambar melalui proses seleksi untuk memastikan kualitas terbaik.",
            "Galeri ini akan terus diperbarui dengan foto-foto terbaru.",
            "Dokumentasi visual ini menjadi bagian dari arsip sejarah desa.",
            "Foto-foto dapat digunakan untuk keperluan publikasi dan laporan desa.",
            "Kualitas gambar dioptimalkan untuk berbagai media publikasi.",
            "Galeri ini mencakup berbagai momen dari persiapan hingga pelaksanaan.",
            "Setiap foto memiliki metadata yang mencatat waktu dan lokasi pengambilan.",
            "Dokumentasi ini menjadi referensi visual untuk perencanaan program desa.",
        ];

        $jumlahDetail = $faker->numberBetween(2, 4);
        $detailAcak = $faker->randomElements($detail, $jumlahDetail);

        $deskripsi .= "\n\n" . implode(" ", $detailAcak);

        // Tambahkan informasi copyright
        $copyright = [
            "© " . date('Y') . " Dokumentasi Desa {$lokasi}",
            "Hak Cipta: Pemerintah Desa {$lokasi}",
            "Foto: Tim Dokumentasi Desa {$lokasi}",
            "Sumber: Arsip Visual Desa {$lokasi}"
        ];

        $deskripsi .= "\n\n" . $faker->randomElement($copyright);

        return $deskripsi;
    }

    /**
     * Generate tanggal acak untuk created_at
     */
    private function generateTanggalAcak($faker)
    {
        // 70% dalam 1 tahun terakhir, 30% lebih dari 1 tahun lalu
        if ($faker->boolean(70)) {
            return $faker->dateTimeBetween('-1 year', 'now');
        } else {
            return $faker->dateTimeBetween('-3 years', '-1 year');
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->up();
    }
}
