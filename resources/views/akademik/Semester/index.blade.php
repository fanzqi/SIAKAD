@extends('layouts.main')

@section('title', 'Semester')

@section('content')

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Semester</a></li>
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

    <!-- CONTENT -->
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
                            <table id="table-semester" class="table table-striped table-bordered zero-configuration">
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
                                                <span
                                                    class="badge
                                                {{ $status === 'aktif' ? 'badge-success' : ($status === 'ditutup' ? 'badge-danger' : 'badge-secondary') }}">
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('semester.edit', $semester->id) }}"
                                                        class="btn btn-warning btn-sm me-1" title="Edit">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="bukaModalHapus('{{ route('semester.destroy', $semester->id) }}')">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>


                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                Belum ada data semester.
                                            </td>
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

    {{-- MODAL KONFIRMASI HAPUS --}}
    <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle-fill mr-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                    <br>
                    <small class="text-muted">
                        Data yang sudah dihapus tidak dapat dikembalikan.
                    </small>
                </div>

                <div class="modal-footer">
                    <form id="formHapus" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>



                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- SCRIPT MODAL HAPUS --}}
    <script>
        function bukaModalHapus(actionUrl) {
            document.getElementById('formHapus').action = actionUrl;
            $('#modalHapus').modal('show');
        }
    </script>

@endsection
