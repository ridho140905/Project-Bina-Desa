<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateProfilDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        // Hapus data existing sebelum menambahkan yang baru
        DB::table('profil')->truncate();

        foreach (range(1, 100) as $index) {
            $provinsi = $faker->randomElement(['Riau', 'Sumatera Barat', 'Sumatera Utara']);

            // Generate kabupaten berdasarkan provinsi
            $kabupaten = $this->generateKabupaten($provinsi, $faker);

            // Generate kecamatan berdasarkan kabupaten
            $kecamatan = $this->generateKecamatan($kabupaten, $faker);

            DB::table('profil')->insert([
                'nama_desa' => 'Desa ' . $faker->randomElement(['Mekar', 'Sari', 'Mulia', 'Jaya', 'Makmur', 'Sejahtera', 'Indah', 'Baru', 'Lestari', 'Damai']) .
                              ' ' . $faker->randomElement(['Abadi', 'Sentosa', 'Utama', 'Permai', 'Asri', 'Berseri', 'Gemilang', 'Cemerlang']),
                'kecamatan' => $kecamatan,
                'kabupaten' => $kabupaten,
                'provinsi' => $provinsi,
                'alamat_kantor' => 'Jl. ' . $faker->streetName . ' No.' . $faker->buildingNumber . ', ' . $kecamatan . ', ' . $kabupaten,
                'email' => 'desa' . $index . '@example.com',
                'telepon' => '08' . $faker->numerify('##########'),
                'visi' => 'Terwujudnya ' . $kecamatan . ' yang maju, mandiri, dan sejahtera melalui pemberdayaan masyarakat yang berkelanjutan.',
                'misi' => '1. Meningkatkan kualitas pelayanan publik
2. Mengembangkan potensi ekonomi lokal
3. Memperkuat infrastruktur desa
4. Meningkatkan partisipasi masyarakat dalam pembangunan
5. Mewujudkan tata kelola pemerintahan yang baik dan bersih',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Generate kabupaten berdasarkan provinsi
     */
    private function generateKabupaten($provinsi, $faker)
    {
        $kabupatenData = [
            'Riau' => ['Pekanbaru', 'Dumai', 'Siak', 'Kampar', 'Rokan Hilir', 'Bengkalis', 'Pelalawan', 'Indragiri Hulu'],
            'Sumatera Barat' => ['Padang', 'Bukittinggi', 'Payakumbuh', 'Solok', 'Agam', 'Tanah Datar', 'Lima Puluh Kota', 'Pesisir Selatan'],
            'Sumatera Utara' => ['Medan', 'Binjai', 'Pematang Siantar', 'Tebing Tinggi', 'Deli Serdang', 'Karo', 'Simalungun', 'Langkat']
        ];

        return $faker->randomElement($kabupatenData[$provinsi]);
    }

    /**
     * Generate kecamatan berdasarkan kabupaten
     */
    private function generateKecamatan($kabupaten, $faker)
    {
        $kecamatanData = [
            'Pekanbaru' => ['Sukajadi', 'Payung Sekaki', 'Rumbai', 'Tampan', 'Marpoyan Damai', 'Binawidya', 'Tenayan Raya'],
            'Dumai' => ['Dumai Barat', 'Dumai Timur', 'Dumai Kota', 'Dumai Selatan', 'Bukit Kapur'],
            'Siak' => ['Siak', 'Sungai Apit', 'Minas', 'Tualang', 'Dayun', 'Kerinci Kanan'],
            'Kampar' => ['Bangkinang', 'Kampar', 'Rumbio Jaya', 'Tapung', 'XIII Koto Kampar'],
            'Rokan Hilir' => ['Bagan Siapi-api', 'Kubu', 'Bangko', 'Sinaboi', 'Batu Hampar'],
            'Bengkalis' => ['Bengkalis', 'Bantan', 'Bukit Batu', 'Rupat', 'Rupat Utara'],
            'Pelalawan' => ['Pangkalan Kerinci', 'Langgam', 'Pangkalan Kuras', 'Bunut', 'Kerumutan'],
            'Indragiri Hulu' => ['Rengat', 'Kuala Cenaku', 'Kelayang', 'Lirik', 'Sungai Lala'],

            'Padang' => ['Padang Barat', 'Padang Utara', 'Padang Timur', 'Padang Selatan', 'Koto Tangah', 'Lubuk Begalung', 'Lubuk Kilangan'],
            'Bukittinggi' => ['Guguk Panjang', 'Mandiangin Koto Selayan', 'Aur Birugo Tigo Baleh'],
            'Payakumbuh' => ['Payakumbuh Barat', 'Payakumbuh Selatan', 'Payakumbuh Timur', 'Payakumbuh Utara'],
            'Solok' => ['Solok Selatan', 'Solok Utara', 'Lembah Gumanti', 'Pantai Cermin', 'Lembang Jaya'],
            'Agam' => ['Lubuk Basung', 'Tilatang Kamang', 'Palembayan', 'Tanjung Mutiara', 'Baso'],
            'Tanah Datar' => ['Batusangkar', 'Lima Kaum', 'Rambatan', 'Sungai Tarab', 'Salimpaung'],
            'Lima Puluh Kota' => ['Sarilamak', 'Harau', 'Pangkalan Koto Baru', 'Suliki', 'Guguak'],
            'Pesisir Selatan' => ['Painan', 'Lengayang', 'Batang Kapas', 'IV Jurai', 'Linggo Sari Baganti'],

            'Medan' => ['Medan Perjuangan', 'Medan Timur', 'Medan Barat', 'Medan Selayang', 'Medan Tembung', 'Medan Denai', 'Medan Area'],
            'Binjai' => ['Binjai Barat', 'Binjai Kota', 'Binjai Selatan', 'Binjai Timur', 'Binjai Utara'],
            'Pematang Siantar' => ['Siantar Barat', 'Siantar Timur', 'Siantar Utara', 'Siantar Selatan', 'Siantar Marihat'],
            'Tebing Tinggi' => ['Tebing Tinggi Kota', 'Tebing Tinggi Lama', 'Rambutan', 'Bajenis', 'Padang Hilir'],
            'Deli Serdang' => ['Lubuk Pakam', 'Percut Sei Tuan', 'Pantai Labu', 'Beringin', 'Galang'],
            'Karo' => ['Kabanjahe', 'Berastagi', 'Tigapanah', 'Merek', 'Barusjahe'],
            'Simalungun' => ['Pematang Siantar', 'Simalungun', 'Dolok Pardamean', 'Raya', 'Bandar'],
            'Langkat' => ['Stabat', 'Binjai', 'Wampu', 'Secanggang', 'Hinai']
        ];

        // Pastikan mengembalikan string, bukan array
        if (isset($kecamatanData[$kabupaten])) {
            return $faker->randomElement($kecamatanData[$kabupaten]);
        }

        // Fallback ke kecamatan default jika kabupaten tidak ditemukan
        $defaultKecamatan = ['Kecamatan Pusat', 'Kecamatan Utara', 'Kecamatan Selatan', 'Kecamatan Timur', 'Kecamatan Barat'];
        return $faker->randomElement($defaultKecamatan);
    }
}
