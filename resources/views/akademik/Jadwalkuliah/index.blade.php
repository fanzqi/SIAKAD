@extends('layouts.main')

@section('title', 'Jadwal Kuliah')

@section('content')

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jadwalkuliah.index') }}">Jadwal Kuliah</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Jadwal Kuliah</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h4 class="card-title">Daftar Jadwal Kuliah</h4>

                        <!-- Tambah Data -->
                        <a href="{{ route('jadwalkuliah.create') }}" class="btn btn-primary btn-sm mb-3">
                            <i class="bi bi-plus-lg"></i> Tambah Jadwal Kuliah
                        </a>

                        <!-- Export Excel -->
                        <a href="{{ route('jadwalkuliah.export.excel') }}" class="btn btn-success btn-sm mb-3">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </a>


                        <!-- Export PDF -->
                        <a href="" class="btn btn-danger btn-sm mb-3">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </a>

                        <!-- Submit Jadwal -->
                        <div class="btn-group mb-3">
                            <button type="button" class="btn btn-info btn-sm " data-bs-toggle="dropdown">
                                <i class="bi bi-send"></i> Kirim ke Warek 1
                            </button>
                        </div>

                        <div>
                            <button type="button" class="btn btn-info btn-sm " data-bs-toggle="dropdown">
                                <i class="bi bi-send"></i> Distribusikan Jadwal
                            </button>
                        </div> {{-- Alert --}}
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


                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Mata Kuliah</th>
                                        <th>Dosen</th>
                                        <th>Program Studi</th>
                                        <th>Smt</th>
                                        <th>Group</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>Ruangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($jadwal as $index => $jadwals)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jadwals->mata_kuliah->nama_mata_kuliah }}</td>
                                            <td>{{ $jadwals->mata_kuliah->dosen }}</td>
                                            <td>{{ $jadwals->mata_kuliah->program_studi }}</td>
                                            <td>{{ $jadwals->semester }}</td>
                                           <td>{{ $jadwals->mata_kuliah->group }}</td>

                                            <td>{{ $jadwals->hari }}</td>
                                            <td>{{ $jadwals->jam_mulai }} - {{ $jadwals->jam_selesai }}</td>
                                            <td>{{ $jadwals->ruang->nama_ruang }}</td>
                                            <td>
                                                <a href="{{ route('jadwalkuliah.edit', $jadwals->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>

                                                <form action="{{ route('jadwalkuliah.destroy', $jadwals->id) }}"
                                                    method="POST" style="display:inline-block"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Data tidak ditemukan</td>
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
