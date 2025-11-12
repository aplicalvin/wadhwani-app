<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Kosongkan tabel 'users' terlebih dahulu (opsional tapi disarankan)
        $this->db->table('users')->truncate();

        // 2. Siapkan data
        $password = password_hash('password', PASSWORD_DEFAULT); // Hash password sekali saja
        $now = date('Y-m-d H:i:s'); // Untuk created_at dan updated_at

        $data = [
            [
                'name'       => 'Admin Satu', // Kita tambahkan nama default
                'email'      => 'admin1@test.com',
                'password'   => $password,
                'role'       => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Admin Dua', // Kita tambahkan nama default
                'email'      => 'admin2@test.com',
                'password'   => $password,
                'role'       => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        // 3. Masukkan data ke database menggunakan Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}