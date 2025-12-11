@extends('layouts.main')

@section('title', 'Edit Semester')

@section('content')
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('semester.index') }}">Semester</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Semester</a></li>
        </ol>
    </div>
</div>
<div class="container mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Semester</h5>
                    <a href="{{ route('semester.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('semester.update', $semester->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Tahun Akademik --}}
                        <div class="mb-3">
                            <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                            <input type="text" name="tahun_akademik" id="tahun_akademik"
                                   class="form-control @error('tahun_akademik') is-invalid @enderror"
                                   value="{{ old('tahun_akademik', $semester->tahun_akademik) }}" placeholder="contoh: 2024/2025">
                            @error('tahun_akademik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Semester --}}
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select name="semester" id="semester"
                                    class="form-select @error('semester') is-invalid @enderror">
                                <option value="">-- Pilih Semester --</option>
                                <option value="Ganjil" {{ old('semester', $semester->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester', $semester->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                <option value="Pendek" {{ old('semester', $semester->semester) == 'Pendek' ? 'selected' : '' }}>Pendek</option>
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_aktif" value="Aktif"
                                       {{ old('status', $semester->status) == 'Aktif' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_aktif">Aktif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_nonaktif" value="Nonaktif"
                                       {{ old('status', $semester->status) == 'Nonaktif' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_nonaktif">Nonaktif</label>
                            </div>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update
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
