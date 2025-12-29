@extends('layouts.main')

@section('title', 'Dashboard Kaprodi')

@section('content')

    <!-- Breadcrumb -->
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
            </ol>
        </div>
    </div>

    <!-- Greeting -->
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <h4 class="mb-0">Selamat datang, {{ $namaKaprodi }}</h4>
            <small class="text-muted">
                Pengelolaan Data Akademik di
                <span class="badge badge-pill"
                    style="background: linear-gradient(90deg, #f7971e 0%, #ffd200 100%); color: #222; font-size: 0.85rem; padding: 0.25em 0.8em;">
                    {{ $namaFakultas }}
                </span>
                Prodi
                <span class="badge badge-pill"
                    style="background: linear-gradient(90deg, #7571f9 0%, #9d4de6 100%); color: #fff; font-size: 0.85rem; padding: 0.25em 0.8em;">
                    {{ $namaProdi }}
                </span>
            </small>
        </div>
    </div>

    <!-- Dashboard cards -->
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">

            <!-- Mahasiswa -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <span class="display-5"><i class="icon-people gradient-7-text"></i></span>
                        <h2 class="mt-3">{{ $totalMahasiswa }}</h2>
                        <p>Mahasiswa di Prodi Anda</p>
                    </div>
                </div>
            </div>

            <!-- Mata Kuliah -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <span class="display-5"><i class="icon-book-open gradient-5-text"></i></span>
                        <h2 class="mt-3">{{ $totalMatkul }}</h2>
                        <p>Mata Kuliah di Prodi Anda</p>
                    </div>
                </div>
            </div>

            <!-- Semester Berjalan -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <span class="display-5"><i class="fa fa-calendar gradient-9-text"></i></span>
                        <h2 class="mt-3">{{ $semesterBerjalan->tahun_akademik ?? '-' }}</h2>
                        <p>Semester Berjalan</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

<div class="container-fluid px-4 mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Sebaran Mahasiswa per Semester</h4>
                    @if (!empty($sebaranMahasiswaPerSemester) && count($sebaranMahasiswaPerSemester) > 0)
                        <div id="morris-bar-chart-semester" style="height:350px;"></div>
                    @else
                        <p class="text-center text-muted">Data mahasiswa per semester belum tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if (!empty($sebaranMahasiswaPerSemester))
<script>
document.addEventListener("DOMContentLoaded", function() {
    new Morris.Bar({
        element: 'morris-bar-chart-semester',
        data: [
            @foreach ($sebaranMahasiswaPerSemester as $item)
                {
                    semester: "{{ $item['semester'] }}",
                    jumlah: {{ $item['jumlah'] }}
                }@if (!$loop->last),@endif
            @endforeach
        ],
        xkey: 'semester',
        ykeys: ['jumlah'],
        labels: ['Jumlah Mahasiswa'],
        resize: true,
        barColors: ['#7571f9'],
        hideHover: 'auto'
    });
});
</script>
@endif



@endsection
