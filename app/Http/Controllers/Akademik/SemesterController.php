<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\TahunAkademik;
use App\Models\InputNilai;
use Illuminate\Http\Request;
use App\Models\Notification;

class SemesterController extends Controller
{
    /**
     * Menampilkan daftar Tahun Akademik / Semester
     */
    public function index()
    {
        $semesters = TahunAkademik::all();      // Menampilkan semua tahun akademik
        $inputNilai = InputNilai::all();        // Menampilkan data input nilai
        return view('Semester.Semester', compact('semesters', 'inputNilai'));
    }

    /**
     * Halaman form tambah tahun akademik
     */
    public function create()
    {
        return view('Semester.create');
    }

    /**
     * Menyimpan data tahun akademik baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik' => 'required',
            'semester' => 'required|in:Ganjil,Genap,Pendek',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        TahunAkademik::create([
            'tahun_akademik' => $request->tahun_akademik,
            'semester' => $request->semester,
            'status' => $request->status,
        ]);

        // 🔔 Buat notifikasi tambah
        Notification::create([
            'message' => 'Menambahkan Tahun Akademik ' . $request->tahun_akademik . ' (' . $request->semester . ')'
        ]);

        return redirect()->route('semester.semester')
            ->with('success', 'Data tahun akademik berhasil ditambahkan');
    }

    /**
     * Halaman form edit input nilai semester
     */
    public function edit($id)
    {
        $data = InputNilai::findOrFail($id);
        $tahun = TahunAkademik::all();
        return view('akademik.semester.edit', compact('data', 'tahun'));
    }

    /**
     * Update data input nilai semester
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_akademik_id' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'status' => 'required',
        ]);

        $data = InputNilai::findOrFail($id);

        $data->update([
            'tahun_akademik_id' => $request->tahun_akademik_id,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'status' => $request->status,
        ]);

        // 🔔 Buat notifikasi edit
        Notification::create([
            'message' => 'Mengedit Input Nilai: ' . $request->deskripsi
        ]);

        return redirect()->route('semester.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Menghapus Tahun Akademik
     */
    public function destroy($id)
    {
        $data = TahunAkademik::findOrFail($id);

        // Simpan info sebelum dihapus
        $info = $data->tahun_akademik . ' (' . $data->semester . ')';

        $data->delete();

        // 🔔 Buat notifikasi hapus
        Notification::create([
            'message' => 'Menghapus Tahun Akademik ' . $info
        ]);

        return redirect()->route('semester.semester')
            ->with('success', 'Data berhasil dihapus');
    }
}