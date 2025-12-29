@extends('layouts.main')

@section('title', 'Edit Ploting Dosen')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('kaprodi/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('plotingdosen.index') }}">Ploting Dosen</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
        </ol>
    </div>
</div>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Ploting Dosen Mata Kuliah</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('plotingdosen.update', $ploting->id_ploting) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- DOSEN --}}
                <div class="mb-3">
                    <label class="form-label">Dosen</label>
                    <select name="id_dosen" class="form-control" required>
                        @foreach ($dosen as $d)
                        <option value="{{ $d->id }}"
                            {{ $ploting->id_dosen == $d->id ? 'selected' : '' }}>
                            {{ $d->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- MATA KULIAH --}}
                <div class="mb-3">
                    <label class="form-label">Mata Kuliah</label>
                    <select name="id_mk" class="form-control" required>
                        @foreach ($mataKuliah as $mk)
                        <option value="{{ $mk->id }}"
                            {{ $ploting->id_mk == $mk->id ? 'selected' : '' }}>
                            {{ $mk->nama_mata_kuliah }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- KELAS --}}
                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="id_kelas" class="form-control" required>
                        @foreach ($kelas as $k)
                        <option value="{{ $k->id }}"
                            {{ $ploting->id_kelas == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- TAHUN AKADEMIK --}}
                <div class="mb-3">
                    <label class="form-label">Tahun Akademik</label>
                    <select name="id_tahun_akademik" class="form-control" required>
                        @foreach ($tahunAkademik as $ta)
                        <option value="{{ $ta->id }}"
                            {{ $ploting->id_tahun_akademik == $ta->id ? 'selected' : '' }}>
                            {{ $ta->tahun_akademik }} - {{ $ta->semester }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('plotingdosen.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

@endsection