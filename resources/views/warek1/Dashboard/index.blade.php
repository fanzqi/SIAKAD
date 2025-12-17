@extends('layouts.main')

@section('title', 'Dashboard Warek 1')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <h4 class="mb-0">Dashboard Wakil Rektor I</h4>
            <small class="text-muted">Monitoring Akademik & Mutu Pendidikan</small>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="row g-4">

            <!-- Total Dosen -->
            <div class="col-xl-3 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="icon-user gradient-3-text display-5"></i>
                        <h2 class="mt-3">{{ $totalDosen }}</h2>
                        <p class="mb-0 text-muted">Dosen Aktif</p>
                    </div>
                </div>
            </div>

            <!-- Total Mahasiswa -->
            <div class="col-xl-3 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="icon-people gradient-7-text display-5"></i>
                        <h2 class="mt-3">{{ $totalMahasiswa }}</h2>
                        <p class="mb-0 text-muted">Mahasiswa Aktif</p>
                    </div>
                </div>
            </div>

            <!-- Mata Kuliah -->
            <div class="col-xl-3 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="icon-book-open gradient-5-text display-5"></i>
                        <h2 class="mt-3">{{ $totalMatkul }}</h2>
                        <p class="mb-0 text-muted">Mata Kuliah Aktif</p>
                    </div>
                </div>
            </div>

            <!-- Semester -->
            <div class="col-xl-3 col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fa fa-calendar gradient-9-text display-5"></i>
                        <h4 class="mt-3">{{ $semesterAktif }}</h4>
                        <p class="mb-0 text-muted">Semester Berjalan</p>
                    </div>
                </div>
            </div>

        </div>
    </div>



@endsection
