@extends('layouts.main')

@section('title', 'Tambah Input Nilai')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('input-nilai.index') }}">Input Nilai</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Input Nilai</a></li>
        </ol>
    </div>
</div>

    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Input Nilai</h5>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('input-nilai.store') }}" method="POST">
                            @csrf

                            {{-- Tahun Akademik (readonly) --}}
                            <div class="mb-3">
                                <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                                <input type="text" class="form-control" readonly
                                    value="{{ optional($tahunAktif)->semester }} {{ optional($tahunAktif)->tahun_akademik }}">
                                <input type="hidden" name="tahun_akademik_id" value="{{ optional($tahunAktif)->id }}">



                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <input type="text" name="deskripsi" id="deskripsi"
                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                    value="{{ old('deskripsi') }}" placeholder="Masukkan deskripsi" required>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Mulai --}}
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                    class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                    value="{{ old('tanggal_mulai') }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Akhir --}}
                            <div class="mb-3">
                                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                                    class="form-control @error('tanggal_akhir') is-invalid @enderror"
                                    value="{{ old('tanggal_akhir') }}" required>
                                @error('tanggal_akhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
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

                            {{-- Tombol --}}
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
