@extends('layouts.main')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <div class="row page-titles mx-0 mb-3">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-1">Dashboard Mahasiswa</h4>
            <small class="text-muted">
                Selamat datang, <strong>{{ $mahasiswa->nama }}</strong>
            </small>
        </div>
    </div>

    {{-- Info Cards --}}
    <div class="row">

        {{-- NIM --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="icon-user text-primary display-6 mb-2"></i>
                    <h6 class="mb-0">{{ $mahasiswa->nim }}</h6>
                    <small class="text-muted">NIM</small>
                </div>
            </div>
        </div>

        {{-- Program Studi --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="icon-graduation text-success display-6 mb-2"></i>
                    <h6 class="mb-0">
                        {{ optional($mahasiswa->programStudi)->nama ?? '-' }}
                    </h6>
                    <small class="text-muted">Program Studi</small>
                </div>
            </div>
        </div>

        {{-- Total Mata Kuliah --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="icon-book-open text-warning display-6 mb-2"></i>
                    <h5 class="mb-0">{{ $totalMatkul }}</h5>
                    <small class="text-muted">Total Mata Kuliah</small>
                </div>
            </div>
        </div>

        {{-- Total SKS --}}
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="icon-layers text-danger display-6 mb-2"></i>
                    <h5 class="mb-0">{{ $totalSks }}</h5>
                    <small class="text-muted">Total SKS</small>
                </div>
            </div>
        </div>

    </div>

    {{-- Notifikasi --}}
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-3">Notifikasi Terbaru</h4>

                    <ul class="list-group list-group-flush">
                        @forelse ($notifications as $notif)
                            <li class="list-group-item px-0">
                                <strong>{{ $notif->judul }}</strong><br>
                                <small class="text-muted">
                                    {{ $notif->created_at->translatedFormat('d F Y') }}
                                </small>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">
                                Belum ada notifikasi terbaru
                            </li>
                        @endforelse
                    </ul>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
