<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        Dosen::query()->delete();

        // Dosen untuk Fakultas Sains Teknologi dan Industri (fakultas_id = 1)
        Dosen::create([
            'nidn' => '0011223344',
            'nama' => 'Dr. Ahmad Fauzi, S.Kom., M.Kom.',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jember',
            'tanggal_lahir' => '1980-01-01',
            'alamat' => 'Jl. Mastrip No. 123, Jember',
            'email' => 'ahmad.fauzi@itsm.ac.id',
            'telepon' => '081234567890',
            'status' => 'Aktif',
            'foto' => null,
            'fakultas_id' => 1,
            'program_studi_id' => 1, // Sistem dan Teknologi Informasi
        ]);

        Dosen::create([
            'nidn' => '0099887766',
            'nama' => 'Dr. Siti Aminah, S.T., M.T.',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Bondowoso',
            'tanggal_lahir' => '1985-03-12',
            'alamat' => 'Jl. Diponegoro No. 45, Bondowoso',
            'email' => 'siti.aminah@itsm.ac.id',
            'telepon' => '081298765432',
            'status' => 'Aktif',
            'foto' => null,
            'fakultas_id' => 1,
            'program_studi_id' => 2, // Rekayasa Perangkat Lunak
        ]);

        // Dosen untuk Fakultas Ekonomi dan Bisnis (fakultas_id = 2)
        Dosen::create([
            'nidn' => '0033557799',
            'nama' => 'Dr. Budi Santoso, S.E., M.M.',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1978-05-20',
            'alamat' => 'Jl. Raya Darmo No. 78, Surabaya',
            'email' => 'budi.santoso@itsm.ac.id',
            'telepon' => '081345678901',
            'status' => 'Aktif',
            'foto' => null,
            'fakultas_id' => 2,
            'program_studi_id' => 3, // Manajemen
        ]);

        Dosen::create([
            'nidn' => '0066884422',
            'nama' => 'Dr. Dewi Lestari, S.E., M.Ak.',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Malang',
            'tanggal_lahir' => '1982-11-08',
            'alamat' => 'Jl. Soekarno Hatta No. 56, Malang',
            'email' => 'dewi.lestari@itsm.ac.id',
            'telepon' => '081356789012',
            'status' => 'Aktif',
            'foto' => null,
            'fakultas_id' => 2,
            'program_studi_id' => 4, // Akuntansi
        ]);

        // Tambahan dosen untuk kebutuhan jabatan struktural
        Dosen::create([
            'nidn' => '0077889933',
            'nama' => 'Prof. Dr. Ir. Hari Widodo, M.Sc.',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1970-08-15',
            'alamat' => 'Jl. Gatot Subroto No. 12, Jakarta',
            'email' => 'hari.widodo@itsm.ac.id',
            'telepon' => '081367890123',
            'status' => 'Aktif',
            'foto' => null,
            'fakultas_id' => 1,
            'program_studi_id' => null,
        ]);

        Dosen::create([
            'nidn' => '0055661133',
            'nama' => 'Dr. Ir. Rina Susanti, M.M.',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1975-03-25',
            'alamat' => 'Jl. Padjajaran No. 89, Bandung',
            'email' => 'rina.susanti@itsm.ac.id',
            'telepon' => '081378901234',
            'status' => 'Aktif',
            'foto' => null,
            'fakultas_id' => 2,
            'program_studi_id' => null,
        ]);
    }
}
