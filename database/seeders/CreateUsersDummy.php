<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateUsersDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        DB::table('users')->truncate();

        foreach (range(1, 100) as $index) {
            $firstName = $this->generateFirstName($faker);
            $lastName = $this->generateLastName($faker);
            $fullName = $firstName . ' ' . $lastName;

            // Email yang guaranteed unique dengan format yang konsisten
            $email = 'user' . $index . '@example.com';

            // Tentukan role berdasarkan index
            $role = $this->determineRole($index);

            DB::table('users')->insert([
                'name' => $fullName,
                'email' => $email,
                'email_verified_at' => $faker->randomElement([now(), null]),
                'password' => Hash::make('password123'),
                'role' => $role, // Tambahkan kolom role
                'remember_token' => $faker->randomElement([null, \Illuminate\Support\Str::random(10)]),
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at' => now(),
            ]);
        }

        // Tambahkan beberapa user khusus dengan role tertentu
        $this->createSpecialUsers();
    }

    /**
     * Determine role based on index
     */
    private function determineRole(int $index): string
    {
        // User 1-2 sebagai Super Admin
        if ($index <= 2) {
            return 'Super Admin';
        }

        // User 3-30 sebagai Pelanggan (28 user)
        if ($index <= 30) {
            return 'Pelanggan';
        }

        // User 31-100 sebagai Mitra (70 user)
        return 'Mitra';
    }

    /**
     * Create special users with specific emails and roles
     */
    private function createSpecialUsers(): void
    {
        $specialUsers = [
            [
                'name' => 'Super Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'Super Admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pelanggan Premium',
                'email' => 'pelanggan@example.com',
                'password' => Hash::make('pelanggan123'),
                'role' => 'Pelanggan',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mitra Utama',
                'email' => 'mitra@example.com',
                'password' => Hash::make('mitra123'),
                'role' => 'Mitra',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($specialUsers as $user) {
            DB::table('users')->insert($user);
        }
    }

    /**
     * Generate first name Indonesia
     */
    private function generateFirstName($faker)
    {
        $firstNames = [
            'Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fajar', 'Gita', 'Hadi', 'Indra', 'Joko',
            'Kartika', 'Lina', 'Mega', 'Nina', 'Oki', 'Putri', 'Rina', 'Sari', 'Toni', 'Wati',
            'Yudi', 'Zainal', 'Rudi', 'Siti', 'Agus', 'Dian', 'Eka', 'Feri', 'Gina', 'Hendra',
            'Iwan', 'Juli', 'Kiki', 'Lia', 'Mila', 'Nanda', 'Oman', 'Putra', 'Rama', 'Sandi',
            'Tina', 'Udin', 'Vina', 'Wawan', 'Yuni', 'Zaki', 'Ani', 'Bayu', 'Candra', 'Dodi'
        ];

        return $faker->randomElement($firstNames);
    }

    /**
     * Generate last name Indonesia
     */
    private function generateLastName($faker)
    {
        $lastNames = [
            'Santoso', 'Wijaya', 'Pratama', 'Siregar', 'Hidayat', 'Kusuma', 'Nugroho', 'Putra', 'Sari', 'Dewanto',
            'Halim', 'Lesmana', 'Maulana', 'Purnama', 'Rahman', 'Saputra', 'Utami', 'Wibowo', 'Yulianto', 'Zulkarnain',
            'Abdullah', 'Gunawan', 'Hartono', 'Irawan', 'Jaya', 'Kurniawan', 'Lestari', 'Mulyadi', 'Natalia', 'Pangestu',
            'Ramadan', 'Setiawan', 'Tanuwijaya', 'Wicaksono', 'Yusuf', 'Zahra', 'Andrianto', 'Baskara', 'Chandra', 'Darmawan',
            'Firmansyah', 'Ginting', 'Harsono', 'Ismail', 'Jatmiko', 'Kartawi', 'Laksana', 'Mandala', 'Nugraha', 'Prabowo'
        ];

        return $faker->randomElement($lastNames);
    }
}
