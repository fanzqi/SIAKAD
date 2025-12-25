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
                    <form action="{{ route('jadwalkuliah.update', $jadwal->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Mata Kuliah -->
    <div class="form-group mb-3">
        <label>Mata Kuliah</label>
        <input type="text" class="form-control"
            value="{{ $jadwal->mata_kuliah->nama_mata_kuliah }}" readonly>
        <input type="hidden" name="mata_kuliah_id" value="{{ $jadwal->mata_kuliah_id }}">
    </div>

    <!-- Program Studi -->
    <div class="form-group mb-3">
        <label>Program Studi</label>
        <input type="text" class="form-control"
            value="{{ $jadwal->mata_kuliah->program_studi->nama ?? '-' }}" readonly>
    </div>

    <!-- Semester -->
    <div class="form-group mb-3">
        <label>Semester</label>
        <input type="number" class="form-control" value="{{ $jadwal->semester }}" readonly>
        <input type="hidden" name="semester" value="{{ $jadwal->semester }}">
    </div>

    <!-- Group Kelas -->
    <div class="form-group mb-3">
        <label>Group Kelas</label>
        <input type="text" class="form-control" value="{{ $jadwal->group_kelas }}" readonly>
        <input type="hidden" name="group_kelas" value="{{ $jadwal->group_kelas }}">
    </div>

    <!-- Hari -->
    <div class="form-group mb-3">
        <label>Hari</label>
        <select name="hari" class="form-control" required>
            @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                <option value="{{ $hari }}" {{ $jadwal->hari == $hari ? 'selected' : '' }}>
                    {{ $hari }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Jam -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label>Jam Mulai</label>
            <input type="time" name="jam_mulai" class="form-control"
                value="{{ $jadwal->jam_mulai }}" required>
        </div>
        <div class="col-md-6">
            <label>Jam Selesai</label>
            <input type="time" name="jam_selesai" class="form-control"
                value="{{ $jadwal->jam_selesai }}" required>
        </div>
    </div>

    <!-- Ruangan -->
    <div class="form-group mb-4">
        <label>Ruangan</label>
        <select name="ruangs_id" class="form-control" required>
            @foreach ($ruangs as $ruang)
                <option value="{{ $ruang->id }}"
                    {{ $jadwal->ruangs_id == $ruang->id ? 'selected' : '' }}>
                    {{ $ruang->nama_ruang }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Tombol -->
    <div class="d-flex justify-content-end">
        <a href="{{ route('jadwalkuliah.index') }}" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-primary">Update Jadwal</button>
    </div>
</form>


@endsection
