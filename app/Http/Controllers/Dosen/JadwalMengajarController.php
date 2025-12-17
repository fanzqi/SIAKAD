<?php

namespace App\Http\Controllers\Kaprodi;
use App\Http\Controllers\Controller;
use App\Models\JadwalMengajar;
use Illuminate\Http\Request;




class JadwalMengajarController extends Controller
{
    /**
     * Display list data
     */
    public function index()
    {
        $data = JadwalMengajar::all();
        return view('dosen.jadwal-mengajar.index', compact('data'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('dosen.jadwal-mengajar.create');
    }

    /**
     * Store data
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:mata_kuliah,kode',
            'nama_mata_kuliah' => 'required|string',
            'dosen' => 'required|string',
            'fakultas' => 'required|string',
            'program_studi' => 'required|string',
            'sks' => 'required|integer|min:1',
        ]);

        JadwalMengajar::create($request->all());

        return redirect()->route('jadwal-mengajar.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $data = JadwalMengajar::findOrFail($id);
        return view('dosen.jadwal-mengajar.edit', compact('data'));
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|unique:mata_kuliah,kode,' . $id . ',id',
            'nama_mata_kuliah' => 'required|string',
            'dosen' => 'required|string',
            'fakultas' => 'required|string',
            'program_studi' => 'required|string',
            'sks' => 'required|integer|min:1',
        ]);

        $data = JadwalMengajar::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('jadwal-mengajar.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Delete data
     */
    public function destroy($id)
    {
        $data = JadwalMengajar::findOrFail($id);
        $data->delete();

        return redirect()->route('jadwal-mengajar.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}