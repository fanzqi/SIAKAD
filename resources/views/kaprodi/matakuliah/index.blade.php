@extends('layouts.main')

@section('title', 'Mata Kuliah')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('kaprodi/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('matakuliah.index') }}">Mata Kuliah</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Mata Kuliah</a></li>
        </ol>
    </div>
</div>
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
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Mata Kuliah</h5>
                        <a href="{{ route('matakuliah.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Tambah Mata Kuliah
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode</th>
                                        <th>Mata Kuliah</th>
                                        <th>Dosen</th>
                                        <th>Fakultas</th>
                                        <th>Program Studi</th>
                                        <th>SKS</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $index => $mata_kuliah)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                <td>{{ $mata_kuliah->kode }}</td>
                                <td>{{ $mata_kuliah->nama_mata_kuliah }}</td>
                                <td>{{ $mata_kuliah->dosen }}</td>
                                <td>{{ $mata_kuliah->fakultas }}</td>
                                <td>{{ $mata_kuliah->program_studi }}</td>
                                <td>{{ $mata_kuliah->sks }}</td>
                                        <td>
                                            <a href="{{ route('matakuliah.edit', $mata_kuliah->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                              <!-- Tombol Delete -->
                                                <form action="{{ route('matakuliah.destroy', $mata_kuliah->id) }}"
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
                                <td colspan="8" class="text-center">Data tidak ditemukan</td>
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
