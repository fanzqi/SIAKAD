@extends('layouts.main')

@section('title', 'Edit Jadwal Kuliah')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jadwalkuliah.index') }}">Jadwal Kuliah</a></li>
                <li class="breadcrumb-item active">Edit Jadwal Kuliah</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Edit Jadwal Kuliah</h5>
            </div>
            <div class="card-body">

                <form action="{{ route('jadwalkuliah.update', $jadwal->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Mata Kuliah -->
                    <div class="form-group mb-3">
                        <label>Mata Kuliah</label>
                        <input type="text" class="form-control" value="{{ $jadwal->mata_kuliah->nama_mata_kuliah }}"
                            readonly>
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

                    <!-- Group -->
                    <div class="form-group mb-3">
                        <label>Group Kelas</label>
                        <input type="text" class="form-control" value="{{ $jadwal->mata_kuliah->group }}" readonly>
                        <input type="hidden" name="group_kelas" value="{{ $jadwal->mata_kuliah->group }}">
                    </div>

                    <!-- Hari -->
                    <div class="form-group mb-3">
                        <label>Hari</label>
                        <select name="hari" class="form-control">
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
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
                            <input type="time" name="jam_mulai" class="form-control" value="{{ $jadwal->jam_mulai }}">
                        </div>
                        <div class="col-md-6">
                            <label>Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control"
                                value="{{ $jadwal->jam_selesai }}">
                        </div>
                    </div>

                    <!-- Ruangan -->
                    <div class="form-group mb-4">
                        <label>Ruangan</label>
                        <select name="ruangs_id" class="form-control">
                            @foreach ($ruangs as $ruang)
                                <option value="{{ $ruang->id }}"
                                    {{ $jadwal->ruangs_id == $ruang->id ? 'selected' : '' }}>
                                    {{ $ruang->nama_ruang }}
                                </option>
                            @endforeach
                        </select>
                    </div>
<div class="mb-3">
    <label>Status</label>
   <input type="text" class="form-control" value="{{ $jadwal->status }}" disabled>

</div>


                    </div>
                    <!-- TOMBOL (HARUS DI DALAM FORM) -->
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('jadwalkuliah.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            Update Jadwal
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
