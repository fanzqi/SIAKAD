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
                                <!-- Export Excel -->
                                <a href="{{ route('jadwalkuliah.export.excel') }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                                </a>
                                <!-- Export PDF -->
                                <a href="{{ route('jadwal.pdf.all') }}" class="btn btn-danger btn-sm">
                                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                                </a>
                                <form action="{{ route('jadwalkuliah.kirim.warek') }}" method="POST"
                                    onsubmit="return confirm('Kirim semua jadwal ke Warek 1?')">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <i class="bi bi-send"></i> Kirim ke Warek 1
                                    </button>
                                </form>

                                <form action="{{ route('jadwalkuliah.kirim.warek') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <i class="bi bi-send"></i> Distribusikan Jadwal
                                    </button>
                                </form>



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
                                                <span class="badge bg-warning">Draft</span>
                                            @elseif($jadwals->status == 'diajukan')
                                                <span class="badge bg-info">Diajukan</span>
                                            @elseif($jadwals->status == 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($jadwals->status == 'revisi')
                                                <span class="badge bg-danger">Revisi</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('jadwalkuliah.edit', $jadwals->id) }}"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="bukaModalHapus('{{ route('jadwalkuliah.destroy', $jadwals->id) }}')">
                                                Hapus
                                            </button>
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
    <!-- Modal Hapus -->
    <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi Hapus
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                    <br>
                    <small class="text-muted">Data yang sudah dihapus tidak dapat dikembalikan.</small>
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
    <script>
        function bukaModalHapus(actionUrl) {
            document.getElementById('formHapus').action = actionUrl;
            $('#modalHapus').modal('show');
        }
    </script>

@endsection
