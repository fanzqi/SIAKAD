<?php

namespace App\Http\Controllers\Kaprodi;
use App\Http\Controllers\Controller;
use App\Models\mata_kuliah;
use Illuminate\Http\Request;




class MatakuliahController extends Controller
{
    /**
     * Display list data
     */
    public function index()
    {
        $data = mata_kuliah::all();
        return view('kaprodi.matakuliah.index', compact('data'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('kaprodi.matakuliah.create');
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

        mata_kuliah::create($request->all());

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $data = mata_kuliah::findOrFail($id);
        return view('kaprodi.matakuliah.edit', compact('data'));
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

        $data = mata_kuliah::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Delete data
     */
    public function destroy($id)
    {
        $data = mata_kuliah::findOrFail($id);
        $data->delete();

        return redirect()->route('matakuliah.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}