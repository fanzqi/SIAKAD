@extends('layouts.main')

@section('title', 'Tambah Ploting Dosen')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('kaprodi/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('plotingdosen.index') }}">Ploting Dosen</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah</a></li>
        </ol>
    </div>
</div>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Tambah Ploting Dosen Mata Kuliah</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('plotingdosen.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Mata Kuliah</label>
                    <select name="id_mk" class="form-control" required>
                        <option value="">-- Pilih Mata Kuliah --</option>
                        @foreach ($mataKuliah as $mk)
                        <option value="{{ $mk->id }}">
                            {{ $mk->kode ?? '' }} - {{ $mk->nama_mata_kuliah }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Dosen</label>
                    <select name="id_dosen" class="form-control" required>
                        <option value="">-- Pilih Dosen --</option>
                        @foreach ($dosen as $d)
                        <option value="{{ $d->id }}">
                            {{ $d->nidn ?? '' }} - {{ $d->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <select name="id_kelas" class="form-control" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">
                            {{ $k->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun Akademik</label>
                    <select name="id_tahun_akademik" class="form-control" required>
                        <option value="">-- Pilih Tahun Akademik --</option>
                        @foreach ($tahunAkademik as $ta)
                        <option value="{{ $ta->id }}">
                            {{ $ta->tahun_akademik }} - {{ ucfirst($ta->semester) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                <a href="{{ route('plotingdosen.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>
        </div>
    </div>
</div>




@endsection