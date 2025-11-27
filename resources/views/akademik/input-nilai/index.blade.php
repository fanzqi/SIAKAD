@extends('layouts.main')

@section('title', 'Input Nilai')

@section('content')
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
                        <h5 class="mb-0">Daftar Input Nilai</h5>
                        <a href="{{ route('input-nilai.create') }}" class="btn btn-primary btn-sm">
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
                                                <a href="{{ route('input-nilai.edit', $nilai->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <!-- Tombol Delete -->
                                                <form action="{{ route('input-nilai.destroy', $nilai->id) }}"
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
