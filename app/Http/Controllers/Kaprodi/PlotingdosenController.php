<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlotingDosenController extends Controller
{
    /**
     * List ploting dosen
     */
    public function index()
{
    $idProdi = auth()->user()->dosen->prodi_id;

    $data = DB::table('ploting_dosen as pd')
        ->join('dosen as d', 'd.id', '=', 'pd.id_dosen')
        ->join('mata_kuliah as mk', 'mk.id', '=', 'pd.id_mk')
        ->join('kelas as k', 'k.id', '=', 'pd.id_kelas')
        ->join('tahun_akademik as ta', 'ta.id', '=', 'pd.id_tahun_akademik')
        ->where('pd.id_prodi', $idProdi) //filter kaprodi
        ->where('d.prodi_id', $idProdi) // filter dosen
        ->where('mk.program_studi_id', $idProdi) //filter matkul
        ->select(
            'pd.id_ploting',
            'd.nama as nama_dosen',
            'mk.nama_mata_kuliah',
            'k.nama_kelas',
            'ta.tahun_akademik',
            'ta.semester'
        )
        ->orderBy('ta.tahun_akademik', 'desc')
        ->get();

    return view('kaprodi.plotingdosen.index', compact('data'));
}


    /**
     * Form tambah ploting
     */
    public function create()
{
    $idProdi = auth()->user()->dosen->prodi_id;

    $mataKuliah = DB::table('mata_kuliah')
        ->where('program_studi_id', $idProdi)
        ->orderBy('nama_mata_kuliah')
        ->get();

    $dosen = DB::table('dosen')
        ->where('prodi_id', $idProdi)
        ->orderBy('nama')
        ->get();

    $kelas = DB::table('kelas')
        ->where('prodi_id', $idProdi)
        ->orderBy('nama_kelas')
        ->get();

    $tahunAkademik = DB::table('tahun_akademik')
        ->where('status', 'aktif')
        ->orderBy('tahun_akademik', 'desc')
        ->get();

    return view('kaprodi.plotingdosen.create', compact(
        'mataKuliah',
        'dosen',
        'kelas',
        'tahunAkademik'
    ));
}


   public function store(Request $request)
{
    $idProdi = auth()->user()->dosen->prodi_id ?? null;

    if (!$idProdi) {
        return back()->with('error', 'User tidak memiliki prodi');
    }

    $request->validate([
        'id_dosen' => 'required|exists:dosen,id',
        'id_mk' => 'required|exists:mata_kuliah,id',
        'id_kelas' => 'required|exists:kelas,id',
        'id_tahun_akademik' => 'required|exists:tahun_akademik,id',
    ]);

    // 🔐 CEK DOSEN SATU PRODI
    $dosenValid = DB::table('dosen')
        ->where('id', $request->id_dosen)
        ->where('prodi_id', $idProdi)
        ->exists();

    // 🔐 CEK MATA KULIAH SATU PRODI
    $mkValid = DB::table('mata_kuliah')
        ->where('id', $request->id_mk)
        ->where('program_studi_id', $idProdi)
        ->exists();

    if (!$dosenValid || !$mkValid) {
        return back()->with('error', 'Dosen atau Mata Kuliah tidak sesuai prodi');
    }

    // 🔁 CEK DUPLIKASI
    $exists = DB::table('ploting_dosen')
        ->where([
            'id_dosen' => $request->id_dosen,
            'id_mk' => $request->id_mk,
            'id_kelas' => $request->id_kelas,
            'id_tahun_akademik' => $request->id_tahun_akademik,
            'id_prodi' => $idProdi,
            'status' => 1
        ])
        ->exists();

    if ($exists) {
        return back()->with('error', 'Ploting dosen sudah ada.');
    }

    DB::table('ploting_dosen')->insert([
        'id_mk' => $request->id_mk,
        'id_dosen' => $request->id_dosen,
        'id_kelas' => $request->id_kelas,
        'id_tahun_akademik' => $request->id_tahun_akademik,
        'id_prodi' => $idProdi, // 🔒 DIKUNCI
        'dibuat_oleh' => auth()->id(),
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()
        ->route('plotingdosen.index')
        ->with('success', 'Ploting dosen berhasil disimpan');
}


    /**
     * Nonaktifkan ploting
     */
    public function destroy($id)
{
    DB::table('ploting_dosen')
        ->where('id_ploting', $id)
        ->delete();

    return redirect()
        ->route('plotingdosen.index')
        ->with('delete', 'Ploting dosen berhasil dihapus');
}


    public function update(Request $request, $id)
{
    $idProdi = auth()->user()->dosen->prodi_id ?? null;

    if (!$idProdi) {
        return back()->with('error', 'User tidak memiliki prodi');
    }

    $request->validate([
        'id_dosen' => 'required|exists:dosen,id',
        'id_mk' => 'required|exists:mata_kuliah,id',
        'id_kelas' => 'required|exists:kelas,id',
        'id_tahun_akademik' => 'required|exists:tahun_akademik,id',
    ]);

    // 🔐 Pastikan data milik prodi ini
    $ploting = DB::table('ploting_dosen')
        ->where('id_ploting', $id)
        ->where('id_prodi', $idProdi)
        ->first();

    if (!$ploting) {
        abort(403);
    }

    DB::table('ploting_dosen')
        ->where('id_ploting', $id)
        ->update([
            'id_dosen' => $request->id_dosen,
            'id_mk' => $request->id_mk,
            'id_kelas' => $request->id_kelas,
            'id_tahun_akademik' => $request->id_tahun_akademik,
            'updated_at' => now(),
        ]);

    return redirect()
        ->route('plotingdosen.index')
        ->with('success', 'Ploting dosen berhasil diperbarui');
}


public function edit($id)
{
    $idProdi = auth()->user()->dosen->prodi_id;

    $ploting = DB::table('ploting_dosen')
        ->where('id_ploting', $id)
        ->where('id_prodi', $idProdi) // 🔒 kunci prodi
        ->first();

    if (!$ploting) {
        abort(404);
    }

    $mataKuliah = DB::table('mata_kuliah')
        ->where('program_studi_id', $idProdi)
        ->orderBy('nama_mata_kuliah')
        ->get();

    $dosen = DB::table('dosen')
        ->where('prodi_id', $idProdi)
        ->orderBy('nama')
        ->get();

    $kelas = DB::table('kelas')
        ->orderBy('nama_kelas')
        ->get();

    $tahunAkademik = DB::table('tahun_akademik')
        ->where('status', 'aktif')
        ->get();

    return view('kaprodi.plotingdosen.edit', compact(
        'ploting',
        'mataKuliah',
        'dosen',
        'kelas',
        'tahunAkademik'
    ));
}

}
