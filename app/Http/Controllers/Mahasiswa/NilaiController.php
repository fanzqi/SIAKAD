<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\NilaiMahasiswa;
use App\Models\TahunAkademik;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $nim = $user->username;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $tahunAkademikList = TahunAkademik::whereIn(
            'id',
            NilaiMahasiswa::where('mahasiswa_id', $mahasiswa->id)
                ->distinct()
                ->pluck('tahun_akademik_id')
        )->get();

        $tahunAkademikId = $request->get('tahun_akademik_id');

        $nilai = NilaiMahasiswa::with(['mata_kuliah', 'tahunAkademik'])
            ->where('mahasiswa_id', $mahasiswa->id);

        if ($tahunAkademikId) {
            $nilai->where('tahun_akademik_id', $tahunAkademikId);
        }
        $nilai = $nilai->get();

        return view('mahasiswa.nilai.index', compact('mahasiswa', 'nilai', 'tahunAkademikList', 'tahunAkademikId'));
    }
}