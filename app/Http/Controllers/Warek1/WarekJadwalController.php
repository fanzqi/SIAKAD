<?php

namespace App\Http\Controllers\Warek1;

use App\Http\Controllers\Controller;
use App\Models\JadwalKuliah;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class WarekJadwalController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKuliah::with([
            'mata_kuliah.dosen',
            'mata_kuliah.program_studi',
            'ruang'
        ])
        ->where('status', 'diajukan')
        ->get();

        return view('warek1.jadwal.index', compact('jadwal'));
    }

    // ===============================
    // SETUJUI JADWAL
    // ===============================
    public function setujui($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);

        $jadwal->update([
            'status' => 'disetujui',
            'tanggal_persetujuan' => now(),
            'catatan_warek' => null
        ]);

        // 🔔 NOTIFIKASI KE AKADEMIK
        $akademik = User::where('role', 'akademik')->first();

        if ($akademik) {
            Notification::create([
                'user_id'     => $akademik->id,
                'author_name' => 'Warek 1',
                'type'        => 'disetujui',
                'message'     => 'Jadwal kuliah telah disetujui oleh Warek 1',
            ]);
        }

        return back()->with('success', 'Jadwal berhasil disetujui');
    }

    // ===============================
    // REVISI JADWAL
    // ===============================
    public function revisi(Request $request, $id)
    {
        $request->validate([
            'catatan_warek' => 'required|string'
        ]);

        $jadwal = JadwalKuliah::findOrFail($id);

        $jadwal->update([
            'status' => 'revisi',
            'catatan_warek' => $request->catatan_warek,
            'tanggal_persetujuan' => null
        ]);

        // 🔔 NOTIFIKASI KE AKADEMIK (ISI DARI CATATAN WAREK)
        $akademik = User::where('role', 'akademik')->first();

        if ($akademik) {
            Notification::create([
                'user_id'     => $akademik->id,
                'author_name' => 'Warek 1',
                'type'        => 'revisi',
                'message'     => $request->catatan_warek, // 🔥 ISI LANGSUNG
            ]);
        }

        return back()->with('warning', 'Jadwal Berhasil dikembalikan untuk revisi');
    }

    public function setujuiBulk(Request $request)
{
    if (!$request->jadwal_ids) {
        return back()->with('warning', 'Pilih minimal satu jadwal');
    }

    JadwalKuliah::whereIn('id', $request->jadwal_ids)->update([
        'status' => 'disetujui',
        'tanggal_persetujuan' => now(),
        'catatan_warek' => null
    ]);

    return back()->with('success', 'Jadwal terpilih berhasil disetujui');
}

public function setujuiSemua()
{
    JadwalKuliah::where('status', 'diajukan')->update([
        'status' => 'disetujui',
        'tanggal_persetujuan' => now(),
        'catatan_warek' => null
    ]);

    return back()->with('success', 'Semua jadwal berhasil disetujui');
}

}