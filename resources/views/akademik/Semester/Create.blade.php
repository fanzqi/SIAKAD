@extends('layouts.main')

@section('title', 'Tambah Semester')

@section('content')


@php
    $segments = request()->segments();
    if (!empty($segments) && $segments[0] === 'akademik') {
        array_shift($segments);
    }
    $mapping = [
        'ruang' => 'Ruang',
        'jadwal-kuliah' => 'Jadwal Kuliah',
        'monitoring-nilai' => 'Monitoring Nilai',
        'semester' => 'Semester',
    ];
    $base = url('akademik');
    $cumulative = $base;
@endphp

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>

            @foreach ($segments as $i => $seg)
                @php
                    $cumulative .= '/' . $seg;
                    $isLast = $i === array_key_last($segments);
                    $label = $mapping[$seg] ?? ucwords(str_replace(['-', '_'], ' ', $seg));
                @endphp

                <li class="breadcrumb-item {{ $isLast ? 'active' : '' }}">
                    @if ($isLast)
                        <a href="javascript:void(0)">{{ $label }}</a>
                    @else
                        <a href="{{ $cumulative }}">{{ $label }}</a>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</div>

<div class="container mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Semester</h5>
                    <a href="{{ route('semester.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('semester.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                            <input class="form-control" type="text" name="tahun_akademik" id="tahun_akademik"
                                   class="form-control @error('tahun_akademik') is-invalid @enderror"
                                   value="{{ old('tahun_akademik') }}" placeholder="contoh: 2024/2025">
                            @error('tahun_akademik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-control" name="semester" id="semester"
                                     @error('semester') is-invalid @enderror">
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
                            <a href="{{ route('semester.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
