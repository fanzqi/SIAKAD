@extends('layouts.main')

@section('title', 'Jadwal Mengajar Dosen')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('dosen/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="javascript:void(0)">Jadwal Mengajar</a>
            </li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="card-title">Jadwal Mengajar</h4>
                    <h6 class="mb-3">
                        Dosen: {{ $dosen->nama }}
                    </h6>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Mata Kuliah</th>
                                    <th>Jam</th>
                                    <th>Group</th>
                                    <th>Ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwal as $index => $j)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $j->hari }}</td>
                                    <td>{{ $j->mata_kuliah->nama_mata_kuliah ?? '-' }}</td>
                                    <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                                    <td>{{ $j->mata_kuliah->group ?? '-' }}</td>
                                    <td>{{ $j->ruang->nama_ruang ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Belum ada jadwal yang didistribusikan
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
</div>

@endsection