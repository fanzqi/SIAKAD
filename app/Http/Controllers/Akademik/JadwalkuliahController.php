<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwalkuliah;
use App\Models\mata_kuliah;
use App\Models\Ruang;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalKuliahExport;

class JadwalkuliahController extends Controller
{
    // Menampilkan semua jadwal dengan relasi lengkap
    public function index()
    {
        $jadwal = Jadwalkuliah::with([
            'mata_kuliah.fakultas',
            'mata_kuliah.program_studi',
            'mata_kuliah.dosen',
            'ruang'
        ])->get();

        return view('akademik.jadwalkuliah.index', compact('jadwal'));
    }

    // Form tambah jadwal
    public function create()
    {
        $mata_kuliah = mata_kuliah::with(['fakultas', 'program_studi', 'dosen'])->get();
        $ruang = Ruang::all();
        return view('akademik.jadwalkuliah.create', compact('mata_kuliah', 'ruang'));
    }

    // Simpan jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'ruang_id'       => 'required|exists:ruangs,id',
            'hari'           => 'required|string',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required',
        ]);

        $mata_kuliah = mata_kuliah::findOrFail($request->mata_kuliah_id);

        Jadwalkuliah::create([
            'mata_kuliah_id' => $mata_kuliah->id,
            'ruang_id'       => $request->ruang_id,
            'hari'           => $request->hari,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'group_kelas'    => $mata_kuliah->group,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    // Form edit jadwal
    public function edit(Jadwalkuliah $jadwal)
    {
        $mata_kuliah = mata_kuliah::with(['fakultas', 'program_studi', 'dosen'])->get();
        $ruang = Ruang::all();
        return view('akademik.jadwalkuliah.edit', compact('jadwal', 'mata_kuliah', 'ruang'));
    }

    // Update jadwal
    public function update(Request $request, Jadwalkuliah $jadwal)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'ruang_id'       => 'required|exists:ruangs,id',
            'hari'           => 'required|string',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required',
        ]);

        $mata_kuliah = mata_kuliah::findOrFail($request->mata_kuliah_id);

        $jadwal->update([
            'mata_kuliah_id' => $mata_kuliah->id,
            'ruang_id'       => $request->ruang_id,
            'hari'           => $request->hari,
            'jam_mulai'      => $request->jam_mulai,
            'jam_selesai'    => $request->jam_selesai,
            'group_kelas'    => $mata_kuliah->group,
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