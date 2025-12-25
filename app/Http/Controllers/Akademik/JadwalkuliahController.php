<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwalkuliah;
use App\Models\mata_kuliah;
use App\Models\Ruang;
use App\Models\Notification;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalKuliahExport;

class JadwalkuliahController extends Controller
{
    // ===============================
    // INDEX
    // ===============================
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

    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        $mata_kuliah = mata_kuliah::with(['fakultas', 'program_studi', 'dosen'])->get();
        $ruang = Ruang::all();

        return view('akademik.jadwalkuliah.create', compact('mata_kuliah', 'ruang'));
    }

    // ===============================
    // STORE
    // ===============================
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
            'status'         => 'draft',
        ]);

        return redirect()->route('jadwalkuliah.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $jadwal = Jadwalkuliah::with(['mata_kuliah.program_studi'])->findOrFail($id);
        $ruangs = Ruang::all();

        return view('akademik.jadwalkuliah.edit', compact('jadwal', 'ruangs'));
    }

    // ===============================
    // UPDATE + NOTIFIKASI WAREK
    // ===============================
    public function update(Request $request, $id)
    {
        $jadwal = Jadwalkuliah::findOrFail($id);

        $statusBaru = $jadwal->status;

        if ($jadwal->status === 'revisi') {
            $statusBaru = 'diajukan';
        }

        $jadwal->update([
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ruang_id'    => $request->ruang_id,
            'status'      => $statusBaru,
        ]);

        if ($statusBaru === 'diajukan') {
            $warek = User::where('role', 'warek1')->first();

            if ($warek) {
                Notification::create([
                    'user_id'     => $warek->id,
                    'author_name' => 'Akademik',
                    'type'        => 'revisi_selesai',
                    'message'     => 'Hasil revisi jadwal telah diperbarui oleh akademik',
                ]);
            }
        }

        return redirect()->route('jadwalkuliah.index')
            ->with('edit', 'Jadwal berhasil diperbarui');
    }

    // ===============================
    // DELETE
    // ===============================
    public function destroy(Jadwalkuliah $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('jadwalkuliah.index')
            ->with('delete', 'Jadwal berhasil dihapus');
    }

    // ===============================
    // EXPORT
    // ===============================
    public function exportExcel()
    {
        return Excel::download(new JadwalKuliahExport, 'jadwal_kuliah.xlsx');
    }

    // ===============================
    // KIRIM KE WAREK
    // ===============================
    public function kirimWarek(Request $request)
    {
        $jadwal = Jadwalkuliah::where('status', 'draft')->get();

        if ($jadwal->count() == 0) {
            return back()->with('warning', 'Tidak ada jadwal draft untuk dikirim');
        }

        Jadwalkuliah::where('status', 'draft')->update([
            'status' => 'diajukan'
        ]);

        return back()->with('success', 'Jadwal berhasil dikirim ke Warek 1');
    }

    // ===============================
    // DISTRIBUSI + NOTIFIKASI
    // ===============================
    public function publish()
    {
        // 1️⃣ Publish semua jadwal
        Jadwalkuliah::query()->update([
            'is_published' => 1
        ]);

        // 2️⃣ Ambil user target
        $users = User::whereIn('role', [
            'dekan','kaprodi','dosen','mahasiswa'
        ])->get();

        // 3️⃣ Buat notifikasi untuk masing-masing user
        foreach ($users as $user) {
            Notification::create([
                'user_id'     => $user->id,
                'author_name' => 'Akademik',
                'type'        => 'jadwal',
                'message'     => 'Jadwal kuliah telah didistribusikan dan dapat diakses',
                'is_read'     => 0,
            ]);
        }

        return redirect()
            ->route('jadwalkuliah.index')
            ->with('success', 'Jadwal berhasil didistribusikan dan notifikasi terkirim');
    }

}
