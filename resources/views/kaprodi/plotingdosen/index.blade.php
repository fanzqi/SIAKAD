@extends('layouts.main')

@section('title', 'Ploting Dosen')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('kaprodi/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('plotingdosen.index') }}">Plotting Dosen Mata Kuliah</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Ploting</a></li>
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

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Ploting Dosen Mata Kuliah</h4>
        <a href="{{ route('plotingdosen.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Ploting
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Dosen</th>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>Tahun Akademik</th>
                            <th>Semester</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_dosen }}</td>
                            <td>{{ $item->nama_mata_kuliah }}</td>
                            <td class="text-center">{{ $item->nama_kelas }}</td>
                            <td class="text-center">{{ $item->tahun_akademik }}</td>
                            <td class="text-center">
                                {{ $item->semester }}
                            </td>
                            <td>
                                <a href="{{ route('plotingdosen.edit', $item->id_ploting) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('plotingdosen.destroy', $item->id_ploting) }}"
                                    method="POST"
                                    style="display:inline"
                                    onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Data ploting dosen belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection