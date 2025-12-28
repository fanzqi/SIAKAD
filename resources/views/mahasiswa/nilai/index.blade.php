@extends('layouts.main')

@section('title', 'Nilai Mata Kuliah')

@section('content')

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('mahasiswa/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Nilai Mata Kuliah</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="fw-semibold">Rekap Nilai Mata Kuliah</h4>
                <form method="GET">
                    <select name="tahun_akademik_id" class="form-select" onchange="this.form.submit()">
                        <option value="">- Pilih Tahun Akademik -</option>
                        @foreach ($tahunAkademikList as $ta)
                            <option value="{{ $ta->id }}" {{ ($tahunAkademikId ?? '') == $ta->id ? 'selected' : '' }}>
                                {{ $ta->kode_semester }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered zero-configuration">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tahun Akademik</th>
                            <th>Kode MK</th>
                            <th>Nama MK</th>
                            <th>SKS</th>
                            <th>Bobot</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!request('tahun_akademik_id'))
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Silakan pilih Tahun Akademik terlebih dahulu
                                </td>
                            </tr>
                        @elseif ($nilai->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">
                                    Belum ada nilai pada Tahun Akademik ini
                                </td>
                            </tr>
                            @foreach ($nilai as $n)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $n->tahunAkademik->kode_semester }}</td>
                                    <td>{{ $n->mata_kuliah->kode }}</td>
                                    <td>{{ $n->mata_kuliah->nama_mata_kuliah }}</td>
                                    <td>{{ $n->mata_kuliah->sks }}</td>
                                    <td>{{ $n->bobot }}</td>
                                    <td>{{ $n->grade }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
