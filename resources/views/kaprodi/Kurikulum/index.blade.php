@extends('layouts.main')

@section('title', 'Kurikulum')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('kaprodi/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kurikulum.index') }}">Kurikulum</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Halaman Kurikulum</a></li>
        </ol>
    </div>
</div>
<br>
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

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Ploting Dosen Mata Kuliah</h4>
        <a href="{{ route('kurikulum.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Kurikulum
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body ">
            <table class="table table-bordered table-striped mb-0 text-center">
                <thead class="table-primary">
                    <tr>
                        <th>No.</th>
                        <th>Semester</th>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Wajib / Pilihan</th>
                        <th>Prasyarat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kurikulums as $index => $kurikulum)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kurikulum->semester }}</td>
                        <td>{{ $kurikulum->kode_mk }}</td>
                        <td class="text-start">{{ $kurikulum->nama_mk }}</td>
                        <td>{{ $kurikulum->sks }}</td>
                        <td>{{ $kurikulum->wajib_pilihan }}</td>
                        <td>{{ $kurikulum->prasyarat ?? '-' }}</td>
                        <td>
                            <a href="{{ route('kurikulum.edit', $kurikulum->id) }}" class="btn btn-warning btn-sm">
                                Edit</a>

                            <form action="{{ route('kurikulum.destroy', $kurikulum->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">Data kurikulum belum tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection