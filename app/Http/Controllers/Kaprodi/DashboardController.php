<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\TahunAkademik;
use App\Models\JabatanStruktural;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dosen = $user->dosen ?? null;

        // Ambil jabatan Kaprodi aktif berdasarkan dosen yang login
        $jabatanKaprodi = $dosen ? JabatanStruktural::where('dosen_id', $dosen->id)
            ->where('jabatan', 'Kaprodi') // pastikan 'Kaprodi' persis dengan field di DB
            ->where('status', 'Aktif')
            ->first() : null;

        // Relasi ke model ProgramStudi (prodi)
        $prodi = $jabatanKaprodi && $jabatanKaprodi->prodi ? $jabatanKaprodi->prodi : null;
        $fakultas = $prodi && $prodi->fakultas ? $prodi->fakultas : null;

        $totalMahasiswa = $prodi ? $prodi->mahasiswa()->count() : 0;
        $totalMatkul = $prodi ? $prodi->mataKuliahs()->count() : 0;

        $notifications = Notification::latest()->limit(5)->get();
        $semesterBerjalan = TahunAkademik::latest()->first();

        $sebaranMahasiswaPerSemester = $prodi ? $prodi->mahasiswa()

    
    ->join('tahun_akademik', 'mahasiswa.tahun_akademik_id', '=', 'tahun_akademik.id')
    ->selectRaw('tahun_akademik.semester as semester, COUNT(mahasiswa.id) as jumlah')
    ->groupBy('tahun_akademik.semester')
    ->orderBy('tahun_akademik.semester')
    ->get()
    ->map(function($item) {
        return [
            'semester' => 'Semester ' . $item->semester,
            'jumlah' => $item->jumlah
        ];
    }) : [];


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
