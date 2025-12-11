<?php

namespace App\Http\Controllers\Akademik;
use App\Http\Controllers\Controller;
use App\Models\Ruang;
use Illuminate\Http\Request;


class RuangController extends Controller
{
    public function index()
    {
        $ruangs = Ruang::all();
        return view('akademik.ruang.index', compact('ruangs'));
    }

    public function create()
    {
        return view('akademik.ruang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        Ruang::create($request->all());

        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil ditambahkan.');
    }

   public function edit($id)
{
    $ruang = Ruang::findOrFail($id);
    return view('akademik.ruang.edit', compact('ruang'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama_ruang' => 'required|string|max:255',
        'kapasitas' => 'required|integer|min:1',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required|after:jam_mulai',
    ]);

    $ruang = Ruang::findOrFail($id);
    $ruang->update($request->all());

    return redirect()->route('ruang.index')->with('edit', 'Ruang berhasil diperbarui.');
}

public function destroy($id)
{
    $ruang = Ruang::findOrFail($id);
    $ruang->delete();

    return redirect()->route('ruang.index')->with('delete', 'Ruang berhasil dihapus.');
}
}
