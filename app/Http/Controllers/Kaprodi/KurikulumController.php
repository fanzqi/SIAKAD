<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    // Menampilkan daftar kurikulum
    public function index()
    {
        $kurikulums = Kurikulum::with('tahunAkademik')->get();
        return view('kaprodi.kurikulum.index', compact('kurikulums'));
    }

    // Form tambah kurikulum
  public function create()
    {
        // Ambil Tahun Akademik yang statusnya Aktif
        $tahunAktif = TahunAkademik::where('status', 'Aktif')->first();

        // Jika tidak ada Tahun Akademik aktif, redirect
        if (!$tahunAktif) {
            return redirect()->route('input-nilai.index')
                ->with('error', 'Tidak ada Tahun Akademik aktif.');
        }

        // Kirim $tahunAktif ke view
        return view('kaprodi.kurikulum.create', compact('tahunAktif'));
    }


    // Menyimpan kurikulum baru
    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'kode_mk' => 'required|string',
            'nama_mk' => 'required|string',
            'sks' => 'required|integer',
            'wajib_pilihan' => 'required|in:Wajib,Pilihan',
            'prasyarat' => 'nullable|string',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $kurikulum = Kurikulum::create($request->only([
            'tahun_akademik_id',
            'kode_mk',
            'nama_mk',
            'sks',
            'wajib_pilihan',
            'prasyarat',
            'status',
        ]));

        return redirect()->route('kurikulum.index')->with('success', 'Kurikulum berhasil ditambahkan.');
    }

    // Form edit kurikulum
    public function edit($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulums = Kurikulum::where('id', '!=', $id)->get();
        $tahunAkademikList = TahunAkademik::all();

        return view('kaprodi.kurikulum.edit', compact('kurikulum', 'kurikulums', 'tahunAkademikList'));
    }

    // Update kurikulum
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'kode_mk' => 'required|string',
            'nama_mk' => 'required|string',
            'sks' => 'required|integer',
            'wajib_pilihan' => 'required|in:Wajib,Pilihan',
            'prasyarat' => 'nullable|string',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulum->update($request->only([
            'tahun_akademik_id',
            'kode_mk',
            'nama_mk',
            'sks',
            'wajib_pilihan',
            'prasyarat',
            'status',
        ]));

        return redirect()->route('kurikulum.index')->with('edit', 'Kurikulum berhasil diperbarui.');
    }

    // Hapus kurikulum
    public function destroy($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulum->delete();

        return redirect()->route('kurikulum.index')->with('delete', 'Kurikulum berhasil dihapus.');
    }
}
