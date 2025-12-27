@extends('layouts.main')

@section('title', 'Daftar Mata Kuliah')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('matakuliah.index') }}">Mata Kuliah</a></li>
                <li class="breadcrumb-item active">Daftar Mata Kuliah</li>
            </ol>
        </div>
    </div>

    {{-- Alert --}}
    <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 300px;">
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

    <div class="container-fluid mt-4 px-4">
        <div class="card shadow-sm w-100" style="width: 100%;">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Mata Kuliah</h5>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('matakuliah.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Mata Kuliah
                    </a>
                    <form id="form-generate-jadwal" action="{{ route('generate.jadwal.smart') }}" method="POST"
                        class="mt-2 d-flex align-items-center justify-content-center">
                        @csrf
                        <button type="submit" class="btn btn-success d-flex align-items-center">
                            <i class="bi bi-gear-fill me-2"></i>
                            Generate Jadwal Otomatis
                        </button>
                    </form>
                </div>
            </div>


            <div class="table-responsive">
                <table id="datatable-mk" class="table table-striped table-bordered zero-configuration">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Fakultas</th>
                            <th>Program Studi</th>
                            <th>SKS</th>
                            <th>Group</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $mk)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mk->kode }}</td>
                                <td>{{ $mk->nama_mata_kuliah }}</td>
                                <td>{{ $mk->dosen ? $mk->dosen->nama : '-' }}</td>
                                <td>{{ $mk->fakultas ? $mk->fakultas->nama : '-' }}</td>
                                <td>{{ $mk->program_studi ? $mk->program_studi->nama : '-' }}</td>
                                <td>{{ $mk->sks }}</td>
                                <td>{{ $mk->group }}</td>
                                {{-- <td>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('matakuliah.edit', $mk->id) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="bukaModalHapus('{{ route('matakuliah.destroy', $mk->id) }}')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- POPUP PROSES --}}
    <div id="popup-generate"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); z-index:9999; text-align:center; padding-top:12%;">
        <div style="background:white; padding:25px; width:400px; margin:auto; border-radius:10px; text-align:left;">
            <h5 style="color:#4b35ff; margin-bottom:5px;">Proses Generate Jadwal</h5>
            <small>Sedang melakukan pemrosesan...</small>
            <div style="width:100%; height:20px; background:#dcdcdc; border-radius:10px; margin-top:10px; overflow:hidden;">
                <div id="progress-bar" style="height:100%; width:0%; background:#4b35ff; transition:width 0.3s;"></div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('form-generate-jadwal').addEventListener('submit', function(e) {
            e.preventDefault(); // cegah submit default agar bisa tampilkan popup

            const popup = document.getElementById('popup-generate');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.createElement('span');
            progressText.id = 'progress-percent';
            progressText.style.float = 'right';
            progressText.style.fontWeight = 'bold';

            // Tambahkan progressText ke dalam progress bar jika belum ada
            if (!document.getElementById('progress-percent')) {
                progressBar.parentNode.appendChild(progressText);
            }

            popup.style.display = 'block';

            let width = 0;
            const small = popup.querySelector('small');
            const interval = setInterval(() => {
                if (width >= 100) {
                    clearInterval(interval);
                    progressText.textContent = '100%';
                    small.textContent = 'Selesai! Mengirim permintaan...';
                    setTimeout(() => {
                        e.target.submit();
                    }, 500);
                } else {
                    width += 5;
                    progressBar.style.width = width + '%';
                    progressText.textContent = width + '%';
                    small.textContent = `Sedang melakukan pemrosesan... (${width}%)`;
                }
            }, 100);
        });
    </script>


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
                    <form id="formHapus" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-danger">
                            Hapus
                        </button>
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
