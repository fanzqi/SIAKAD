@extends('layouts.main')

@section('title', 'Input Nilai')

@section('content')

    @php
        $segments = request()->segments();
        if (!empty($segments) && $segments[0] === 'akademik') {
            array_shift($segments);
        }
        $mapping = [
            'ruang' => 'Ruang',
            'jadwal-kuliah' => 'Jadwal Kuliah',
            'monitoring-nilai' => 'Monitoring Nilai',
            'semester' => 'Semester',
        ];
        $base = url('akademik');
        $cumulative = $base;
    @endphp

    {{-- Breadcrumb --}}
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

    {{-- Alert --}}
    <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 330px;">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if (session('edit'))
            <div class="alert alert-info alert-dismissible fade show">
                <strong>Diperbarui!</strong> {{ session('edit') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if (session('delete'))
            <div class="alert alert-warning alert-dismissible fade show">
                <strong>Terhapus!</strong> {{ session('delete') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
    </div>

    {{-- === TEMPLATE SESUAI DATATABLES === --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="card-title">Daftar Input Nilai</h4>
                            <a href="{{ route('input-nilai.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg"></i> Tambah Input Nilai
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Semester</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Akhir</th>
                                        <th>Status</th>
                                        <th style="width: 120px;">Aksi</th>
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
                                                    class="badge {{ $nilai->status == 'Aktif' ? 'badge-success' : 'badge-secondary' }}">
                                                    {{ $nilai->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('input-nilai.edit', $nilai->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <form action="{{ route('input-nilai.destroy', $nilai->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Belum ada data input nilai.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
