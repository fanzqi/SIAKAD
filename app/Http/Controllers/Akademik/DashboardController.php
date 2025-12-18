<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\mata_kuliah;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika user terkait prodi, filter data sesuai prodi
        $prodiId = $user->prodi_id ?? null;

        $totalMataKuliah = mata_kuliah::when($prodiId, function ($q) use ($prodiId) {
            $q->where('prodi_id', $prodiId);
        })->count();

        $totalDosen = User::where('role', 'dosen')
            ->when($prodiId, function ($q) use ($prodiId) {
                $q->where('prodi_id', $prodiId);
            })->count();

        $totalMahasiswa = User::where('role', 'mahasiswa')
            ->when($prodiId, function ($q) use ($prodiId) {
                $q->where('prodi_id', $prodiId);
            })->count();

        // Data sebaran mahasiswa per program studi
        $sebaranMahasiswa = DB::table('program_studi')
            ->leftJoin('mahasiswa', 'mahasiswa.prodi_id', '=', 'program_studi.id')
            ->select(
                'program_studi.nama as prodi',
                DB::raw('COUNT(mahasiswa.id) as jumlah')
            )
            ->groupBy('program_studi.id', 'program_studi.nama')
            ->orderBy('program_studi.nama')
            ->get();

        // Ambil daftar mata kuliah (tambahan)
$mataKuliah = mata_kuliah::when($prodiId, function ($q) use ($prodiId) {
    $q->where('program_studi_id', $prodiId);
})->orderBy('nama_mata_kuliah')->get();

$totalMataKuliah = $mataKuliah->count();


        return view('akademik.Dashboard.index', compact(
            'totalMataKuliah',
            'totalDosen',
            'totalMahasiswa',
            'sebaranMahasiswa',
            'mataKuliah' // ← tambahan
        ));
    }
}