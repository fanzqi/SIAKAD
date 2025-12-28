<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TahunAkademik;
use App\Models\Fakultas;
use App\Models\ProgramStudi;

class MonitoringNilaiController extends Controller
{
    public function index(Request $request)
    {
        // =========================
        // Dropdown Tahun Akademik
        // =========================
        $tahunAkademikList = TahunAkademik::orderBy('id', 'desc')->get();

        // status di tabel kamu: "aktif" (lowercase)
        $tahunAktif = TahunAkademik::whereIn('status', ['aktif', 'Aktif'])->orderBy('id', 'desc')->first();

        // ✅ AMBIL DARI REQUEST (dropdown), fallback ke TA aktif
        $tahunAkademikId = (int) $request->get('tahun_akademik_id', ($tahunAktif->id ?? 1));

        // =========================
        // Dropdown Fakultas & Prodi
        // =========================
        $fakultasList = Fakultas::orderBy('nama', 'asc')->get();
        $fakultasId = $request->get('fakultas_id');

        $prodiList = ProgramStudi::when($fakultasId, fn ($q) => $q->where('fakultas_id', $fakultasId))
            ->whereNull('deleted_at')
            ->orderBy('nama', 'asc')
            ->get();

        $prodiId = $request->get('prodi_id');

        // =========================
        // DETAIL PER DOSEN (ROWS)
        // =========================
        $detailDosen = DB::table('dosen as d')
            ->leftJoin('fakultas as f', 'f.id', '=', 'd.fakultas_id')
            ->leftJoin('program_studi as ps', 'ps.id', '=', 'd.prodi_id')
            ->when($fakultasId, fn ($q) => $q->where('d.fakultas_id', $fakultasId))
            ->when($prodiId, fn ($q) => $q->where('d.prodi_id', $prodiId))
            ->select([
                'd.id as dosen_id',
                'd.nidn',
                'd.nama as nama_dosen',
                'f.nama as nama_fakultas',
                DB::raw('ps.nama as nama_prodi'),
            ])
            ->addSelect([
                // ✅ mk_total: jumlah mata kuliah yang diampu dosen
                DB::raw("(
                    SELECT COUNT(*)
                    FROM mata_kuliah mk3
                    WHERE mk3.dosen_id = d.id
                ) AS mk_total"),

                // ✅ input_total: jumlah nilai yang sudah diinput pada TA terpilih
                DB::raw("(
                    SELECT COUNT(*)
                    FROM nilai_mahasiswa nm
                    WHERE nm.dosen_id = d.id
                      AND nm.tahun_akademik_id = {$tahunAkademikId}
                ) AS input_total"),

                // ✅ expected_total:
                // jumlah mahasiswa unik dari KRS untuk MK dosen tsb
                // tapi hanya yang relevan terhadap TA yg dipilih (EXISTS nilai_mahasiswa)
                DB::raw("(
                    SELECT COUNT(DISTINCT krs.mahasiswa_id)
                    FROM krs
                    JOIN mata_kuliah mk ON mk.id = krs.mata_kuliah_id
                    WHERE mk.dosen_id = d.id
                      AND EXISTS (
                          SELECT 1
                          FROM nilai_mahasiswa nm2
                          WHERE nm2.mahasiswa_id = krs.mahasiswa_id
                            AND nm2.mata_kuliah_id = krs.mata_kuliah_id
                            AND nm2.dosen_id = d.id
                            AND nm2.tahun_akademik_id = {$tahunAkademikId}
                      )
                ) AS expected_total"),
            ])
            ->orderBy('nama_fakultas', 'asc')
            ->orderBy('nama_prodi', 'asc')
            ->orderBy('nama_dosen', 'asc')
            ->get()
            ->map(function ($row) {
                $expected = (int) ($row->expected_total ?? 0);
                $input    = (int) ($row->input_total ?? 0);

                $row->expected_total = $expected;
                $row->input_total    = $input;
                $row->mk_total       = (int) ($row->mk_total ?? 0);

                // persen input
                $row->persen = $expected > 0 ? round(($input / $expected) * 100, 2) : 0;

                return $row;
            });

        // ✅ VIEW KAMU PAKAI $rows
        $rows = $detailDosen;

        // =========================
        // REKAP FAKULTAS
        // =========================
        $rekapFakultas = $detailDosen
            ->groupBy('nama_fakultas')
            ->map(function ($items, $namaFakultas) {
                $expected = (int) $items->sum('expected_total');
                $input    = (int) $items->sum('input_total');

                return (object) [
                    'nama_fakultas'  => $namaFakultas,
                    'expected_total' => $expected,
                    'input_total'    => $input,
                    'persen'         => $expected > 0 ? round(($input / $expected) * 100, 2) : 0,
                ];
            })
            ->values();

        // =========================
        // REKAP PRODI
        // =========================
        $rekapProdi = $detailDosen
            ->groupBy('nama_prodi')
            ->map(function ($items, $namaProdi) {
                $expected = (int) $items->sum('expected_total');
                $input    = (int) $items->sum('input_total');

                return (object) [
                    'nama_prodi'     => $namaProdi,
                    'expected_total' => $expected,
                    'input_total'    => $input,
                    'persen'         => $expected > 0 ? round(($input / $expected) * 100, 2) : 0,
                ];
            })
            ->values();

        // =========================
        // RETURN VIEW (PAKAI ARRAY BUKAN COMPACT)
        // =========================
        return view('akademik.monitoringnilai.index', [
            'tahunAkademikList' => $tahunAkademikList,
            'tahunAkademikId'   => $tahunAkademikId,
            'fakultasList'      => $fakultasList,
            'fakultasId'        => $fakultasId,
            'prodiList'         => $prodiList,
            'prodiId'           => $prodiId,

            'detailDosen'       => $detailDosen,
            'rekapFakultas'     => $rekapFakultas,
            'rekapProdi'        => $rekapProdi,

            'rows'              => $rows, // ✅ biar view kamu tidak error
        ]);
    }
}