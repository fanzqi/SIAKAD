@extends('layouts.main')

@section('title', 'Input Nilai Mahasiswa')

@section('content')

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dosen/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inputnilaimahasiswa.index') }}">Plotting Dosen Mata Kuliah</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Input Nilai Mahasiswa</a></li>
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
                            <h4 class="card-title mb-0">Daftar Input Nilai Mahasiswa</h4>
                        </div>

                        <div class="table-responsive">
                            <table id="table-inputnilaimahasiswa" class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Mahasiswa</th>
                                        <th>Kehadiran</th>
                                        <th>Tugas</th>
                                        <th>UTS</th>
                                        <th>UAS</th>
                                        <th>Nilai Akhir</th>
                                        <th>Grade</th>
                                        <th>Bobot</th>
                                        <th style="width:130px;">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @forelse ($nilaiMahasiswa as $item)
                                      <tr>
                                          <td>{{ $loop->iteration }}</td>
                                          <td>{{ $item->nim }}</td>
                                          <td>{{ $item->nama }}</td>
                                          <td>{{ $item->nilai_angka_absen }}</td>
                                          <td>{{ $item->nilai_angka_tugas }}</td>
                                          <td>{{ $item->nilai_angka_uts }}</td>
                                          <td>{{ $item->nilai_angka_uas }}</td>
                                          <td>{{ $item->nilai_angka_akhir }}</td>
                                          <td>{{ $item->nilai_huruf }}</td>
                                          <td>{{ $item->bobot }}</td>
                                          <td>
                                             <a href="{{ route('inputnilaimahasiswa.edit', $item->id_nilaiMahasiswa) }}"
                                             class="btn btn-sm btn-warning">
                                             <i class="bi bi-pencil-square"></i>Edit
                                             </a>
                                          </td>
                                        </tr>
                                        @empty
                                         <tr>
                                          <td colspan="10" class="text-center">Belum ada data.</td>
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
