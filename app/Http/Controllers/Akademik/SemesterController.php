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

    // Tandai hanya untuk user ini
    if($notification->user_id === null || $notification->user_id == auth()->id()){
        $notification->is_read = 1;
        $notification->save();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Notifikasi tidak bisa diubah']);
}

    /**
     * Menampilkan daftar Tahun Akademik / Input Nilai
     */
    public function index()
    {
        $semesters = TahunAkademik::all();
        $inputNilai = InputNilai::all();

        return view('akademik.semester.index', compact('semesters', 'inputNilai'));
    }

    /**
     * Halaman form tambah Tahun Akademik
     */
    public function create()
    {
        return view('akademik.semester.create');
    }

    /**
     * Simpan data Tahun Akademik baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik' => 'required',
            'semester' => 'required|in:Ganjil,Genap,Pendek',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $semester = TahunAkademik::create([
            'tahun_akademik' => $request->tahun_akademik,
            'semester' => $request->semester,
            'status' => $request->status,
        ]);

        // Notifikasi global untuk semua user
        Notification::create([
            'user_id' => null, // null = semua user
            'author_name' => Auth::user()?->name ?? 'Sistem',
            'type' => 'add',
            'message' => 'Tahun Akademik ' . $semester->tahun_akademik . ' (' . $semester->semester . '), telah dimulai'
        ]);

        return redirect()->route('semester.index')
            ->with('success', 'Data tahun akademik berhasil ditambahkan');
    }

    /**
     * Halaman form edit Tahun Akademik
     */
    public function edit($id)
    {
        $semester = TahunAkademik::findOrFail($id);
        return view('akademik.semester.edit', compact('semester'));
    }

    /**
     * Update Tahun Akademik
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_akademik' => 'required',
            'semester' => 'required|in:Ganjil,Genap,Pendek',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $semester = TahunAkademik::findOrFail($id);
        $semester->update([
            'tahun_akademik' => $request->tahun_akademik,
            'semester' => $request->semester,
            'status' => $request->status,
        ]);

        // Notifikasi khusus user yang update
        Notification::create([
            'user_id' => Auth::id(),
            'author_name' => Auth::user()?->name ?? 'Sistem',
            'type' => 'edit',
            'message' => 'Mengedit Tahun Akademik ' . $semester->tahun_akademik . ' (' . $semester->semester . ')'
        ]);

        return redirect()->route('semester.index')
            ->with('edit', 'Data Tahun Akademik berhasil diperbarui');
    }

    /**
     * Hapus Tahun Akademik
     */
    public function destroy($id)
    {
        $semester = TahunAkademik::findOrFail($id);
        $info = $semester->tahun_akademik . ' (' . $semester->semester . ')';
        $semester->delete();

        // Notifikasi khusus user yang delete
        Notification::create([
            'user_id' => Auth::id(),
            'author_name' => Auth::user()?->name ?? 'Sistem',
            'type' => 'delete',
            'message' => 'Menghapus Tahun Akademik ' . $info
        ]);

        return redirect()->route('semester.index')
            ->with('delete', 'Data Tahun Akademik berhasil dihapus');
    }
}
