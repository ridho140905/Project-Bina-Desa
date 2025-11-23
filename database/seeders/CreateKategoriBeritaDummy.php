<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateKategoriBeritaDummy extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $kategoriData = [
            // Kategori utama (10 data original)
            [
                'nama' => 'Teknologi',
                'deskripsi' => 'Berita terkini seputar perkembangan teknologi, gadget, dan inovasi digital'
            ],
            [
                'nama' => 'Politik',
                'deskripsi' => 'Informasi politik dalam dan luar negeri, kebijakan pemerintah, dan isu politik'
            ],
            [
                'nama' => 'Ekonomi',
                'deskripsi' => 'Berita ekonomi, bisnis, keuangan, pasar modal, dan perkembangan industri'
            ],
            [
                'nama' => 'Olahraga',
                'deskripsi' => 'Update terbaru dunia olahraga, pertandingan, atlet, dan kompetisi'
            ],
            [
                'nama' => 'Kesehatan',
                'deskripsi' => 'Informasi kesehatan, medis, tips hidup sehat, dan perkembangan penelitian'
            ],
            [
                'nama' => 'Pendidikan',
                'deskripsi' => 'Berita pendidikan, sekolah, universitas, beasiswa, dan metode pembelajaran'
            ],
            [
                'nama' => 'Hiburan',
                'deskripsi' => 'Kabar terbaru selebriti, film, musik, seni, dan entertainment'
            ],
            [
                'nama' => 'Wisata',
                'deskripsi' => 'Destinasi travel, tips liburan, hotel, kuliner, dan pengalaman traveling'
            ],
            [
                'nama' => 'Otomotif',
                'deskripsi' => 'Berita otomotif, mobil, motor, review kendaraan, dan teknologi transportasi'
            ],
            [
                'nama' => 'Lifestyle',
                'deskripsi' => 'Gaya hidup, fashion, kecantikan, hubungan, dan tren terkini'
            ]
        ];

        // Tambahkan 90 kategori tambahan dengan variasi
        $additionalCategories = [
            'Teknologi' => [
                'AI & Machine Learning', 'Blockchain & Crypto', 'Internet of Things', 'Cloud Computing',
                'Cybersecurity', 'Software Development', 'Hardware Review', 'Startup & Inovasi',
                'Digital Marketing', 'Big Data & Analytics'
            ],
            'Politik' => [
                'Pemerintahan Daerah', 'Kebijakan Publik', 'Pemilu & Demokrasi', 'Hubungan Internasional',
                'Partai Politik', 'Reformasi Birokrasi', 'Hukum & Perundangan', 'Otonomi Daerah',
                'Transparansi Publik', 'Kebijakan Sosial'
            ],
            'Ekonomi' => [
                'UMKM & Kewirausahaan', 'Pasar Modal', 'Perbankan & Fintech', 'Investasi Asing',
                'Ekonomi Kreatif', 'Perdagangan Internasional', 'Inflasi & Moneter', 'Pajak & Bea Cukai',
                'Ekonomi Digital', 'Sektor Riil'
            ],
            'Olahraga' => [
                'Sepak Bola Nasional', 'Bulu Tangkis', 'Basket', 'Renang & Akuatik', 'Atletik & Lari',
                'E-Sports', 'Olahraga Ekstrem', 'Fitness & Gym', 'Sepeda & Cycling', 'Martial Arts'
            ],
            'Kesehatan' => [
                'Kesehatan Mental', 'Nutrisi & Diet', 'Penyakit Menular', 'Kesehatan Anak',
                'Kesehatan Lansia', 'Pengobatan Alternatif', 'Kesehatan Reproduksi', 'Kesehatan Lingkungan',
                'Telemedicine', 'Medical Technology'
            ],
            'Pendidikan' => [
                'Pendidikan Karakter', 'Teknologi Pendidikan', 'Pendidikan Inklusif', 'Beasiswa Internasional',
                'Kurikulum Merdeka', 'Pendidikan Vokasi', 'Homeschooling', 'Pendidikan Non-Formal',
                'Literasi Digital', 'Pendidikan Keluarga'
            ],
            'Hiburan' => [
                'Film Indonesia', 'Musik Indie', 'Stand Up Comedy', 'Teater & Seni Pertunjukan',
                'K-Drama & K-Pop', 'Anime & Manga', 'Podcast & Radio', 'Festival & Konser',
                'Youtuber & Content Creator', 'Game & Gaming'
            ],
            'Wisata' => [
                'Wisata Alam', 'Wisata Kuliner', 'Wisata Heritage', 'Wisata Religi',
                'Wisata Adventure', 'Wisata Keluarga', 'Wisata Edukasi', 'Wisata Pantai',
                'Wisata Gunung', 'Wisata Urban'
            ],
            'Otomotif' => [
                'Mobil Listrik', 'Modifikasi Kendaraan', 'Safety Driving', 'Otomotif Sport',
                'Kendaraan Komersial', 'Teknologi Hybrid', 'Aftermarket Parts', 'Otomotif Klasik',
                'Racing & Balap', 'Car Review'
            ],
            'Lifestyle' => [
                'Sustainable Living', 'Minimalism', 'Wellness & Self Care', 'Parenting & Keluarga',
                'Home Decor', 'Personal Development', 'Zero Waste', 'Digital Detox',
                'Work Life Balance', 'Hobi & Koleksi'
            ]
        ];

        // Generate 90 kategori tambahan
        $counter = 0;
        foreach ($additionalCategories as $mainCategory => $subCategories) {
            foreach ($subCategories as $subCategory) {
                $kategoriData[] = [
                    'nama' => $subCategory,
                    'deskripsi' => $faker->sentence(10)
                ];
                $counter++;

                // Stop ketika sudah mencapai 100 total
                if (count($kategoriData) >= 100) {
                    break 2;
                }
            }
        }

        // Insert semua data ke database
        foreach ($kategoriData as $kategori) {
            DB::table('kategori_berita')->insert([
                'nama' => $kategori['nama'],
                'slug' => Str::slug($kategori['nama']),
                'deskripsi' => $kategori['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
