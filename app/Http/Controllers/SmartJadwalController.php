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
        // Ambil semua semester aktif sebagai array
        $semesterAktif = TahunAkademik::where('status', 'Aktif')
            ->pluck('semester_ke')
            ->toArray();

        $mataKuliah = Mata_kuliah::orderByDesc('sks')->get();
        $ruang = Ruang::all();
        $hariDefault = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        foreach ($semesterAktif as $semesterDipilih) {
            foreach ($mataKuliah as $mk) {
                $hariPilihan = $this->hariPreferensi[$semesterDipilih] ?? $hariDefault;
                $assigned = false;

                foreach ($hariPilihan as $hari) {
                    foreach ($ruang as $r) {
                        $jamMulai = $r->jam_mulai;
                        $jamSelesai = $r->jam_selesai;

                        // CEK BENTROK RUANG
                        $bentrokRuang = jadwalkuliah::where('hari', $hari)
                            ->where('ruangs_id', $r->id)
                            ->where('semester', $semesterDipilih)
                            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                                $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                                  ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai]);
                            })
                            ->exists();

                        // CEK BENTROK GROUP
                        $bentrokGroup = jadwalkuliah::where('hari', $hari)
                            ->where('semester', $semesterDipilih)
                            ->whereHas('mata_kuliah', function ($q) use ($mk) {
                                $q->where('group', $mk->group);
                            })
                            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                                $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                                  ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai]);
                            })
                            ->exists();

                        if ($bentrokRuang || $bentrokGroup) continue;

                        // SIMPAN JADWAL
                        jadwalkuliah::create([
                            'mata_kuliah_id' => $mk->id,
                            'ruangs_id' => $r->id,
                            'semester' => $semesterDipilih,
                            'hari' => $hari,
                            'jam_mulai' => $jamMulai,
                            'jam_selesai' => $jamSelesai,
                        ]);

                        $assigned = true;
                        break;
                    }
                    if ($assigned) break;
                }

                // Fallback: cari slot kosong hari lain
                if (!$assigned) {
                    foreach ($hariDefault as $hari) {
                        foreach ($ruang as $r) {
                            $jamMulai = $r->jam_mulai;
                            $jamSelesai = $r->jam_selesai;

                            $bentrokRuang = jadwalkuliah::where('hari', $hari)
                                ->where('ruangs_id', $r->id)
                                ->where('semester', $semesterDipilih)
                                ->where(function ($q) use ($jamMulai, $jamSelesai) {
                                    $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                                      ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai]);
                                })
                                ->exists();

                            $bentrokGroup = jadwalkuliah::where('hari', $hari)
                                ->where('semester', $semesterDipilih)
                                ->whereHas('mata_kuliah', function ($q) use ($mk) {
                                    $q->where('group', $mk->group);
                                })
                                ->where(function ($q) use ($jamMulai, $jamSelesai) {
                                    $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                                      ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai]);
                                })
                                ->exists();

                            if (!$bentrokRuang && !$bentrokGroup) {
                                jadwalkuliah::create([
                                    'mata_kuliah_id' => $mk->id,
                                    'ruangs_id' => $r->id,
                                    'semester' => $semesterDipilih,
                                    'hari' => $hari,
                                    'jam_mulai' => $jamMulai,
                                    'jam_selesai' => $jamSelesai,
                                ]);
                                break 2;
                            }
                        }
                    }
                }
            }
        }

        return redirect('/akademik/jadwalkuliah')
            ->with('success', 'Jadwal otomatis berhasil digenerate untuk semua semester aktif!');
    }
}