<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\mata_kuliah;
use App\Models\Dosen;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    /**
     * Display list data
     */
    public function index()
    {
        // Load relasi dosen agar bisa menampilkan nama dosen
        $data = mata_kuliah::with('dosen')->get();
        return view('akademik.matakuliah.index', compact('data'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        // Ambil semua dosen untuk dropdown
        $dosens = Dosen::all();
        return view('akademik.matakuliah.create', compact('dosens'));
    }

    /**
     * Store data
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:mata_kuliah,kode',
            'nama_mata_kuliah' => 'required|string',
            'dosen_id' => 'required|exists:dosen,id', // validasi FK
            'fakultas' => 'required|string',
            'program_studi' => 'required|string',
            'sks' => 'required|integer|min:1',
            'group' => 'nullable|string',
        ]);

        Mata_kuliah::create($request->all());

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $data = Mata_kuliah::findOrFail($id);
        $dosens = Dosen::all(); // dropdown dosen
        return view('akademik.matakuliah.edit', compact('data', 'dosen'));
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|unique:mata_kuliah,kode,' . $id . ',id',
            'nama_mata_kuliah' => 'required|string',
            'dosen_id' => 'required|exists:dosen,id', // validasi FK
            'fakultas' => 'required|string',
            'program_studi' => 'required|string',
            'sks' => 'required|integer|min:1',
            'group' => 'nullable|string',
        ]);

        $data = Mata_kuliah::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Delete data
     */
    public function destroy($id)
    {
        $data = Mata_kuliah::findOrFail($id);
        $data->delete();

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}