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
        $faker = Factory::create('id_ID'); // Pastikan 'id_ID'

        $kategoriIds = DB::table('kategori_berita')->pluck('kategori_id');

        foreach (range(1, 50) as $index) {
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
            'Perkembangan Terbaru Teknologi AI di Indonesia',
            'Kebijakan Baru Pemerintah untuk Sektor Pendidikan',
            'Pertumbuhan Ekonomi Nasional Triwulan Terakhir',
            'Timnas Indonesia Sukses Raih Kemenangan Penting',
            'Tips Menjaga Kesehatan di Musim Pancaroba',
            'Inovasi Pembelajaran Digital di Era Modern',
            'Konser Musik Besar Akan Digelar Akhir Pekan Ini',
            'Destinasi Wisata Populer yang Wajib Dikunjungi',
            'Review Mobil Listrik Terbaru di Pasaran',
            'Tren Fashion Musim Ini yang Patut Dicoba'
        ];

        return $faker->randomElement($titles) . ' ' . $faker->sentence(3);
    }

    private function generateIndonesianContent($faker)
    {
        $paragraphs = $faker->paragraphs(rand(3, 6));
        $content = '';

        foreach ($paragraphs as $paragraph) {
            $content .= "<p>{$paragraph}</p>";
        }

        // Tambahkan beberapa subjudul untuk membuat konten lebih realistis
        $subheadings = [
            "<h3>Latar Belakang</h3>",
            "<h3>Dampak dan Implikasi</h3>",
            "<h3>Solusi dan Rekomendasi</h3>"
        ];

        foreach ($subheadings as $subheading) {
            $content .= $subheading . "<p>" . $faker->paragraph() . "</p>";
        }

        return $content;
    }
}
