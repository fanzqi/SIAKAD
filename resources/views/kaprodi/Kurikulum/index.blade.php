@extends('layouts.main')

@section('title', 'Kurikulum')

@section('content')

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('kaprodi/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Manajemen Kurikulum</a></li>
            </ol>
        </div>
    </div>

    <!-- Floating Alerts -->
    <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 300px;">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('edit'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Diperbarui!</strong> {{ session('edit') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

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
                        <h5 class="mb-0">Daftar Kurikulum</h5>
                        <a href="{{ route('kurikulum.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Tambah Kurikulum
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Semester</th>
                                        <th>Kode MK</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>Wajib/Pilihan</th>
                                        <th>Prasyarat</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kurikulums as $index => $kurikulum)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $kurikulum->tahunAkademik->semester }}
                                                {{ $kurikulum->tahunAkademik->tahun_akademik }}</td>
                                            <td>{{ $kurikulum->kode_mk }}</td>
                                            <td>{{ $kurikulum->nama_mk }}</td>
                                            <td>{{ $kurikulum->sks }}</td>
                                            <td>{{ $kurikulum->wajib_pilihan }}</td>
                                            <td>{{ $kurikulum->prasyarat ?? '-' }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $kurikulum->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $kurikulum->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('kurikulum.edit', $kurikulum->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('kurikulum.destroy', $kurikulum->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Belum ada data.</td>
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
