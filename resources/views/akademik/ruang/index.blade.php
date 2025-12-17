@extends('layouts.main')

@section('title', 'Ruang')

@section('content')

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ruang.index') }}">Ruangan</a></li>
            </ol>
        </div>
    </div>

    <!-- Floating Alerts -->
    <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 300px;">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        @if (session('edit'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Diperbarui!</strong> {{ session('edit') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        @if (session('delete'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Terhapus!</strong> {{ session('delete') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h4 class="card-title">Daftar Ruang</h4>

                    <div class="d-flex justify-content-between mb-3">
                        <div></div>
                        <div>
                            <a href="{{ route('ruang.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg"></i> Tambah Ruangan
                            </a>
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#importModal">
                                <i class="bi bi-file-earmark-excel"></i> Import Excel
                            </button>
                        </div>
                    </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Ruang</th>
                                        <th>Kapasitas</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($ruangs as $ruang)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ruang->nama_ruang }}</td>
                                            <td>{{ $ruang->kapasitas }}</td>
                                            <td>{{ $ruang->jam_mulai }}</td>
                                            <td>{{ $ruang->jam_selesai }}</td>
                                            <td>
                                                <a href="{{ route('ruang.edit', $ruang->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>

                                          <button type="button" class="btn btn-sm btn-danger"
    onclick="bukaModalHapus('{{ route('ruang.destroy', $ruang->id) }}')">
    Hapus
</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada data.</td>
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

<!-- Modal Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Ruang dari Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <form action="{{ route('ruang.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="file">Pilih File Excel (.xlsx)</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Import</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
function bukaModalHapus(actionUrl) {
    document.getElementById('formHapus').action = actionUrl;
    $('#modalHapus').modal('show');
}
</script>
