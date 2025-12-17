@extends('layouts.main')

@section('title', 'Tambah Mata Kuliah')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('kaprodi/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('matakuliah.index') }}">Mata Kuliah</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Mata Kuliah</a></li>
        </ol>
    </div>
</div>

<div class="container mt-4">
    <h2>Tambah Mata Kuliah</h2>
    <form action="{{ route('matakuliah.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="kode">Kode</label>
            <input type="text" class="form-control" id="kode" name="kode" required>
        </div>
        <div class="form-group">
            <label for="nama_mata_kuliah">Mata Kuliah</label>
            <input type="text" class="form-control" id="nama_mata_kuliah" name="nama_mata_kuliah" required>
        </div>
        <div class="form-group">
            <label for="dosen">Dosen</label>
            <input type="text" class="form-control" id="dosen" name="dosen" required>
        </div>
        <div class="form-group">
            <label for="fakultas">Fakultas</label>
            <input type="text" class="form-control" id="fakultas" name="fakultas" required>
        </div>
        <div class="form-group">
            <label for="program_studi">Program Studi</label>
            <input type="text" class="form-control" id="program_studi" name="program_studi" required>
        </div>
        <div class="form-group">
            <label for="sks">SKS</label>
            <input type="number" class="form-control" id="sks" name="sks" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        <a href="{{ route('matakuliah.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>

@endsection
