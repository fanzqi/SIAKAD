@extends('layouts.main')

@section('title', 'Input Nilai')

@section('content')

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Input Nilai</a></li>
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
                            <table class="table table-striped table-bordered zero-configuration dataTable"
                                id="inputNilaiTable">
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
                                            <td>{{ $nilai->tahunAkademik->semester }}
                                                {{ $nilai->tahunAkademik->tahun_akademik }}</td>
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
                                                <div class="d-flex justify-content-between" style="gap: 8px;">
                                                    <a href="{{ route('input-nilai.edit', $nilai->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm btn-hapus"
                                                        data-url="{{ route('input-nilai.destroy', $nilai->id) }}"
                                                        data-toggle="modal" data-target="#modalHapus">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </div>
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

    {{-- Modal Hapus --}}
    <div class="modal fade" id="modalHapus" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus data ini?<br>
                    <small class="text-muted">Data tidak dapat dikembalikan.</small>
                </div>
                <div class="modal-footer">
                    <form id="formHapus" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formHapus = document.getElementById('formHapus');

            document.addEventListener('click', function(e) {
                const button = e.target.closest('.btn-hapus');
                if (!button) return;
                const url = button.getAttribute('data-url');
                if (!url || !formHapus) return;
                formHapus.setAttribute('action', url);
            });

            // Inisialisasi DataTables
            $('#inputNilaiTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100]
            });
        });
    </script>

@endsection
