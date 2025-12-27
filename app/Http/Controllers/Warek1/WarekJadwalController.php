<?php

namespace App\Http\Controllers\Warek1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalKuliah;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class WarekJadwalController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKuliah::with(['mata_kuliah.fakultas', 'mata_kuliah.program_studi', 'mata_kuliah.dosen', 'ruang'])
            ->whereIn('status', ['diajukan', 'revisi'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('warek1.jadwal.index', compact('jadwal'));
    }

    // Setujui: notif hanya ke Akademik
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
        $pesan = "Jadwal {$namaMk} [Kode: {$nimk}] telah disetujui oleh Warek 1.";
        $this->sendNotifToRoles(['akademik'], 'disetujui', $pesan); // Hanya ke akademik

        return back()->with('success', 'Jadwal berhasil disetujui (notifikasi dikirim ke Akademik)');
    }

public function setujuiBulk(Request $request)
{
    $ids = $request->input('ids', []);
    if (empty($ids)) {
        return back()->with('warning', 'Tidak ada jadwal dipilih.');
    }

    $jadwals = \App\Models\JadwalKuliah::with('mata_kuliah')
        ->whereIn('id', $ids)
        ->whereIn('status', ['diajukan', 'revisi'])->get();

    if ($jadwals->isEmpty()) {
        return back()->with('warning', 'Jadwal tidak ditemukan atau sudah diproses.');
    }

    foreach ($jadwals as $jadwal) {
        $jadwal->update([
            'status' => 'disetujui',
            'tanggal_persetujuan' => now(),
            'catatan_warek' => null,
        ]);
    }

    // Satu pesan notifikasi saja
    $list = $jadwals->map(function($j){
        $mk = $j->mata_kuliah->nama_mata_kuliah ?? '-';
        $kode = $j->mata_kuliah->kode ?? '-';
        return "{$mk} [Kode: {$kode}]";
    })->implode(', ');

    $pesan = "Beberapa jadwal telah disetujui Warek 1: " . $list;
    $this->sendNotifToRoles(['akademik'], 'disetujui', $pesan);

    return back()->with('success', "Jadwal terpilih telah disetujui.");
}

    // Revisi: notif hanya ke Akademik
    public function revisi(Request $request, $id)
    {
        $request->validate(['catatan_warek' => 'required|string']);
        $jadwal = JadwalKuliah::findOrFail($id);
        $jadwal->update([
            'status' => 'revisi',
            'catatan_warek' => $request->catatan_warek,
            'tanggal_persetujuan' => null
        ]);
        $namaMk = $jadwal->mata_kuliah->nama_mata_kuliah;
        $nimk = $jadwal->mata_kuliah->kode ?? '-';
        $pesan = "Jadwal {$namaMk} [Kode: {$nimk}] dikembalikan revisi oleh Warek 1. Catatan: {$jadwal->catatan_warek}";
        $this->sendNotifToRoles(['akademik'], 'revisi', $pesan); // Hanya ke akademik

        return back()->with('success', 'Jadwal dikembalikan revisi (notifikasi dikirim ke Akademik)');
    }

    public function setujuiSemua(Request $request)
{
    // Ambil semua jadwal yang status 'diajukan' atau 'revisi'
    $jadwals = \App\Models\JadwalKuliah::whereIn('status', ['diajukan', 'revisi'])->get();
    foreach ($jadwals as $jadwal) {
        $jadwal->update([
            'status' => 'disetujui',
            'tanggal_persetujuan' => now(),
            'catatan_warek' => null,
        ]);
        // Kirim notifikasi ke akademik
        $namaMk = $jadwal->mata_kuliah->nama_mata_kuliah ?? '';
        $nimk = $jadwal->mata_kuliah->kode ?? '-';
        $pesan = "Jadwal {$namaMk} [Kode: {$nimk}] telah disetujui oleh Warek 1.";
        $this->sendNotifToRoles(['akademik'], 'disetujui', $pesan);
    }
    return back()->with('success', 'Semua jadwal berhasil disetujui.');
}

    /**
     * Helper kirim notifikasi hanya ke role target, bukan pengirim/diri sendiri, tidak role lain
     */
    private function sendNotifToRoles(array $roles, string $type, string $pesan)
    {
        $userIds = User::whereIn('role', $roles)
            ->where('id', '!=', Auth::id())
            ->pluck('id')
            ->toArray();

        if (empty($userIds)) return;

        $notif = Notification::create([
            'author_name' => 'Wakil Rektor 1',
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
