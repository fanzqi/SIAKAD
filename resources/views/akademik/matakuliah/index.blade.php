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
            <a href="{{ route('matakuliah.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Mata Kuliah
            </a>

        </div>

  {{-- Tombol Generate Jadwal --}}
        <form id="form-generate-jadwal" action="{{ route('generate.jadwal.smart') }}" method="POST" class="p-3">
            @csrf
            <button type="submit" class="btn btn-success">
                Generate Jadwal Otomatis
            </button>
        </form>

        <div class="card-body">
            <div class="table-responsive">

                <table id="datatable-mk" class="table table-striped table-bordered">
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
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $index => $mk)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mk->kode }}</td>
                                <td>{{ $mk->nama_mata_kuliah }}</td>
                                <td>{{ $mk->dosen }}</td>
                                <td>{{ $mk->fakultas }}</td>
                                <td>{{ $mk->program_studi }}</td>
                                <td>{{ $mk->sks }}</td>
                                <td>{{ $mk->group }}</td>
                                <td>
                                    <a href="{{ route('matakuliah.edit', $mk->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('matakuliah.destroy', $mk->id) }}"
                                          method="POST"
                                          style="display:inline-block"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

{{-- POPUP PROSES --}}
<div id="popup-generate"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
        background:rgba(0,0,0,0.5); z-index:9999; text-align:center; padding-top:12%;">

    <div style="background:white; padding:25px; width:450px; margin:auto; border-radius:10px; text-align:left;">

        <h5 style="color:#4b35ff; margin-bottom:5px;">Proses Generate Jadwal</h5>
        <small>Sedang melakukan pemrosesan...</small>

        <div style="width:100%; height:20px; background:#dcdcdc; border-radius:10px; margin-top:10px;">
            <div id="progress-bar" style="height:100%; width:0%; background:#4b35ff; transition:width 1s;"></div>
        </div>

    </div>
</div>

{{-- SCRIPT DATATABLES --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Datatables
        $('#datatable-mk').DataTable({
            responsive: true,
            pageLength: 10
        });

        // Popup proses generate
        const form = document.getElementById('form-generate-jadwal');
        const popup = document.getElementById('popup-generate');
        const bar = document.getElementById('progress-bar');

        form.addEventListener('submit', function() {
            popup.style.display = 'block';
            setTimeout(() => { bar.style.width = "100%"; }, 100);
        });

    });
</script>

@endsection
