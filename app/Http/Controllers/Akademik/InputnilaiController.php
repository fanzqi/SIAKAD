<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\InputNilai;
use App\Models\TahunAkademik;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InputNilaiController extends Controller
{
    public function index()
    {
        $inputNilai = InputNilai::with('tahunAkademik')->get();
        return view('akademik.input-nilai.index', compact('inputNilai'));
    }

    public function create()
    {
        $tahunAktif = TahunAkademik::where('status', 'Aktif')->first();
        if (!$tahunAktif) {
            return redirect()->route('input-nilai.index')->with('error', 'Tidak ada Tahun Akademik aktif.');
        }
        return view('akademik.input-nilai.create', compact('tahunAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $inputNilai = InputNilai::create($request->all());

        // Kirim notifikasi ke user dosen, kaprodi, dekan, warek1
        $userRoles = ['dosen', 'kaprodi', 'dekan', 'warek1'];
        $userNotif = User::whereIn('role', $userRoles)->get();

        foreach($userNotif as $user) {
            Notification::create([
                'user_id' => $user->id,
                'author_name' => Auth::user()?->name ?? 'Sistem',
                'type' => 'add',
                'message' => 'Periode Input Nilai "' . $inputNilai->deskripsi . '" untuk Tahun Akademik ' . $inputNilai->tahunAkademik->tahun_akademik . ' telah dimulai'
            ]);
        }

        return redirect()->route('input-nilai.index')->with('success', 'Data input nilai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $inputNilai = InputNilai::findOrFail($id);
        $tahunAkademikList = TahunAkademik::all();
        return view('akademik.input-nilai.edit', compact('inputNilai', 'tahunAkademikList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $inputNilai = InputNilai::findOrFail($id);
        $inputNilai->update($request->all());

        Notification::create([
            'user_id' => Auth::id(),
            'author_name' => Auth::user()?->name ?? 'Sistem',
            'type' => 'edit',
            'message' => 'Mengedit Input Nilai "' . $inputNilai->deskripsi . '" untuk Tahun Akademik ' . $inputNilai->tahunAkademik->tahun_akademik
        ]);

        return redirect()->route('input-nilai.index')->with('edit', 'Data input nilai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $inputNilai = InputNilai::findOrFail($id);
        $info = $inputNilai->deskripsi . ' (' . $inputNilai->tahunAkademik->tahun_akademik . ')';
        $inputNilai->delete();

        Notification::create([
            'user_id' => Auth::id(),
            'author_name' => Auth::user()?->name ?? 'Sistem',
            'type' => 'delete',
            'message' => 'Menghapus Input Nilai ' . $info
        ]);

        return redirect()->route('input-nilai.index')->with('delete', 'Data input nilai berhasil dihapus.');
    }

    
}