@extends('layouts.main')

@section('title', 'Jadwal Kuliah Dekan')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('dekan/dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="javascript:void(0)">Jadwal Kuliah</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        @forelse($program_studi as $prodi)
            @php
                $jadwalProdi = $jadwalPerProdi[$prodi->id] ?? collect();
            @endphp
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title">Jadwal Kuliah Program Studi: {{ $prodi->nama ?? '-' }}</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Hari</th>
                                            <th>Jam</th>
                                            <th>Mata Kuliah</th>
                                            <th>Dosen</th>
                                            <th>Ruang</th>
                                            <th>Group Kelas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($jadwalProdi as $index => $j)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $j->hari }}</td>
                                                <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                                                <td>{{ $j->mata_kuliah->nama_mata_kuliah ?? '-' }}</td>
                                                <td>{{ $j->mata_kuliah->dosen ? $j->mata_kuliah->dosen->nama : '-' }}
                                                </td>
                                                <td>{{ $j->ruang->nama_ruang ?? '-' }}</td>
                                                <td>{{ $j->mata_kuliah->group }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">
                                                    Belum ada jadwal untuk program studi ini
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-warning">Belum ada program studi.</div>
        @endforelse
    </div>
@endsection
