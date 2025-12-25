<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $dosen = $user->dosen ?? null;
        $prodi = $user->prodi ?? ($dosen ? $dosen->prodi : null);
        $fakultas = $prodi ? $prodi->fakultas : null;

        $totalMahasiswa = $prodi ? $prodi->mahasiswa()->count() : 0;
        $totalMatkul = $prodi ? $prodi->mataKuliahs()->count() : 0;

        $notifications = Notification::latest()->limit(5)->get();
        $semesterBerjalan = TahunAkademik::latest()->first();

        // Sebaran mahasiswa per semester
        $sebaranMahasiswaPerSemester = $prodi ? $prodi->mahasiswa()
            ->join('tahun_akademik', 'mahasiswa.semester_aktif_id', '=', 'tahun_akademik.id')
            ->whereIn('tahun_akademik.semester_ke', [1, 3, 5, 7])
            ->selectRaw('tahun_akademik.semester_ke as semester, COUNT(mahasiswa.id) as jumlah')
            ->groupBy('tahun_akademik.semester_ke')
            ->orderBy('tahun_akademik.semester_ke')
            ->get()
            ->map(function ($item) {
                return [
                    'semester' => 'Semester ' . $item->semester,
                    'jumlah' => $item->jumlah
                ];
            })
            : [];


        return view('kaprodi.dashboard.index', [
            'namaKaprodi' => $dosen->nama ?? 'Belum diatur',
            'namaProdi' => $prodi->nama ?? '-',
            'namaFakultas' => $fakultas->nama ?? '-',
            'totalMahasiswa' => $totalMahasiswa,
            'totalMatkul' => $totalMatkul,
            'notifications' => $notifications,
            'semesterBerjalan' => $semesterBerjalan,
            'sebaranMahasiswaPerSemester' => $sebaranMahasiswaPerSemester
        ]);
    }
}