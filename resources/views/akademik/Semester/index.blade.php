@extends('layouts.main')

@section('title', 'Semester')

@section('content')
    @php
        $segments = request()->segments();
        // Treat 'akademik' as the dashboard root and remove it from segments to avoid duplication
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

        <!-- Alert Tambah -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Alert Edit -->
        @if (session('edit'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Diperbarui!</strong> {{ session('edit') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Alert Hapus -->
        @if (session('delete'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Terhapus!</strong> {{ session('delete') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

    </div>


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
                                                <a href="{{ route('semester.edit', $semester->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <form action="{{ route('semester.destroy', $semester->id) }}"
                                                    method="POST" style="display: inline-block;">
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




@endsection
