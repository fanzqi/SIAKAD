@extends('layouts.main')

@section('title', 'Jadwal Kuliah Mahasiswa')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('mahasiswa/dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="javascript:void(0)">Jadwal Kuliah</a>
            </li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="card-title">Jadwal Kuliah</h4>
                    <div class="table-responsive">
                        <table id="datatable-jadwal" class="table table-bordered table-striped zero-configuration">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Mata Kuliah</th>
                                    <th>Jam</th>
                                    <th>Dosen</th>
                                    <th>Group</th>
                                    <th>Ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwal as $j)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $j->hari }}</td>
                                        <td>{{ $j->mata_kuliah->nama_mata_kuliah ?? '-' }}</td>
                                        <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                                        <td>{{ $j->mata_kuliah->dosen->nama ?? '-' }}</td>
                                        <td>{{ $j->mahasiswa->mahasiswa->grup_id ?? '-' }}</td>
                                        <td>{{ $j->ruang->nama_ruang ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Jadwal belum tersedia</td>
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
