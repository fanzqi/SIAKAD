<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->delete();

        $users = [
            // === AKADEMIK ===
            [
                'name' => 'Admin Akademik',
                'username' => 'akademik',
                'password' => Hash::make('password'),
                'role' => 'akademik'
            ],

            // === WAREK I ===
            [
                'name' => 'Prof. Dr. Ir. Hari Widodo, M.Sc.',
                'username' => 'warek1',
                'password' => Hash::make('password'),
                'role' => 'warek1'
            ],

            // === DEKAN FAKULTAS SAINS TEKNOLOGI DAN INDUSTRI ===
            [
                'name' => 'Dekan FSTI',
                'username' => 'dekan_fsti',
                'password' => Hash::make('password'),
                'role' => 'dekan'
            ],

            // === DEKAN FAKULTAS EKONOMI DAN BISNIS ===
            [
                'name' => 'Dekan FEB',
                'username' => 'dekan_feb',
                'password' => Hash::make('password'),
                'role' => 'dekan'
            ],

            // === KAPRODI SISTEM DAN TEKNOLOGI INFORMASI ===
            [
                'name' => 'Dr. Ahmad Fauzi, S.Kom., M.Kom.',
                'username' => 'kaprodi_sti',
                'password' => Hash::make('password'),
                'role' => 'kaprodi'
            ],

            // === KAPRODI REKAYASA PERANGKAT LUNAK ===
            [
                'name' => 'Dr. Siti Aminah, S.T., M.T.',
                'username' => 'kaprodi_rpl',
                'password' => Hash::make('password'),
                'role' => 'kaprodi'
            ],

            // === KAPRODI MANAJEMEN ===
            [
                'name' => 'Dr. Budi Santoso, S.E., M.M.',
                'username' => 'kaprodi_manajemen',
                'password' => Hash::make('password'),
                'role' => 'kaprodi'
            ],

            // === KAPRODI AKUNTANSI ===
            [
                'name' => 'Dr. Dewi Lestari, S.E., M.Ak.',
                'username' => 'kaprodi_akuntansi',
                'password' => Hash::make('password'),
                'role' => 'kaprodi'
            ],

            // === DOSEN ===
            [
                'name' => 'Dr. Ir. Rina Susanti, M.M.',
                'username' => 'dosen_rina',
                'password' => Hash::make('password'),
                'role' => 'dosen'
            ],

            [
                'name' => 'Dosen Pengajar',
                'username' => 'dosen',
                'password' => Hash::make('password'),
                'role' => 'dosen'
            ],

            // === MAHASISWA ===
            // Mahasiswa Fakultas Sains Teknologi dan Industri - Prodi Sistem dan Teknologi Informasi
            [
                'name' => 'Budi Santoso',
                'username' => '23010001',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa'
            ],
            [
                'name' => 'Siti Nurhaliza',
                'username' => '23010002',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa'
            ],

            // Mahasiswa Fakultas Sains Teknologi dan Industri - Prodi Rekayasa Perangkat Lunak
            [
                'name' => 'Andi Pratama',
                'username' => '23020001',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa'
            ],
            [
                'name' => 'Rina Fitriani',
                'username' => '23020002',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa'
            ],

            // Mahasiswa Fakultas Ekonomi dan Bisnis - Prodi Manajemen
            [
                'name' => 'Doni Setiawan',
                'username' => '23030001',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa'
            ],
            [
                'name' => 'Maya Sari',
                'username' => '23030002',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa'
            ],

            // Mahasiswa Fakultas Ekonomi dan Bisnis - Prodi Akuntansi
            [
                'name' => 'Rudi Hartono',
                'username' => '23040001',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa'
            ],
            [
                'name' => 'Diana Kusuma',
                'username' => '23040002',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa'
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
