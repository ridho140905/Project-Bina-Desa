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
