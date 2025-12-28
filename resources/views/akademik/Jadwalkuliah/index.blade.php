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
                        <div class="mb-3 d-flex justify-content-end">
                            <a href="{{ route('jadwalkuliah.create') }}" class="btn btn-primary btn-sm me-3">
                                <i class="bi bi-plus-lg"></i> Tambah Jadwal Kuliah
                            </a>
                        </div>
                        <div class="mb-3 d-flex justify-content-end">

                            <div class="d-flex" style="gap: 0.75rem;">
                                <button type="button" class="btn btn-success btn-sm btn-konfirmasi"
                                    data-url="{{ route('jadwalkuliah.export.excel') }}"
                                    data-message="Apakah Anda yakin ingin mengekspor semua jadwal ke Excel?">
                                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                                </button>

                                <button type="button" class="btn btn-danger btn-sm btn-konfirmasi"
                                    data-url="{{ route('jadwal.pdf.all') }}"
                                    data-message="Apakah Anda yakin ingin mengekspor semua jadwal ke PDF?">
                                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                                </button>
                                {{-- Tombol Kirim ke Warek 1 --}}
                                <button type="button" class="btn btn-info btn-sm btn-konfirmasi"
                                    data-url="{{ route('jadwalkuliah.kirim.warek') }}"
                                    data-message="Kirim semua jadwal ke Warek 1?">
                                    <i class="bi bi-send"></i> Kirim ke Warek 1
                                </button>

                                {{-- Tombol Distribusikan Jadwal --}}
                                <button type="button" class="btn btn-info btn-sm btn-konfirmasi"
                                    data-url="{{ route('jadwalkuliah.distribusikan') }}"
                                    data-message="Distribusikan semua jadwal?">
                                    <i class="bi bi-send"></i> Distribusikan Jadwal
                                </button>

                            </div>
                        </div>
                    </div>
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

                        @if (session('info'))
                            <div class="alert alert-primary alert-dismissible fade show">
                                <strong>Info!</strong> {{ session('info') }}
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
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($jadwal as $index => $jadwals)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jadwals->mata_kuliah->nama_mata_kuliah }}</td>
                                        <td>{{ $jadwals->mata_kuliah->dosen ? $jadwals->mata_kuliah->dosen->nama : '-' }}
                                        </td>
                                        <td>{{ $jadwals->mata_kuliah->program_studi ? $jadwals->mata_kuliah->program_studi->nama : '-' }}
                                        </td>
                                        <td>{{ $jadwals->semester }}</td>
                                        <td>{{ $jadwals->mata_kuliah->group }}</td>
                                        <td>{{ $jadwals->hari }}</td>
                                        <td>{{ $jadwals->jam_mulai }} - {{ $jadwals->jam_selesai }}</td>
                                        <td>{{ $jadwals->ruang->nama_ruang }}</td>
                                        <td>
                                            @if ($jadwals->status == 'draft')
                                                <span class="badge bg-warning text-white">Draft</span>
                                            @elseif ($jadwals->status == 'diajukan')
                                                <span class="badge bg-info text-white">Diajukan</span>
                                            @elseif ($jadwals->status == 'disetujui')
                                                <span class="badge bg-success text-white">Disetujui</span>
                                            @elseif ($jadwals->status == 'revisi')
                                                <span class="badge bg-danger text-white">Revisi</span>
                                            @elseif ($jadwals->status == 'didistribusi')
                                                <span class="badge bg-primary text-white">Didistribusi</span>
                                            @endif

                                        </td>

                                        <td>
                                            <a href="{{ route('jadwalkuliah.edit', $jadwals->id) }}"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>
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
    {{-- Modal Konfirmasi Universal --}}
    <div class="modal fade" id="modalKonfirmasi" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi Aksi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body" id="modalKonfirmasiBody">
                    <!-- Pesan akan diisi lewat JS -->
                </div>
                <div class="modal-footer">
                    <form id="formKonfirmasi" method="POST">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Ya, Lanjutkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = $('#modalKonfirmasi');
            const form = document.getElementById('formKonfirmasi');
            const modalBody = document.getElementById('modalKonfirmasiBody');

            document.querySelectorAll('.btn-konfirmasi').forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    const message = this.getAttribute('data-message');

                    modalBody.textContent = message;

                    // Untuk export Excel/PDF pakai GET, lainnya POST
                    if (url.includes('export') || url.includes('pdf')) {
                        form.setAttribute('method', 'GET');
                    } else {
                        form.setAttribute('method', 'POST');
                    }

                    form.setAttribute('action', url);
                    modal.modal('show');
                });
            });
        });
    </script>

@endsection
