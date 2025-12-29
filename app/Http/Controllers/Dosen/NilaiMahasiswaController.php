<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Dosen;
use App\Models\NilaiMahasiswa;
use App\Models\Mata_kuliah;
use App\Models\Mahasiswa;
use App\Models\TahunAkademik;

class NilaiMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $dosen = Dosen::where('nidn', Auth::user()->username)->firstOrFail();
        $mataKuliah = Mata_kuliah::where('dosen_id', $dosen->id)->get();
        $selectedMataKuliah = $request->mata_kuliah_id;
        $nilaiMahasiswa = collect();
        $mahasiswa = collect();

        if ($selectedMataKuliah) {
            $mahasiswa = Mahasiswa::whereHas('mataKuliah', function ($q) use ($selectedMataKuliah) {
                $q->where('mata_kuliah.id', $selectedMataKuliah);
            })
                ->orderBy('nama')
                ->get();

            $nilaiMahasiswa = NilaiMahasiswa::where('mata_kuliah_id', $selectedMataKuliah)
                ->where('dosen_id', $dosen->id)
                ->get()
                ->keyBy('mahasiswa_id');
        }

        $tahunAktif = TahunAkademik::where('status', 'Aktif')->first();

        return view('dosen.inputnilai.index', compact(
            'mataKuliah',
            'mahasiswa',
            'nilaiMahasiswa',
            'selectedMataKuliah',
            'tahunAktif'
        ));
    }

    public function update(Request $request, $mahasiswa_id)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'kehadiran' => 'required|numeric|min:0|max:100',
            'tugas' => 'required|numeric|min:0|max:100',
            'uts' => 'required|numeric|min:0|max:100',
            'uas' => 'required|numeric|min:0|max:100',
        ]);

        $dosen = Dosen::where('nidn', Auth::user()->username)->firstOrFail();

        // Tarik tahun masuk mahasiswa untuk id_tahun_akademik KRS
        $mahasiswa = Mahasiswa::findOrFail($mahasiswa_id);
        $tahunAkademikId = $mahasiswa->tahun_akademik_id;

        // Cek/insert KRS mahasiswa-mk jika belum ada
        $krs = DB::table('krs')
            ->where('mahasiswa_id', $mahasiswa_id)
            ->where('mata_kuliah_id', $request->mata_kuliah_id)
            ->where('id_tahun_akademik', $tahunAkademikId)
            ->first();

        if (!$krs) {
            DB::table('krs')->insert([
                'mahasiswa_id'      => $mahasiswa_id,
                'mata_kuliah_id'    => $request->mata_kuliah_id,
                'kurikulum_id'      => $mahasiswa->kurikulum_id,
                'id_tahun_akademik' => $tahunAkademikId,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        $nilaiAkhir =
            ($request->kehadiran * 0.10) +
            ($request->tugas * 0.20) +
            ($request->uts * 0.30) +
            ($request->uas * 0.40);

        if ($nilaiAkhir >= 90) {
            $grade = 'A';
            $bobot = 4.00;
        } elseif ($nilaiAkhir >= 80) {
            $grade = 'A-';
            $bobot = 3.75;
        } elseif ($nilaiAkhir >= 75) {
            $grade = 'B+';
            $bobot = 3.25;
        } elseif ($nilaiAkhir >= 70) {
            $grade = 'B';
            $bobot = 3.00;
        } elseif ($nilaiAkhir >= 65) {
            $grade = 'B-';
            $bobot = 2.75;
        } elseif ($nilaiAkhir >= 60) {
            $grade = 'C+';
            $bobot = 2.25;
        } elseif ($nilaiAkhir >= 55) {
            $grade = 'C';
            $bobot = 2.00;
        } elseif ($nilaiAkhir >= 50) {
            $grade = 'C-';
            $bobot = 1.75;
        } else {
            $grade = 'D';
            $bobot = 1.00;
        }

        NilaiMahasiswa::updateOrCreate(
            [
                'mahasiswa_id' => $mahasiswa_id,
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'dosen_id' => $dosen->id,
                'tahun_akademik_id' => $tahunAkademikId,
            ],
            [
                'kehadiran' => $request->kehadiran,
                'tugas' => $request->tugas,
                'uts' => $request->uts,
                'uas' => $request->uas,
                'nilai_akhir' => round($nilaiAkhir, 2),
                'grade' => $grade,
                'bobot' => $bobot,
            ]
        );

        return back()->with('success', 'Nilai berhasil disimpan');
    }
}
