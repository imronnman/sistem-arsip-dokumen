<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Users (Akun Pengujian)
        $users = [
            [
                'name'       => 'Administrator',
                'email'      => 'admin@arsip.com',
                'password'   => password_hash('password123', PASSWORD_BCRYPT),
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'name'       => 'Reviewer / Penguji',
                'email'      => 'reviewer@arsip.com',
                'password'   => password_hash('password123', PASSWORD_BCRYPT),
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ];
        $this->db->table('users')->insertBatch($users);

        // 2. Seed Categories
        $categories = [
            [
                'name'        => 'Surat Masuk',
                'description' => 'Dokumen korespondensi surat masuk eksternal.',
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ],
            [
                'name'        => 'Dokumen Keuangan',
                'description' => 'Kwitansi, invoice, dan laporan kas.',
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ],
            [
                'name'        => 'Legalitas & Perizinan',
                'description' => 'Akta pendirian, MoU, dan izin usaha.',
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ],
        ];
        $this->db->table('categories')->insertBatch($categories);
    }
}
