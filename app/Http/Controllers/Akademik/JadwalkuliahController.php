<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwalkuliah;    // Tabel jadwal
use App\Models\Mata_kuliah;     // Relasi
use App\Models\Ruang;           // Relasi
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalKuliahExport;

class JadwalkuliahController extends Controller
{
    // Menampilkan semua jadwal
    public function index()
    {
        $jadwal = Jadwalkuliah::with('mata_kuliah', 'ruang')->get();
        return view('akademik.jadwalkuliah.index', compact('jadwal'));
    }

    // Form tambah jadwal
    public function create()
    {
        $mataKuliah = Mata_kuliah::all();
        $ruang = Ruang::all();
        return view('akademik.jadwalkuliah.create', compact('mataKuliah', 'ruang'));
    }

    // Simpan jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'ruang_id'       => 'required|exists:ruangs,id',
            'hari'           => 'required',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required',
            'group_kelas' => Mata_kuliah::find($request->mata_kuliah_id)->group,

        ]);

        Jadwalkuliah::create([
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'ruang_id'       => $request->ruang_id,
            'hari'           => $request->hari,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'group_kelas' => Mata_kuliah::find($request->mata_kuliah_id)->group,

        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    // Form edit jadwal
    public function edit(Jadwalkuliah $jadwal)
    {
        $mataKuliah = Mata_kuliah::all();
        $ruang = Ruang::all();
        return view('akademik.jadwalkuliah.edit', compact('jadwal', 'mataKuliah', 'ruang'));
    }

    // Update jadwal
    public function update(Request $request, Jadwalkuliah $jadwal)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'ruang_id'       => 'required|exists:ruangs,id',
            'hari'           => 'required',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required',
           'group_kelas' => Mata_kuliah::find($request->mata_kuliah_id)->group,

        ]);

        $jadwal->update([
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'ruang_id'       => $request->ruang_id,
            'hari'           => $request->hari,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'group_kelas' => Mata_kuliah::find($request->mata_kuliah_id)->group,

        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    // Hapus jadwal
    public function destroy(Jadwalkuliah $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    // Export jadwal ke Excel
    public function exportExcel()
    {
        return Excel::download(new JadwalKuliahExport, 'jadwal_kuliah.xlsx');
    }
}
