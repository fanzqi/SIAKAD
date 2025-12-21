@extends('layouts.main')

@section('title', 'Edit Nilai Mahasiswa')

@section('content')
<div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('dosen/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inputnilaimahasiswa.index') }}">Input Nilai Mahasiswa</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Nilai Mahasiswa</a></li>
            </ol>
        </div>
    </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="card-title mb-4">Edit Nilai Mahasiswa</h4>

                    <form action="{{ route('inputnilaimahasiswa.update', ['id' => $nilai->id_nilaimahasiswa]) }}" method="POST">
                    @csrf
                    @method('PUT')


                        {{-- DATA MAHASISWA (READ ONLY) --}}
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $nilai->nim }}"
                                   readonly>
                        </div>

                        <div class="form-group">
                            <label>Nama Mahasiswa</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $nilai->nama }}"
                                   readonly>
                        </div>

                        {{-- NILAI --}}
                        <div class="form-group">
                            <label>Nilai Absen</label>
                            <input type="number"
                                   name="nilai_angka_absen"
                                   class="form-control"
                                   value="{{ old('nilai_angka_absen', $nilai->nilai_angka_absen) }}"
                                   min="0" max="100"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Nilai Tugas</label>
                            <input type="number"
                                   name="nilai_angka_tugas"
                                   class="form-control"
                                   value="{{ old('nilai_angka_tugas', $nilai->nilai_angka_tugas) }}"
                                   min="0" max="100"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Nilai UTS</label>
                            <input type="number"
                                   name="nilai_angka_uts"
                                   class="form-control"
                                   value="{{ old('nilai_angka_uts', $nilai->nilai_angka_uts) }}"
                                   min="0" max="100"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Nilai UAS</label>
                            <input type="number"
                                   name="nilai_angka_uas"
                                   class="form-control"
                                   value="{{ old('nilai_angka_uas', $nilai->nilai_angka_uas) }}"
                                   min="0" max="100"
                                   required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('inputnilaimahasiswa.index') }}"
                               class="btn btn-secondary">
                                Kembali
                            </a>

                            <button type="submit"
                                    class="btn btn-primary">
                                Update Nilai
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
