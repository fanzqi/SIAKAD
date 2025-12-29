@extends('layouts.main')

@section('title', 'Input Nilai Mahasiswa')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('dosen/inputnilaimahasiswa') }}">Input Nilai Mahasiswa</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Nilai Mahasiswa</a></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4>Input Nilai Mahasiswa</h4>
                <form method="GET">
                    <select name="mata_kuliah_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        @foreach ($mataKuliah as $mk)
                            <option value="{{ $mk->id }}" {{ $selectedMataKuliah == $mk->id ? 'selected' : '' }}>
                                {{ $mk->kode }} - {{ $mk->nama_mata_kuliah }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Kehadiran</th>
                                <th>Tugas</th>
                                <th>UTS</th>
                                <th>UAS</th>
                                <th>Nilai Akhir</th>
                                <th>Grade</th>
                                <th>Bobot</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswa as $mhs)
                                @php $nilai = $nilaiMahasiswa->get($mhs->id); @endphp
                                <tr>
                                    <form method="POST" action="{{ route('inputnilaimahasiswa.update', $mhs->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="mata_kuliah_id" value="{{ $selectedMataKuliah }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mhs->nim }}</td>
                                        <td>{{ $mhs->nama }}</td>
                                        <td><input type="number" name="kehadiran" value="{{ $nilai->kehadiran ?? '' }}"
                                                min="0" max="100" class="form-control"></td>
                                        <td><input type="number" name="tugas" value="{{ $nilai->tugas ?? '' }}"
                                                min="0" max="100" class="form-control"></td>
                                        <td><input type="number" name="uts" value="{{ $nilai->uts ?? '' }}"
                                                min="0" max="100" class="form-control"></td>
                                        <td><input type="number" name="uas" value="{{ $nilai->uas ?? '' }}"
                                                min="0" max="100" class="form-control"></td>
                                        <td>{{ $nilai->nilai_akhir ?? '-' }}</td>
                                        <td>{{ $nilai->grade ?? '-' }}</td>
                                        <td>{{ $nilai->bobot ?? '-' }}</td>
                                        <td><button type="submit" class="btn btn-success btn-sm">Simpan</button></td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
