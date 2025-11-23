<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateWargaDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID'); // Set locale ke Indonesia

        foreach (range(1, 100) as $index) {
            $gender = $faker->randomElement(['L', 'P']);
            $firstName = $this->generateFirstName($gender, $faker);
            $lastName = $faker->lastName;

            DB::table('warga')->insert([
                'no_ktp' => $this->generateKTP($faker),
                'nama' => $firstName . ' ' . $lastName,
                'jenis_kelamin' => $gender,
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pekerjaan' => $this->generatePekerjaan($faker),
                'telp' => $this->generatePhoneNumber($faker),
                'email' => $this->generateEmail($firstName, $lastName, $faker),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateFirstName($gender, $faker)
    {
        if ($gender === 'L') {
            return $faker->randomElement([
                'Ahmad', 'Budi', 'Cahyo', 'Dedi', 'Eko', 'Fajar', 'Gunawan', 'Hadi', 'Irfan', 'Joko',
                'Kurniawan', 'Lukman', 'Mulyadi', 'Nugroho', 'Rizki', 'Surya', 'Tri', 'Umar', 'Wahyu', 'Yoga'
            ]);
        } else {
            return $faker->randomElement([
                'Ani', 'Bunga', 'Citra', 'Dewi', 'Eka', 'Fitri', 'Gita', 'Hani', 'Intan', 'Juli',
                'Kartika', 'Lestari', 'Maya', 'Nina', 'Putri', 'Rini', 'Sari', 'Tuti', 'Wati', 'Yuni'
            ]);
        }
    }

    private function generateKTP($faker)
    {
        
        $baseNumber = '32';
        $randomDistrict = str_pad($faker->numberBetween(1, 99), 4, '0', STR_PAD_LEFT);
        $birthDate = str_pad($faker->numberBetween(1, 31), 2, '0', STR_PAD_LEFT);
        $birthMonth = str_pad($faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT);
        $birthYear = str_pad($faker->numberBetween(70, 99), 2, '0', STR_PAD_LEFT);
        $randomUnique = str_pad($faker->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);

        return $baseNumber . $randomDistrict . $birthDate . $birthMonth . $birthYear . $randomUnique;
    }

    private function generatePekerjaan($faker)
    {
        $pekerjaan = [
            'PNS', 'Guru', 'Dosen', 'Dokter', 'Perawat', 'Bidan',
            'Wiraswasta', 'Pedagang', 'Karyawan Swasta', 'Buruh',
            'Petani', 'Nelayan', 'Sopir', 'TNI', 'Polri', 'Pensiunan',
            'Ibu Rumah Tangga', 'Pelajar', 'Mahasiswa', 'Freelancer',
            'Programmer', 'Desainer', 'Akuntan', 'Kasir', 'Satpam',
            'Tukang Kayu', 'Tukang Batu', 'Penjahit', 'Koki', 'Pelayan'
        ];

        return $faker->randomElement($pekerjaan);
    }

    private function generatePhoneNumber($faker)
    {
        $prefixes = ['0812', '0813', '0814', '0815', '0816', '0817', '0818', '0819', '0852', '0853', '0855', '0856', '0857', '0858', '0877', '0878', '0895', '0896', '0897', '0898'];
        $prefix = $faker->randomElement($prefixes);
        $suffix = str_pad($faker->numberBetween(1000000, 9999999), 7, '0', STR_PAD_LEFT);

        return $prefix . $suffix;
    }

    private function generateEmail($firstName, $lastName, $faker)
    {
        $namaClean = strtolower(str_replace(' ', '', $firstName . $lastName));
        $domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'ymail.com'];
        $domain = $faker->randomElement($domains);

        return $namaClean . $faker->numberBetween(1, 999) . '@' . $domain;
    }
}
