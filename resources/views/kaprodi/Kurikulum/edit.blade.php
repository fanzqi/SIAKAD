@extends('layouts.main')

@section('title', 'Edit Kurikulum')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('kaprodi/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kurikulum.index') }}">Manajemen Kurikulum</a></li>
            <li class="breadcrumb-item active">Edit Kurikulum</li>
        </ol>
    </div>
</div>

<!-- Floating Alerts -->
<div style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 300px;">
    @foreach (['success','edit','delete'] as $msg)
    @if (session($msg))
    <div class="alert alert-{{ $msg == 'delete' ? 'warning' : ($msg == 'edit' ? 'info' : 'success') }} alert-dismissible fade show">
        {{ session($msg) }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif
    @endforeach
</div>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Edit Kurikulum</h5>
            <a href="{{ route('kurikulum.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">

            <form action="{{ route('kurikulum.update', $kurikulum->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="tahun_akademik_id" class="form-label">Tahun Akademik</label>
                    <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-control @error('tahun_akademik_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Tahun Akademik --</option>
                        @foreach ($tahunAkademikList as $tahun)
                        <option value="{{ $tahun->id }}" {{ $kurikulum->tahun_akademik_id == $tahun->id ? 'selected' : '' }}>
                            {{ $tahun->semester }} {{ substr($tahun->tahun_akademik, 0, 4) }}
                            ({{ $tahun->tahun_akademik }})
                        </option>
                        @endforeach
                    </select>
                    @error('tahun_akademik_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kode_mk" class="form-label">Kode MK</label>
                    <input type="text" name="kode_mk" id="kode_mk" class="form-control @error('kode_mk') is-invalid @enderror" value="{{ old('kode_mk', $kurikulum->kode_mk) }}" required>
                    @error('kode_mk')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_mk" class="form-label">Nama Mata Kuliah</label>
                    <input type="text" name="nama_mk" id="nama_mk" class="form-control @error('nama_mk') is-invalid @enderror" value="{{ old('nama_mk', $kurikulum->nama_mk) }}" required>
                    @error('nama_mk')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" name="semester" id="semester" class="form-control @error('semester') is-invalid @enderror" value="{{ old('semester', $kurikulum->semester) }}" required>
                    @error('semester')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="sks" class="form-label">SKS</label>
                    <input type="number" name="sks" id="sks" class="form-control @error('sks') is-invalid @enderror" value="{{ old('sks', $kurikulum->sks) }}" required>
                    @error('sks')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="wajib_pilihan" class="form-label">Wajib/Pilihan</label>
                    <select name="wajib_pilihan" id="wajib_pilihan" class="form-control @error('wajib_pilihan') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        <option value="Wajib" {{ old('wajib_pilihan', $kurikulum->wajib_pilihan) == 'Wajib' ? 'selected' : '' }}>Wajib</option>
                        <option value="Pilihan" {{ old('wajib_pilihan', $kurikulum->wajib_pilihan) == 'Pilihan' ? 'selected' : '' }}>Pilihan</option>
                    </select>
                    @error('wajib_pilihan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="prasyarat" class="form-label">Mata Kuliah Prasyarat</label>
                    <select name="prasyarat" id="prasyarat" class="form-control">
                        <option value="">Tidak Ada</option>
                        @foreach ($kurikulums as $mk)
                        <option value="{{ $mk->kode_mk }}" {{ $kurikulum->prasyarat == $mk->kode_mk ? 'selected' : '' }}>
                            {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        <option value="Aktif" {{ old('status', $kurikulum->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ old('status', $kurikulum->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('kurikulum.index') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection