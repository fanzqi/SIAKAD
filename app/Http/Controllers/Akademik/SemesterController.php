<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\TahunAkademik;
use App\Models\InputNilai;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SemesterController extends Controller
{
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);

        if ($notification->user_id === null || $notification->user_id == Auth::id()) {
            $notification->is_read = 1;
            $notification->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Notifikasi tidak bisa diubah']);
    }

    /**
     * Menampilkan daftar Tahun Akademik / Semester
     */
    public function index()
    {
        $semesters = TahunAkademik::all();
        $inputNilai = InputNilai::all();

        return view('akademik.semester.index', compact('semesters', 'inputNilai'));
    }

    /**
     * Halaman form tambah Semester
     */
    public function create()
    {
        return view('akademik.semester.create');
    }

    /**
     * Simpan data Semester baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik' => 'required',
            'semester' => 'required|in:Ganjil,Genap,Pendek',
            'kode_semester' => 'required',
            'semester_ke' => 'required|numeric',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'status' => 'required|in:Aktif,Nonaktif,Ditutup',
        ]);

        $semester = TahunAkademik::create([
            'tahun_akademik' => $request->tahun_akademik,
            'semester' => $request->semester,
            'kode_semester' => $request->kode_semester,
            'semester_ke' => $request->semester_ke,
            'periode_mulai' => $request->periode_mulai,
            'periode_selesai' => $request->periode_selesai,
            'status' => $request->status,
        ]);

        Notification::create([
            'user_id' => null,
            'author_name' => Auth::user()?->name ?? 'Sistem',
            'type' => 'add',
            'message' => 'Tahun Akademik ' . $semester->tahun_akademik . ' (' . $semester->semester . '), telah dimulai'
        ]);

        return redirect()->route('semester.index')
            ->with('success', 'Data semester berhasil ditambahkan');
    }

    /**
     * Halaman edit Semester
     */
    public function edit($id)
    {
        $semester = TahunAkademik::findOrFail($id);
        return view('akademik.semester.edit', compact('semester'));
    }

    /**
     * Update Semester
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_akademik' => 'required',
            'semester' => 'required|in:Ganjil,Genap,Pendek',
            'kode_semester' => 'required',
            'semester_ke' => 'required|numeric',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'status' => 'required|in:Aktif,Nonaktif,Ditutup',
        ]);

        $semester = TahunAkademik::findOrFail($id);
        $semester->update([
            'tahun_akademik' => $request->tahun_akademik,
            'semester' => $request->semester,
            'kode_semester' => $request->kode_semester,
            'semester_ke' => $request->semester_ke,
            'periode_mulai' => $request->periode_mulai,
            'periode_selesai' => $request->periode_selesai,
            'status' => $request->status,
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'author_name' => Auth::user()?->name ?? 'Sistem',
            'type' => 'edit',
            'message' => 'Mengedit Tahun Akademik ' . $semester->tahun_akademik . ' (' . $semester->semester . ')'
        ]);

        return redirect()->route('semester.index')
            ->with('edit', 'Data semester berhasil diperbarui');
    }

    /**
     * Hapus Semester
     */
    public function destroy($id)
    {
        $semester = TahunAkademik::findOrFail($id);
        $info = $semester->tahun_akademik . ' (' . $semester->semester . ')';
        $semester->delete();

        Notification::create([
            'user_id' => Auth::id(),
            'author_name' => Auth::user()?->name ?? 'Sistem',
            'type' => 'delete',
            'message' => 'Menghapus Tahun Akademik ' . $info
        ]);

        return redirect()->route('semester.index')
            ->with('delete', 'Data semester berhasil dihapus');
    }
}
