@extends('layouts.main')

@section('title', 'Tambah Input Nilai')

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
        'input-nilai' => 'Input Nilai',
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
                        <span>{{ $label }}</span>
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
                        <h5 class="mb-0">Tambah Input Nilai</h5>
                        <a href="{{ route('input-nilai.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('input-nilai.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="tahun_akademik_id" class="form-label">Tahun Akademik</label>
                                <select class="form-control"name="tahun_akademik_id" id="tahun_akademik_id"
                                    class="form-select @error('tahun_akademik_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Tahun Akademik --</option>
                                    @if (!empty($tahunAkademikList) && count($tahunAkademikList))
                                        @foreach ($tahunAkademikList as $tahun)
                                            <option value="{{ $tahun->id }}"
                                                {{ old('tahun_akademik_id') == $tahun->id ? 'selected' : '' }}>
                                                {{-- Tampilkan kode di label tapi ID tetap sebagai value --}}
                                                {{ $tahun->semester }}
                                                {{ substr($tahun->tahun_akademik, 0, 4) }}{{ strtolower($tahun->semester) == 'ganjil' ? 1 : 2 }}
                                                ({{ $tahun->tahun_akademik }})
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">Tidak ada data tahun akademik</option>
                                    @endif
                                </select>
                                @error('tahun_akademik_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <input type="text" name="deskripsi" id="deskripsi"
                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                    value="{{ old('deskripsi') }}" placeholder="Masukkan deskripsi" required>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                    class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                    value="{{ old('tanggal_mulai') }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                                    class="form-control @error('tanggal_akhir') is-invalid @enderror"
                                    value="{{ old('tanggal_akhir') }}" required>
                                @error('tanggal_akhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status_aktif"
                                        value="Aktif" {{ old('status') == 'Aktif' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_aktif">Aktif</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status_nonaktif"
                                        value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_nonaktif">Nonaktif</label>
                                </div>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                                <a href="{{ route('input-nilai.index') }}" class="btn btn-outline-secondary">Batal</a>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
