@extends('layouts.main')

@section('title', 'Monitoring Nilai Dosen')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Monitoring Nilai</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Monitoring Nilai Dosen</h4>

                        <form method="GET" action="{{ route('akademik.monitoringnilai.index') }}" class="row g-2">
                            <div class="col-md-4">
                                <label class="fw-bold">Tahun Akademik</label>
                                <select name="tahun_akademik_id" class="form-control">
                                    <option value="">-- Pilih Tahun Akademik --</option>
                                    @foreach ($tahunAkademikList as $ta)
                                        <option value="{{ $ta->id }}"
                                            {{ $tahunAkademikId == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->kode_semester }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-4">
                                <label class="fw-bold">Fakultas</label>
                                <select name="fakultas_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">-- Semua Fakultas --</option>
                                    @foreach ($fakultasList as $f)
                                        <option value="{{ $f->id }}" {{ $fakultasId == $f->id ? 'selected' : '' }}>
                                            {{ $f->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Ganti fakultas akan auto submit untuk memfilter prodi.</small>
                            </div>

                            <div class="col-md-4">
                                <label class="fw-bold">Prodi</label>
                                <select name="prodi_id" class="form-control">
                                    <option value="">-- Semua Prodi --</option>
                                    @foreach ($prodiList as $p)
                                        <option value="{{ $p->id }}" {{ $prodiId == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mt-2">
                                <button class="btn btn-primary">Tampilkan</button>
                                <a href="{{ route('akademik.monitoringnilai.index') }}" class="btn btn-light">Reset</a>
                            </div>
                        </form>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-2">Rekap Per Fakultas</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Fakultas</th>
                                                <th>Seharusnya</th>
                                                <th>Sudah Input</th>
                                                <th>%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($rekapFakultas as $rf)
                                                <tr>
                                                    <td>{{ $rf->nama_fakultas ?? '-' }}</td>
                                                    <td>{{ $rf->expected_total }}</td>
                                                    <td>{{ $rf->input_total }}</td>
                                                    <td>{{ $rf->persen }}%</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Tidak ada data.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-2">Rekap Per Prodi</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Prodi</th>
                                                <th>Seharusnya</th>
                                                <th>Sudah Input</th>
                                                <th>%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($rekapProdi as $rp)
                                                <tr>
                                                    <td>{{ $rp->nama_prodi ?? '-' }}</td>
                                                    <td>{{ $rp->expected_total }}</td>
                                                    <td>{{ $rp->input_total }}</td>
                                                    <td>{{ $rp->persen }}%</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Tidak ada data.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-2">Detail Per Dosen</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIDN</th>
                                        <th>Nama Dosen</th>
                                        <th>Fakultas</th>
                                        <th>Prodi</th>
                                        <th>MK Diampu</th>
                                        <th>Seharusnya Input</th>
                                        <th>Sudah Input</th>
                                        <th>% Progress</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rows as $i => $r)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $r->nidn }}</td>
                                            <td>{{ $r->nama_dosen }}</td>
                                            <td>{{ $r->nama_fakultas ?? '-' }}</td>
                                            <td>{{ $r->nama_prodi ?? '-' }}</td>
                                            <td>{{ $r->mk_total }}</td>
                                            <td>{{ $r->expected_total }}</td>
                                            <td>{{ $r->input_total }}</td>
                                            <td>{{ $r->persen }}%</td>
                                            <td>
                                                @if ($r->expected_total == 0)
                                                    <span class="badge badge-secondary">Tidak ada KRS</span>
                                                @elseif($r->persen >= 100)
                                                    <span class="badge badge-success">Selesai</span>
                                                @elseif($r->persen >= 50)
                                                    <span class="badge badge-warning">Proses</span>
                                                @else
                                                    <span class="badge badge-danger">Belum</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-muted">Data tidak ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <small class="text-muted d-block mt-2">
                            Catatan: “Seharusnya Input” dihitung dari jumlah KRS pada tahun akademik terpilih untuk semua MK
                            yang diampu dosen.
                        </small>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
