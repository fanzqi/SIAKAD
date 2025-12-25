@extends('layouts.main')

@section('title', 'Dashboard Dekan')

@section('content')

<div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="row page-titles mx-0 mb-3">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0">Dashboard Dekan</h4>
            <small class="text-muted">
                Monitoring Kinerja Akademik & Mutu Fakultas
            </small>
        </div>
    </div>

    <!-- CARD STATISTIK -->
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="icon-people text-primary display-5 mb-2"></i>
                    <h3 class="mb-1">{{ $totalMahasiswa }}</h3>
                    <p class="mb-0">Total Mahasiswa</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="icon-user text-success display-5 mb-2"></i>
                    <h3 class="mb-1">{{ $totalDosen }}</h3>
                    <p class="mb-0">Total Dosen</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="icon-graduation text-warning display-5 mb-2"></i>
                    <h3 class="mb-1">{{ $totalProdi }}</h3>
                    <p class="mb-0">Program Studi</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="icon-book-open text-danger display-5 mb-2"></i>
                    <h3 class="mb-1">{{ $totalMatkul }}</h3>
                    <p class="mb-0">Mata Kuliah Aktif</p>
                </div>
            </div>
        </div>
    </div>

   <!-- GRAFIK -->
<div class="row">
    <div class="col-xl-10 col-lg-11 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">
                    Sebaran Mahasiswa per Prodi
                </h4>
                <div id="chart-prodi" style="height:320px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT GRAFIK -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    new Morris.Bar({
        element: 'chart-prodi',
        data: [
            @foreach ($sebaranProdi as $item)
            {
                prodi: "{{ $item->prodi }}",
                jumlah: {{ $item->jumlah }}
            },
            @endforeach
        ],
        xkey: 'prodi',
        ykeys: ['jumlah'],
        labels: ['Jumlah Mahasiswa'],
        resize: true,
        barColors: ['#5c4ac7'],
        gridTextSize: 12
    });
});
</script>

@endsection
