@extends('layouts.main')

@section('title', 'Semester')

@section('content')

    {{-- =======================
     DAFTAR SEMESTER
======================== --}}
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Semester</h5>
                        <a href="{{ route('semester.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Tambah Semester
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:5%;">No</th>
                                        <th>Tahun Akademik</th>
                                        <th>Semester</th>
                                        <th style="width:12%;">Status</th>
                                        <th style="width:15%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($semesters as $semester)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $semester->tahun_akademik }}</td>
                                            <td>{{ $semester->semester }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $semester->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $semester->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <form action="{{ route('semester.destroy', $semester->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Hapus data?')">
                                                        Hapus
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data.</td>
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


    {{-- ===========================
     DAFTAR INPUT NILAI
=========================== --}}
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Input Nilai</h5>
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Tambah Input Nilai
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:5%;">No</th>
                                        <th>Semester</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Akhir</th>
                                        <th>Status</th>
                                        <th style="width:15%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($inputNilai as $nilai)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $nilai->tahunAkademik->semester }}
                                                {{ $nilai->tahunAkademik->tahun_akademik }}
                                            </td>
                                            <td>{{ $nilai->deskripsi }}</td>
                                            <td>{{ \Carbon\Carbon::parse($nilai->tanggal_mulai)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($nilai->tanggal_akhir)->format('d-m-Y') }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $nilai->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $nilai->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Hapus data?');">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Belum ada data input nilai.</td>
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
