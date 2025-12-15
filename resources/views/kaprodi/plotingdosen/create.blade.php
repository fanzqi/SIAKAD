@extends('layouts.main')

@section('title', 'Tambah Ploting Dosen Mata Kuliah')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('kaprodi/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('plotingdosen.index') }}">Mata Kuliah</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Mata Kuliah</a></li>
        </ol>
    </div>
</div>

<div class="container mt-4">
    <h2>Tambah Mata Kuliah</h2>
    <form action="{{ route('plotingdosen.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nama_mata_kuliah_id">Mata Kuliah</label>
            <input type="text" class="form-control" id="nama_mata_kuliah_id" name="nama_mata_kuliah_id" required>
        </div>
        <div class="form-group">
            <label for="dosen">Dosen</label>
            <input type="text" class="form-control" id="dosen" name="dosen" required>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas</label>
            <input type="text" class="form-control" id="kelas" name="kelas" required>
        </div>
        <div class="form-group">
            <label for="semester_id">Semester</label>
            <input type="number" class="form-control" id="semester_id" name="semester_id" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        <a href="{{ route('plotingdosen.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>

@endsection
