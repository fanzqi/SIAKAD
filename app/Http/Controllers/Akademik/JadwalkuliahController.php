<?php

namespace App\Http\Controllers\Akademik;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Jadwalkuliah;

class JadwalkuliahController extends Controller
{
    public function index()
    {
        $jadwals = Jadwalkuliah::all();
        return view('akademik.jadwalkuliah.index', compact('jadwals'));
    }

    public function create()
    {
        return view('akademik.jadwalkuliah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_kuliah' => 'required',
            'dosen' => 'required',
            'program_studi' => 'required',
            'semester' => 'required|integer',
            'hari' => 'required',
            'jam' => 'required',
            'ruangan' => 'required'
        ]);

        Jadwalkuliah::create($request->all());
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(Jadwalkuliah $jadwal)
    {
        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, Jadwalkuliah $jadwal)
    {
        $request->validate([
            'mata_kuliah' => 'required',
            'dosen' => 'required',
            'program_studi' => 'required',
            'semester' => 'required|integer',
            'hari' => 'required',
            'jam' => 'required',
            'ruangan' => 'required'
        ]);

        $jadwal->update($request->all());
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(Jadwalkuliah $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
