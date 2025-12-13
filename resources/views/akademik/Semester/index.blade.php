@extends('layouts.main')

@section('title', 'Semester')

@section('content')

@php
    $segments = request()->segments();
    if (!empty($segments) && $segments[0] === 'akademik') {
        array_shift($segments);
    }

    $mapping = [
        'semester' => 'Semester',
        'jadwal-kuliah' => 'Jadwal Kuliah',
        'monitoring-nilai' => 'Monitoring Nilai',
    ];

    $base = url('akademik');
    $cumulative = $base;
@endphp

<!-- Breadcrumb -->
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>

            @foreach ($segments as $i => $seg)
                @php
                    $cumulative .= '/' . $seg;
                    $isLast = $i === array_key_last($segments);
                    $label = $mapping[$seg] ?? ucwords(str_replace(['-', '_'], ' ', $seg));
                @endphp

                <li class="breadcrumb-item {{ $isLast ? 'active' : '' }}">
                    @if ($isLast)
                        <a href="javascript:void(0)">{{ $label }}</a>
                    @else
                        <a href="{{ $cumulative }}">{{ $label }}</a>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</div>

<!-- Floating Alerts -->
<div style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 300px;">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (session('edit'))
        <div class="alert alert-info alert-dismissible fade show">
            <strong>Diperbarui!</strong> {{ session('edit') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (session('delete'))
        <div class="alert alert-warning alert-dismissible fade show">
            <strong>Terhapus!</strong> {{ session('delete') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
</div>

<!-- === TEMPLATE DATATABLES === -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="card-title mb-0">Daftar Semester</h4>
                        <a href="{{ route('semester.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Tambah Semester
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Akademik</th>
                                    <th>Kode Semester</th>
                                    <th>Semester</th>
                                    <th>Semester Ke</th>
                                    <th>Periode Mulai</th>
                                    <th>Periode Selesai</th>
                                    <th>Status</th>
                                    <th style="width:130px;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($semesters as $semester)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $semester->tahun_akademik }}</td>
                                        <td>{{ $semester->kode_semester }}</td>
                                        <td>{{ $semester->semester }}</td>
                                        <td>{{ $semester->semester_ke }}</td>
                                        <td>{{ $semester->periode_mulai }}</td>
                                        <td>{{ $semester->periode_selesai }}</td>

                                        <td>
                                            @php $status = strtolower($semester->status); @endphp
                                            <span class="badge
                                                @if ($status === 'aktif') badge-success
                                                @elseif($status === 'ditutup') badge-danger
                                                @else badge-secondary @endif">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>

                                        <td>
                                            <a href="{{ route('semester.edit', $semester->id) }}"
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square">Edit</i>
                                            </a>

                                            <form action="{{ route('semester.destroy', $semester->id) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Hapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash">Hapus</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Belum ada data semester.</td>
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
