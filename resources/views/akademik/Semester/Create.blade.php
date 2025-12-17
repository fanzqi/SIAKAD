@extends('layouts.main')

@section('title', 'Tambah Semester')

@section('content')

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('semester.index') }}">Semester</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Semester</a></li>
            </ol>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Semester</h5>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('semester.store') }}" method="POST">
                            @csrf

                            {{-- Tahun Akademik --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Tahun Akademik</label>
                                <input type="text" name="tahun_akademik"
                                    class="form-control @error('tahun_akademik') is-invalid @enderror"
                                    value="{{ old('tahun_akademik') }}" placeholder="contoh: 2024/2025">

                                @error('tahun_akademik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kode Semester --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Kode Semester</label>
                                <input type="text" name="kode_semester"
                                    class="form-control @error('kode_semester') is-invalid @enderror"
                                    value="{{ old('kode_semester') }}" placeholder="contoh: 20241">

                                @error('kode_semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Semester --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Semester</label>
                                <select name="semester" class="form-control @error('semester') is-invalid @enderror">
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil
                                    </option>
                                    <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap
                                    </option>
                                    <option value="Pendek" {{ old('semester') == 'Pendek' ? 'selected' : '' }}>Pendek
                                    </option>
                                </select>

                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Semester Ke --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Semester Ke</label>
                                <input type="number" name="semester_ke" min="1"
                                    class="form-control @error('semester_ke') is-invalid @enderror"
                                    value="{{ old('semester_ke') }}" placeholder="contoh: 1">

                                @error('semester_ke')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Periode Mulai --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Periode Mulai</label>
                                <input type="date" name="periode_mulai"
                                    class="form-control @error('periode_mulai') is-invalid @enderror"
                                    value="{{ old('periode_mulai') }}">

                                @error('periode_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Periode Selesai --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Periode Selesai</label>
                                <input type="date" name="periode_selesai"
                                    class="form-control @error('periode_selesai') is-invalid @enderror"
                                    value="{{ old('periode_selesai') }}">

                                @error('periode_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="mb-3">
                                <label class="form-label d-block">Status</label>

                                <div class="form-check form-check-inline">
                                    <input type="radio" name="status" id="status_aktif" value="aktif"
                                        class="form-check-input" {{ old('status') == 'aktif' ? 'checked' : '' }}>
                                    <label for="status_aktif" class="form-check-label">Aktif</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input type="radio" name="status" id="status_nonaktif" value="nonaktif"
                                        class="form-check-input" {{ old('status') == 'nonaktif' ? 'checked' : '' }}>
                                    <label for="status_nonaktif" class="form-check-label">Nonaktif</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input type="radio" name="status" id="status_ditutup" value="ditutup"
                                        class="form-check-input" {{ old('status') == 'ditutup' ? 'checked' : '' }}>
                                    <label for="status_ditutup" class="form-check-label">Ditutup</label>
                                </div>

                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                                <a href="{{ route('semester.index') }}" class="btn btn-outline-secondary">Batal</a>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
