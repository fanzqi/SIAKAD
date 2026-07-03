<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use App\Models\User;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        Mahasiswa::query()->delete();

        // Ambil user_id berdasarkan username (NIM)
        $userBudi = User::where('username', '23010001')->first();
        $userSiti = User::where('username', '23010002')->first();
        $userAndi = User::where('username', '23020001')->first();
        $userRina = User::where('username', '23020002')->first();
        $userDoni = User::where('username', '23030001')->first();
        $userMaya = User::where('username', '23030002')->first();
        $userRudi = User::where('username', '23040001')->first();
        $userDiana = User::where('username', '23040002')->first();

        $mahasiswa = [
            // Fakultas Sains Teknologi dan Industri - Prodi Sistem dan Teknologi Informasi (prodi_id = 1)
            [
                'nim' => '23010001',
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2004-05-10',
                'tempat_lahir' => 'Jember',
                'email' => 'budi.santoso@gmail.com',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Mastrip No. 45, Jember',
                'angkatan' => 2023,
                'status' => 'Aktif',
                'foto' => null,
                'user_id' => $userBudi ? $userBudi->id : null,
                'fakultas_id' => 1,
                'prodi_id' => 1,
                'kurikulum_id' => 1,
                'tahun_akademik_id' => 1,
                'semester_aktif_id' => 1,
                'grup_id' => null,
            ],
            [
                'nim' => '23010002',
                'nama' => 'Siti Nurhaliza',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2004-09-15',
                'tempat_lahir' => 'Lumajang',
                'email' => 'siti.nurhaliza@gmail.com',
                'telepon' => '081298765433',
                'alamat' => 'Jl. Diponegoro No. 78, Lumajang',
                'angkatan' => 2023,
                'status' => 'Aktif',
                'foto' => null,
                'user_id' => $userSiti ? $userSiti->id : null,
                'fakultas_id' => 1,
                'prodi_id' => 1,
                'kurikulum_id' => 1,
                'tahun_akademik_id' => 1,
                'semester_aktif_id' => 1,
                'grup_id' => null,
            ],

            // Fakultas Sains Teknologi dan Industri - Prodi Rekayasa Perangkat Lunak (prodi_id = 2)
            [
                'nim' => '23020001',
                'nama' => 'Andi Pratama',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2004-03-20',
                'tempat_lahir' => 'Surabaya',
                'email' => 'andi.pratama@gmail.com',
                'telepon' => '081234567892',
                'alamat' => 'Jl. Raya Darmo No. 12, Surabaya',
                'angkatan' => 2023,
                'status' => 'Aktif',
                'foto' => null,
                'user_id' => $userAndi ? $userAndi->id : null,
                'fakultas_id' => 1,
                'prodi_id' => 2,
                'kurikulum_id' => 1,
                'tahun_akademik_id' => 1,
                'semester_aktif_id' => 1,
                'grup_id' => null,
            ],
            [
                'nim' => '23020002',
                'nama' => 'Rina Fitriani',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2004-07-08',
                'tempat_lahir' => 'Malang',
                'email' => 'rina.fitriani@gmail.com',
                'telepon' => '081298765434',
                'alamat' => 'Jl. Soekarno Hatta No. 34, Malang',
                'angkatan' => 2023,
                'status' => 'Aktif',
                'foto' => null,
                'user_id' => $userRina ? $userRina->id : null,
                'fakultas_id' => 1,
                'prodi_id' => 2,
                'kurikulum_id' => 1,
                'tahun_akademik_id' => 1,
                'semester_aktif_id' => 1,
                'grup_id' => null,
            ],

            // Fakultas Ekonomi dan Bisnis - Prodi Manajemen (prodi_id = 3)
            [
                'nim' => '23030001',
                'nama' => 'Doni Setiawan',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2004-11-25',
                'tempat_lahir' => 'Jember',
                'email' => 'doni.setiawan@gmail.com',
                'telepon' => '081234567893',
                'alamat' => 'Jl. Gajah Mada No. 56, Jember',
                'angkatan' => 2023,
                'status' => 'Aktif',
                'foto' => null,
                'user_id' => $userDoni ? $userDoni->id : null,
                'fakultas_id' => 2,
                'prodi_id' => 3,
                'kurikulum_id' => 1,
                'tahun_akademik_id' => 1,
                'semester_aktif_id' => 1,
                'grup_id' => null,
            ],
            [
                'nim' => '23030002',
                'nama' => 'Maya Sari',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2004-02-14',
                'tempat_lahir' => 'Bondowoso',
                'email' => 'maya.sari@gmail.com',
                'telepon' => '081298765435',
                'alamat' => 'Jl. Ahmad Yani No. 89, Bondowoso',
                'angkatan' => 2023,
                'status' => 'Aktif',
                'foto' => null,
                'user_id' => $userMaya ? $userMaya->id : null,
                'fakultas_id' => 2,
                'prodi_id' => 3,
                'kurikulum_id' => 1,
                'tahun_akademik_id' => 1,
                'semester_aktif_id' => 1,
                'grup_id' => null,
            ],

            // Fakultas Ekonomi dan Bisnis - Prodi Akuntansi (prodi_id = 4)
            [
                'nim' => '23040001',
                'nama' => 'Rudi Hartono',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2004-06-30',
                'tempat_lahir' => 'Surabaya',
                'email' => 'rudi.hartono@gmail.com',
                'telepon' => '081234567894',
                'alamat' => 'Jl. Basuki Rahmat No. 67, Surabaya',
                'angkatan' => 2023,
                'status' => 'Aktif',
                'foto' => null,
                'user_id' => $userRudi ? $userRudi->id : null,
                'fakultas_id' => 2,
                'prodi_id' => 4,
                'kurikulum_id' => 1,
                'tahun_akademik_id' => 1,
                'semester_aktif_id' => 1,
                'grup_id' => null,
            ],
            [
                'nim' => '23040002',
                'nama' => 'Diana Kusuma',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2004-10-05',
                'tempat_lahir' => 'Malang',
                'email' => 'diana.kusuma@gmail.com',
                'telepon' => '081298765436',
                'alamat' => 'Jl. Pattimura No. 23, Malang',
                'angkatan' => 2023,
                'status' => 'Aktif',
                'foto' => null,
                'user_id' => $userDiana ? $userDiana->id : null,
                'fakultas_id' => 2,
                'prodi_id' => 4,
                'kurikulum_id' => 1,
                'tahun_akademik_id' => 1,
                'semester_aktif_id' => 1,
                'grup_id' => null,
            ],
        ];

        foreach ($mahasiswa as $data) {
            Mahasiswa::create($data);
        }
    }
}