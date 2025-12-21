<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateAgendaDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        // Data khusus desa
        $jenisAgenda = [
            'Musyawarah Desa', 'Kerja Bakti', 'Posyandu', 'Peringatan Hari Besar',
            'Penyuluhan Pertanian', 'Pelatihan UMKM', 'Rapat RT/RW', 'Kegiatan Karang Taruna',
            'Siskamling', 'Bazar Desa', 'Pengajian Umum', 'Lomba 17 Agustus',
            'Pemeriksaan Kesehatan Gratis', 'Pembagian Bantuan Sosial', 'Pembersihan Lingkungan',
            'Festival Budaya Desa', 'Rapat Koordinasi Desa', 'Penyuluhan Kesehatan',
            'Pelatihan Keterampilan', 'Donor Darah Desa', 'Penghijauan Desa',
            'Peresmian Fasilitas Desa', 'Konsultasi Hukum Gratis', 'Pasar Murah',
            'Peringatan Maulid Nabi', 'Seminar Pendidikan', 'Workshop Teknologi Tani',
            'Pertemuan Warga', 'Apel Siaga Bencana', 'Pelatihan Bela Diri'
        ];

        $penyelenggaraList = [
            'Pemerintah Desa', 'Badan Permusyawaratan Desa', 'Karang Taruna',
            'PKK Desa', 'Kelompok Tani', 'Koperasi Desa', 'RT/RW Setempat',
            'Posyandu Mawar', 'Majelis Taklim', 'Lembaga Masyarakat Desa',
            'Dusun Krajan', 'Dusun Sukamaju', 'Dusun Mekarsari',
            'Kelompok Nelayan', 'Kelompok Wanita Tani', 'TP PKK Desa',
            'BUMDes', 'Forum Masyarakat Peduli Lingkungan', 'Remaja Masjid',
            'Sanggar Seni Desa'
        ];

        $lokasiDesa = [
            'Balai Desa', 'Lapangan Desa', 'Kantor Kepala Desa', 'Aula Serbaguna Desa',
            'Masjid Al-Ikhlas', 'Mushola At-Taqwa', 'Sekolah Dasar Negeri 1',
            'Posyandu Mawar', 'Kantor RW 01', 'Kantor RW 02', 'Kantor RW 03',
            'Kebun Desa', 'Pasar Desa', 'Taman Baca Masyarakat', 'Sanggar Seni',
            'Pusat Kegiatan Belajar Masyarakat', 'Lapangan Voli', 'Pos Kamling',
            'Rumah Ketua RT', 'Tempat Pembuangan Sampah Terpadu'
        ];

        for ($i = 1; $i <= 100; $i++) {
            // Tanggal dalam 1 tahun ke depan
            $tanggalMulai = $faker->dateTimeBetween('now', '+1 year');
            $durasi = $faker->numberBetween(1, 8); // durasi 1-8 jam untuk sebagian besar agenda
            $tanggalSelesai = Carbon::instance($tanggalMulai)->addHours($durasi);

            // Untuk agenda tertentu yang berlangsung beberapa hari
            if ($faker->boolean(20)) { // 20% agenda multi-hari
                $hariTambahan = $faker->numberBetween(1, 3);
                $tanggalSelesai = Carbon::instance($tanggalMulai)->addDays($hariTambahan);
            }

            $jenis = $faker->randomElement($jenisAgenda);
            $penyelenggara = $faker->randomElement($penyelenggaraList);
            $lokasi = $faker->randomElement($lokasiDesa);

            DB::table('agenda')->insert([
                'judul' => $this->generateJudul($jenis, $faker),
                'lokasi' => $lokasi,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'penyelenggara' => $penyelenggara,
                'deskripsi' => $this->generateDeskripsiDesa($jenis, $penyelenggara, $lokasi, $faker),
                'poster_dokumen' => $this->generatePosterDesa($faker),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Progress indicator
            if ($i % 10 == 0) {
                echo "Generated {$i}/100 agenda desa\n";
            }
        }

        echo "Seeder agenda desa selesai!\n";
    }

    /**
     * Generate judul agenda desa
     */
    private function generateJudul($jenis, $faker): string
    {
        $prefix = $faker->randomElement([
            'Kegiatan', 'Acara', 'Program', 'Event', 'Aktivitas', 'Rangkaian'
        ]);

        $tema = $faker->randomElement([
            'Pemberdayaan Masyarakat', 'Peningkatan Kesejahteraan', 'Gotong Royong',
            'Kebersihan Lingkungan', 'Kesehatan Keluarga', 'Pendidikan Karakter',
            'Pengembangan Ekonomi', 'Pelestarian Budaya', 'Ketahanan Pangan',
            'Pencegahan Stunting', 'Digitalisasi Desa', 'Wisata Desa'
        ]);

        return "{$jenis} - {$tema}";
    }

    /**
     * Generate deskripsi agenda desa
     */
    private function generateDeskripsiDesa($jenis, $penyelenggara, $lokasi, $faker): string
    {
        $templates = [
            "{$jenis} ini diselenggarakan oleh {$penyelenggara} di {$lokasi}. Acara ini bertujuan untuk meningkatkan partisipasi masyarakat dalam pembangunan desa. Semua warga diharapkan dapat hadir dan berpartisipasi aktif.",

            "Dalam rangka memajukan desa, {$penyelenggara} mengadakan {$jenis} yang akan dilaksanakan di {$lokasi}. Kegiatan ini merupakan wujud nyata gotong royong warga desa.",

            "{$penyelenggara} mengundang seluruh warga untuk menghadiri {$jenis} di {$lokasi}. Acara ini penting untuk koordinasi dan sinergi pembangunan desa.",

            "Mari kita hadiri bersama {$jenis} yang diadakan oleh {$penyelenggara} di {$lokasi}. Kegiatan ini akan membahas berbagai program untuk kemajuan desa kita.",

            "{$jenis} merupakan agenda rutin desa yang diselenggarakan oleh {$penyelenggara} di {$lokasi}. Partisipasi aktif warga sangat dibutuhkan untuk kesuksesan acara ini.",
        ];

        $deskripsi = $faker->randomElement($templates);

        // Tambahkan detail acara
        $details = [
            "Acara akan dimulai dengan registrasi peserta.",
            "Peserta diharapkan datang tepat waktu.",
            "Akan disediakan konsumsi untuk peserta.",
            "Peserta akan mendapatkan sertifikat kehadiran.",
            "Tersedia tempat parkir yang memadai.",
            "Acara terbuka untuk semua warga tanpa dipungut biaya.",
            "Akan ada sesi tanya jawab dengan narasumber.",
            "Peserta diharapkan membawa alat tulis sendiri.",
            "Akan ada pembagian doorprize untuk peserta.",
            "Acara akan dilanjutkan dengan ramah tamah."
        ];

        $jumlahDetail = $faker->numberBetween(2, 5);
        $detailAcara = $faker->randomElements($details, $jumlahDetail);

        $deskripsi .= "\n\nDetail Acara:\n" . implode("\n", array_map(function($item) {
            return "• " . $item;
        }, $detailAcara));

        // Tambahkan kontak panitia
        $kontak = [
            "Untuk informasi lebih lanjut, hubungi:",
            "- Ketua Panitia: {$this->generateNama($faker)} (08{$faker->numberBetween(100000000, 999999999)})",
            "- Sekretaris: {$this->generateNama($faker)} (08{$faker->numberBetween(100000000, 999999999)})"
        ];

        $deskripsi .= "\n\n" . implode("\n", $kontak);

        return $deskripsi;
    }

    /**
     * Generate nama warga desa
     */
    private function generateNama($faker): string
    {
        $namaDepan = $faker->randomElement([
            'Sutrisno', 'Suryadi', 'Joko', 'Bambang', 'Sukiman', 'Slamet', 'Mulyadi', 'Suharto',
            'Maryati', 'Siti', 'Sri', 'Sumiati', 'Dewi', 'Rukmini', 'Sukarni', 'Kartini'
        ]);

        $namaBelakang = $faker->randomElement([
            'Santoso', 'Wijaya', 'Prabowo', 'Subagyo', 'Hadi', 'Nugroho', 'Wibowo', 'Saputra',
            'Wulandari', 'Handayani', 'Rahayu', 'Indah', 'Lestari', 'Utami', 'Sari', 'Wati'
        ]);

        return $namaDepan . ' ' . $namaBelakang;
    }

    /**
     * Generate nama file poster
     */
    private function generatePosterDesa($faker): ?string
    {
        // 60% memiliki poster, 40% tidak
        if (!$faker->boolean(60)) {
            return null;
        }

        $jenisPoster = $faker->randomElement([
            'poster', 'spanduk', 'banner', 'flyer', 'pamflet'
        ]);

        $namaFile = strtolower(str_replace(' ', '-', $jenisPoster . '-' . $faker->word() . '-' . $faker->numberBetween(1, 100)));

        return $faker->randomElement([
            "uploads/agenda/{$namaFile}.jpg",
            "uploads/agenda/{$namaFile}.png",
            "uploads/agenda/{$namaFile}.pdf",
            "public/posters/{$namaFile}.jpg",
            "storage/agenda/{$namaFile}.png"
        ]);
    }
}
