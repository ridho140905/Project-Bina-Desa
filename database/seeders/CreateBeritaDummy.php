<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateBeritaDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $kategoriIds = DB::table('kategori_berita')->pluck('kategori_id');

        foreach (range(1, 100) as $index) {
            $judul = $this->generateIndonesianTitle($faker);
            $kategoriId = $faker->randomElement($kategoriIds);
            $status = $faker->randomElement(['draft', 'terbit']);

            DB::table('berita')->insert([
                'kategori_id' => $kategoriId,
                'judul' => $judul,
                'slug' => Str::slug($judul) . '-' . Str::random(5),
                'isi_html' => $this->generateIndonesianContent($faker),
                'penulis' => $faker->name,
                'cover_foto' => $faker->randomElement([null, 'cover-' . $faker->word . '.jpg']),
                'status' => $status,
                'terbit_at' => $status === 'terbit' ? $faker->dateTimeBetween('-1 year', 'now') : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateIndonesianTitle($faker)
    {
        $titles = [
            // Teknologi
            'Perkembangan Terbaru Teknologi AI di Indonesia',
            'Inovasi Blockchain untuk Sektor Keuangan Digital',
            'Cloud Computing: Masa Depan Infrastruktur IT',
            'Cybersecurity dan Perlindungan Data Pribadi',
            'Startup Teknologi yang Berpotensi Unicorn',
            'Digital Transformation di Perusahaan Tradisional',
            'IoT: Revolusi Perangkat Terkoneksi Internet',
            '5G dan Dampaknya terhadap Kecepatan Internet',
            'Big Data Analytics untuk Bisnis yang Lebih Cerdas',
            'VR dan AR: Masa Depan Pengalaman Digital',

            // Politik
            'Kebijakan Baru Pemerintah untuk Sektor Pendidikan',
            'Reformasi Birokrasi Menuju Pelayanan Prima',
            'Pemilu 2024: Persiapan dan Tantangan',
            'Hubungan Diplomasi Indonesia dengan Negara Tetangga',
            'Kebijakan Fiskal untuk Stimulus Ekonomi',
            'Transparansi Anggaran dalam Pemerintahan',
            'Otonomi Daerah dan Pembangunan Regional',
            'Partai Politik dan Dinamika Koalisi',
            'Kebijakan Luar Negeri di Era Digital',
            'Penegakan Hukum dan Pemberantasan Korupsi',

            // Ekonomi
            'Pertumbuhan Ekonomi Nasional Triwulan Terakhir',
            'Strategi Pengembangan UMKM di Era Digital',
            'Pasar Modal: Peluang dan Tantangan Investor',
            'Fintech Revolution dalam Sistem Keuangan',
            'Inflasi dan Dampaknya terhadap Daya Beli',
            'Investasi Asing Langsung di Indonesia',
            'Ekonomi Kreatif: Sektor Potensial Masa Depan',
            'Perdagangan Internasional dan Ekspor-Impor',
            'Digital Banking: Transformasi Perbankan',
            'Sektor Riil dan Pemulihan Pasca Pandemi',

            // Olahraga
            'Timnas Indonesia Sukses Raih Kemenangan Penting',
            'Prestasi Atlet Bulu Tangkis di Kancah Internasional',
            'Persiapan Timnas Menuju Piala Dunia',
            'E-Sports: Olahraga Digital yang Semakin Populer',
            'Turnamen Sepak Bola Liga Champions Indonesia',
            'Atlet Renang Raih Medali Emas SEA Games',
            'Fitness dan Gaya Hidup Sehat Masyarakat Urban',
            'Balap Motor: Ajang Prestasi Pembalap Muda',
            'Basket Indonesia di Kompetisi Regional',
            'Olahraga Tradisional yang Tetap Eksis',

            // Kesehatan
            'Tips Menjaga Kesehatan di Musim Pancaroba',
            'Inovasi Telemedicine untuk Layanan Kesehatan',
            'Pentingnya Kesehatan Mental di Era Modern',
            'Nutrisi Seimbang untuk Keluarga Indonesia',
            'Penanganan Penyakit Menular yang Efektif',
            'Kesehatan Reproduksi dan Kesadaran Masyarakat',
            'Medical Technology: Alat Kesehatan Canggih',
            'Pengobatan Alternatif dan Tradisional',
            'Kesehatan Lingkungan dan Dampaknya',
            'Program Vaksinasi Nasional yang Sukses',

            // Pendidikan
            'Inovasi Pembelajaran Digital di Era Modern',
            'Kurikulum Merdeka: Solusi Pendidikan Masa Kini',
            'Beasiswa Internasional untuk Pelajar Indonesia',
            'Pendidikan Karakter untuk Generasi Muda',
            'Teknologi dalam Proses Belajar Mengajar',
            'Homeschooling: Alternatif Pendidikan',
            'Literasi Digital bagi Tenaga Pendidik',
            'Pendidikan Inklusif untuk Semua Kalangan',
            'Perguruan Tinggi dan Kualitas Lulusan',
            'Pendidikan Vokasi untuk Siap Kerja',

            // Hiburan
            'Konser Musik Besar Akan Digelar Akhir Pekan Ini',
            'Film Indonesia Raih Penghargaan Internasional',
            'Musik Indie: Gelombang Baru Industri Musik',
            'Stand Up Comedy dan Hiburan Kontemporer',
            'K-Drama dan Fenomena Korean Wave',
            'Festival Budaya Menarik Wisatawan Mancanegara',
            'Youtuber Lokal dengan Konten Berkualitas',
            'Anime dan Manga: Budaya Populer Jepang',
            'Podcast sebagai Media Hiburan dan Edukasi',
            'Teater Modern dengan Sentuhan Tradisional',

            // Wisata
            'Destinasi Wisata Populer yang Wajib Dikunjungi',
            'Wisata Alam: Pesona Indonesia yang Memukau',
            'Kuliner Nusantara yang Mendunia',
            'Wisata Heritage: Jejak Sejarah dan Budaya',
            'Tips Backpacking dengan Budget Terbatas',
            'Wisata Religi dan Ziarah Spiritual',
            'Resort Mewah untuk Liburan Keluarga',
            'Eco-Tourism: Wisata Ramah Lingkungan',
            'Wisata Pantai dengan Pemandangan Eksotis',
            'Adventure Tourism untuk Pencinta Tantangan',

            // Otomotif
            'Review Mobil Listrik Terbaru di Pasaran',
            'Teknologi Hybrid: Solusi Transportasi Ramah Lingkungan',
            'Modifikasi Kendaraan yang Aman dan Legal',
            'Safety Features dalam Kendaraan Modern',
            'Industri Otomotif Nasional dan Ekspor',
            'Motor Sport dengan Performa Tinggi',
            'Perawatan Kendaraan untuk Awet dan Tahan Lama',
            'Kendaraan Komersial untuk Bisnis Logistik',
            'Otomotif Klasik yang Tetap Diminati',
            'Inovasi Teknologi pada Kendaraan Masa Depan',

            // Lifestyle
            'Tren Fashion Musim Ini yang Patut Dicoba',
            'Sustainable Living: Gaya Hidup Berkelanjutan',
            'Wellness dan Self-Care untuk Keseimbangan Hidup',
            'Parenting di Era Digital yang Bijak',
            'Home Decor dengan Konsep Minimalis',
            'Work-Life Balance untuk Produktivitas',
            'Zero Waste Lifestyle yang Ramah Lingkungan',
            'Hobi dan Koleksi yang Menghasilkan',
            'Digital Detox: Melepas Ketergantungan Gadget',
            'Personal Development untuk Pengembangan Diri'
        ];

        return $faker->randomElement($titles);
    }

    private function generateIndonesianContent($faker)
    {
        $paragraphs = $faker->paragraphs(rand(4, 8));
        $content = '';

        // Intro paragraph
        $content .= "<p><strong>{$faker->sentence(15)}</strong></p>";

        foreach ($paragraphs as $paragraph) {
            $content .= "<p>{$paragraph}</p>";
        }

        // Tambahkan beberapa subjudul untuk membuat konten lebih realistis
        $subheadings = [
            "<h3>Latar Belakang dan Kondisi Saat Ini</h3>",
            "<h3>Analisis dan Dampak yang Ditimbulkan</h3>",
            "<h3>Solusi dan Rekomendasi ke Depan</h3>",
            "<h3>Kesimpulan dan Harapan</h3>"
        ];

        foreach ($subheadings as $subheading) {
            $content .= $subheading . "<p>" . $faker->paragraph(rand(3, 6)) . "</p>";
        }

        // Tambahkan quote untuk membuat konten lebih menarik
        $content .= "<blockquote><p>\"{$faker->sentence(12)}\"</p><footer>- {$faker->name}</footer></blockquote>";

        return $content;
    }
}
