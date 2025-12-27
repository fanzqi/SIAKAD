<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalKuliah;
use App\Models\mata_kuliah;
use App\Models\Ruang;
use App\Models\Notification;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalKuliahExport;
use Illuminate\Support\Facades\Auth;

class JadwalKuliahController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKuliah::with([
            'mata_kuliah.fakultas',
            'mata_kuliah.program_studi',
            'mata_kuliah.dosen',
            'ruang'
        ])->get();
        return view('akademik.jadwalkuliah.index', compact('jadwal'));
    }

    public function create()
    {
        $mata_kuliah = mata_kuliah::with(['fakultas', 'program_studi', 'dosen'])->get();
        $ruang = Ruang::all();
        return view('akademik.jadwalkuliah.create', compact('mata_kuliah', 'ruang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'ruang_id' => 'required|exists:ruangs,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $mata_kuliah = mata_kuliah::findOrFail($request->mata_kuliah_id);

        JadwalKuliah::create([
            'mata_kuliah_id' => $mata_kuliah->id,
            'ruang_id' => $request->ruang_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'group_kelas' => $mata_kuliah->group,
            'status' => 'draft',
        ]);

        return redirect()->route('jadwalkuliah.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = JadwalKuliah::with(['mata_kuliah.program_studi'])->findOrFail($id);
        $ruangs = Ruang::all();
        return view('akademik.jadwalkuliah.edit', compact('jadwal', 'ruangs'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $statusBaru = $jadwal->status === 'revisi' ? 'diajukan' : $jadwal->status;

        $jadwal->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ruang_id' => $request->ruang_id,
            'status' => $statusBaru
        ]);

        $namaMk = $jadwal->mata_kuliah->nama_mata_kuliah;
        $nimk = $jadwal->mata_kuliah->kode ?? '-';

        if ($statusBaru === 'diajukan') {
            $pesan = "Jadwal {$namaMk} [Kode: {$nimk}] telah diajukan ke Warek 1 dan menunggu persetujuan.";
            $this->sendNotifToRoles(['warek1'], 'pengajuan', $pesan);
        }

        return redirect()->route('jadwalkuliah.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(JadwalKuliah $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwalkuliah.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function exportExcel()
    {
        return Excel::download(new JadwalKuliahExport, 'jadwal_kuliah.xlsx');
    }

    /**
     * Diajukan ke Warek 1 (seluruh draft dimasukkan ke pengajuan)
     */
    public function kirimWarek()
    {
        $draft = JadwalKuliah::where('status', 'draft')->get();

        if ($draft->isEmpty()) {
            return back()->with('warning', 'Tidak ada jadwal draft');
        }

        // Jadikan semua status draft menjadi diajukan
        JadwalKuliah::where('status', 'draft')->update(['status' => 'diajukan']);

        $pesan = "Tolong koreksi seluruh jadwal draft sebelum disetujui Warek 1.";

        // Kirim notifikasi ke warek1 saja (tidak ke pengirim yang login)
        $this->sendNotifToRoles(['warek1'], 'pengajuan', $pesan);

        return back()->with('success', 'Jadwal berhasil diajukan ke Warek 1');
    }


    /**
     * Warek1 menyetujui, notifikasi ke akademik
     */
    public function setujui(Request $request, $id)
    {
        $jadwal = JadwalKuliah::whereIn('status', ['diajukan', 'revisi'])->findOrFail($id);
        $jadwal->update([
            'status' => 'disetujui',
            'tanggal_persetujuan' => now(),
            'catatan_warek' => null
        ]);

        $namaMk = $jadwal->mata_kuliah->nama_mata_kuliah;
        $nimk = $jadwal->mata_kuliah->kode ?? '-';
        $pesan = "Jadwal {$namaMk} [Kode: {$nimk}] telah disetujui oleh Anda Wakil Rektor I.";
        // Notifikasi ke Akademik (tidak ke pengirim, misal warek1)
        $this->sendNotifToRoles(['akademik'], 'disetujui', $pesan);

        return back()->with('success', 'Jadwal berhasil disetujui (notifikasi dikirim ke Akademik)');
    }


    /**
     * Distribusi hasil ke civitas (mahasiswa, dosen, kaprodi, warek1, dekan)
     */
    public function publish(Request $request)
    {
        $jadwalSiap = JadwalKuliah::where('status', 'disetujui')->get();

        if ($jadwalSiap->isEmpty()) {
            return back()->with('warning', 'Belum ada jadwal disetujui untuk didistribusi');
        }

        $pesan = "Seluruh jadwal kuliah yang telah disetujui telah didistribusikan ke seluruh civitas akademika.";
        $this->sendNotifToRoles(
            ['mahasiswa', 'dosen', 'kaprodi', 'warek1', 'dekan'],
            'distribusi',
            $pesan
        );
        return back()->with('success', 'Jadwal berhasil didistribusikan (notifikasi dikirim ke civitas)');
    }

    /**
     * NOTIFIKASI KHUSUS: Kirim ke hanya ke $roles (tidak ke pengirim)
     */
    private function sendNotifToRoles(array $roles, string $type, string $pesan)
    {
        $userIds = User::whereIn('role', $roles)
            ->where('id', '!=', Auth::id())
            ->pluck('id')
            ->toArray();

        if (empty($userIds)) return;

        $notif = Notification::create([
            // Bisa diganti sesuai Auth, contoh: ucfirst(Auth::user()->role)
            'author_name' => ucfirst(Auth::user()->role),
            'type'        => $type,
            'message'     => $pesan
        ]);
        $attachData = [];
        foreach ($userIds as $id) {
            $attachData[$id] = [
                'is_read'    => 0,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        $notif->users()->syncWithoutDetaching($attachData);
    }

}
