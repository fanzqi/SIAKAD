<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\PlotingDosen;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class PlotingdosenController extends Controller
{
    /**
     * Display list data
     */
    public function index()
    {
        // eager loading relasi semester
        $data = PlotingDosen::with('tahunAkademik')->get();

        return view('kaprodi.plotingdosen.index', compact('data'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        // data semester untuk select option
        $tahunAkademik = TahunAkademik::all();

        return view('kaprodi.plotingdosen.create', compact('tahunAkademik'));
    }

    /**
     * Store data
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mata_kuliah_id' => 'required|integer',
            'dosen'              => 'required|string',
            'kelas'              => 'required|string',
            'semester_id'        => 'required|integer|exists:tahun_akademik,id',
            'status'             => 'required|in:Diterima,Proses,Ditolak',
        ]);

        PlotingDosen::create([
            'nama_mata_kuliah_id' => $request->nama_mata_kuliah_id,
            'dosen'              => $request->dosen,
            'kelas'              => $request->kelas,
            'semester_id'        => $request->semester_id,
            'status'             => $request->status,
        ]);

        return redirect()->route('plotingdosen.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $data = PlotingDosen::findOrFail($id);
        $tahunAkademik = TahunAkademik::all();

        return view('kaprodi.plotingdosen.edit', compact('data', 'tahunAkademik'));
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mata_kuliah_id' => 'required|integer',
            'dosen'              => 'required|string',
            'kelas'              => 'required|string',
            'semester_id'        => 'required|integer|exists:tahun_akademik,id',
            'status'             => 'required|in:Diterima,Proses,Ditolak',
        ]);

        $data = PlotingDosen::findOrFail($id);

        $data->update([
            'nama_mata_kuliah_id' => $request->nama_mata_kuliah_id,
            'dosen'              => $request->dosen,
            'kelas'              => $request->kelas,
            'semester_id'        => $request->semester_id,
            'status'             => $request->status,
        ]);

        return redirect()->route('plotingdosen.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Delete data
     */
    public function destroy($id)
    {
        $data = PlotingDosen::findOrFail($id);
        $data->delete();

        return redirect()->route('plotingdosen.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
