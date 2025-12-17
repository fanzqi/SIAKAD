@extends('layouts.main')

@section('title', 'Tambah Jadwal Kuliah')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('jadwalkuliah.index') }}">Jadwal Kuliah</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Jadwal Kuliah</a></li>
        </ol>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Form Tambah Jadwal Kuliah</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('jadwalkuliah.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_mata_kuliah">Mata Kuliah</label>
                            <input type="text" class="form-control" id="nama_mata_kuliah" name="nama_mata_kuliah" required>
                        </div>
                        <div class="form-group">
                            <label for="dosen">Dosen</label>
                            <input type="text" class="form-control" id="dosen" name="dosen" required>
                        </div>
                        <div class="form-group">
                            <label for="program_studi">Program Studi</label>
                            <input type="text" class="form-control" id="program_studi" name="program_studi" required>
                        </div>
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <input type="text" class="form-control" id="semester" name="semester" required>
                        </div>
                        <div class="form-group">
                            <label for="hari">Hari</label>
                            <input type="text" class="form-control" id="hari" name="hari" required>
                        </div>
                        <div class="form-group">
                            <label for="jam">Jam</label>
                            <input type="text" class="form-control" id="jam" name="jam" required>
                        </div>
                        <div class="form-group">
                            <label for="ruangan">Ruangan</label>
                            <input type="text" class="form-control" id="ruangan" name="ruangan" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('jadwalkuliah.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection