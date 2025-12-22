<?php

namespace App\Http\Controllers;

use App\Models\Mata_kuliah;
use App\Models\Ruang;
use App\Models\jadwalkuliah;
use App\Models\TahunAkademik;

class SmartJadwalController extends Controller
{
    private $hariPreferensi = [
        1 => ['Senin', 'Selasa'],
        2 => ['Senin', 'Selasa'],
        3 => ['Selasa', 'Rabu'],
        4 => ['Selasa', 'Rabu'],
        5 => ['Rabu', 'Kamis', 'Jumat'],
        6 => ['Kamis', 'Jumat'],
    ];

    public function generate()
    {
        $mataKuliah = Mata_kuliah::orderByDesc('sks')->get();
        $ruang = Ruang::all();
        $hariDefault = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        foreach ($mataKuliah as $mk) {

            // ✅ SEMESTER DARI GROUP
            $semesterDipilih = (int) substr($mk->group, 0, 1);

            // Preferensi hari
            $hariPilihan = $this->hariPreferensi[$semesterDipilih] ?? $hariDefault;
            $assigned = false;

            foreach ($hariPilihan as $hari) {
                foreach ($ruang as $r) {

                    $jamMulai = $r->jam_mulai;
                    $jamSelesai = $r->jam_selesai;
                    // CEK BENTROK RUANG (PER FAKULTAS & PRODI)
                    $bentrokRuang = jadwalkuliah::where('hari', $hari)
                        ->where('ruangs_id', $r->id)
                        ->where('semester', $semesterDipilih)
                        ->where('fakultas_id', $mk->fakultas_id)
                        ->where('program_studi_id', $mk->program_studi_id)
                        ->where(function ($q) use ($jamMulai, $jamSelesai) {
                            $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                              ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai]);
                        })
                        ->exists();

                    // CEK BENTROK GROUP (PER FAKULTAS & PRODI)
                    $bentrokGroup = jadwalkuliah::where('hari', $hari)
                        ->where('semester', $semesterDipilih)
                        ->where('fakultas_id', $mk->fakultas_id)
                        ->where('program_studi_id', $mk->program_studi_id)
                        ->whereHas('mata_kuliah', function ($q) use ($mk) {
                            $q->where('group', $mk->group);
                        })
                        ->where(function ($q) use ($jamMulai, $jamSelesai) {
                            $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                              ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai]);
                        })
                        ->exists();

                    if ($bentrokRuang || $bentrokGroup) continue;


                    jadwalkuliah::create([
                        'mata_kuliah_id'   => $mk->id,
                        'ruangs_id'        => $r->id,
                        'semester'         => $semesterDipilih,
                        'group'            => $mk->group,
                        'hari'             => $hari,
                        'jam_mulai'        => $jamMulai,
                        'jam_selesai'      => $jamSelesai,
                        'fakultas_id'      => $mk->fakultas_id,
                        'program_studi_id' => $mk->program_studi_id,
                    ]);

                    $assigned = true;
                    break;
                }
                if ($assigned) break;
            }
        }

        return redirect('/akademik/jadwalkuliah')
            ->with('success', 'Jadwal otomatis berhasil digenerate per fakultas & program studi!');
    }
}
