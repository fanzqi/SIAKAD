@extends('layouts.main')

@section('title', 'Dashboard Akademik')

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
        <h4 class="mb-0">Dashboard Akademik</h4>
        <small class="text-muted">
            Pengelolaan Data Akademik, Mahasiswa, dan Perkuliahan
        </small>
    </div>
</div>

<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <!-- Dosen -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <span class="display-5"><i class="icon-user gradient-3-text"></i></span>
                        <h2 class="mt-3">
                            {{ \App\Models\User::where('role', 'dosen')->count() }} Dosen
                        </h2>
                        <p>Dari Semua Fakultas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mahasiswa -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <span class="display-5"><i class="icon-people gradient-7-text"></i></span>
                        <h2 class="mt-3">
                            {{ $totalMahasiswa ?? 0 }} Mahasiswa
                        </h2>
                        <p>Terdaftar di Prodi Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mata Kuliah -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <span class="display-5"><i class="icon-book-open gradient-5-text"></i></span>
                        <h2 class="mt-3">
                            {{ $totalMatkul ?? 0 }} Mata Kuliah
                        </h2>
                        <p>Mata Kuliah yang Anda Ampu</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Semester Berjalan -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <span class="display-5"><i class="fa fa-calendar gradient-9-text"></i></span>
                        <h2 class="mt-3">
                            {{ \App\Models\TahunAkademik::orderByDesc('id')->value('tahun_akademik') ?? '-' }}
                        </h2>
                        <p>Semester Berjalan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title mb-3">Sebaran Mahasiswa per Prodi</h4>
                    <div id="morris-bar-chart" style="height:350px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    new Morris.Bar({
        element: 'morris-bar-chart',
        data: [
            @foreach ($sebaranMahasiswa as $item)
                {
                    prodi: "{{ $item->prodi }}",
                    jumlah: {{ $item->jumlah ?? 0 }}
                }
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        ],
        xkey: 'prodi',
        ykeys: ['jumlah'],
        labels: ['Jumlah Mahasiswa'],
        resize: true,
        barColors: ['#7571f9'],
        hideHover: 'auto'
    });
});
</script>
@endsection
