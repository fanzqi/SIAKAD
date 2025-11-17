@extends('layouts.main')

@section('title', 'Tambah Semester')

@section('content')
<div class="container mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Semester</h5>
                    <a href="{{ route('semester.semester') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('semester.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                            <input type="text" name="tahun_akademik" id="tahun_akademik"
                                   class="form-control @error('tahun_akademik') is-invalid @enderror"
                                   value="{{ old('tahun_akademik') }}" placeholder="contoh: 2024/2025">
                            @error('tahun_akademik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select name="semester" id="semester"
                                    class="form-select @error('semester') is-invalid @enderror">
                                <option value="">-- Pilih Semester --</option>
                                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_aktif" value="Aktif"
                                       {{ old('status', 'Tidak Aktif') == 'Aktif' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_aktif">Aktif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_tidak" value="Tidak Aktif"
                                       {{ old('status') == 'Tidak Aktif' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_tidak">Tidak Aktif</label>
                            </div>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="{{ route('semester.semester') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
