@extends('layouts.main')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="container-fluid">

    <div class="row page-titles mx-0 mb-3">
        <div class="col p-md-0">
            <h4 class="mb-0">Dashboard Dosen</h4>
            <small class="text-muted">
                Selamat datang   {{ Auth::user()->dosen?->nama ?? (Auth::user()->mahasiswa?->nama ?? Auth::user()->name) }}
            </small>
        </div>
    </div>

    <div class="row">
        <!-- Nama Dosen -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="icon-user text-primary display-5"></i>
                    <h5 class="mt-2"> {{ Auth::user()->dosen?->nama ?? (Auth::user()->mahasiswa?->nama ?? Auth::user()->name) }}</h5>
                    <small>Nama Dosen</small>
                </div>
            </div>
        </div>

        <!-- Email Dosen -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="icon-envelope text-success display-5"></i>
                    <h5 class="mt-2">{{ \App\Models\Dosen::orderByDesc('id')->value('email') ?? '-' }}</h5>
                    <small>Email Dosen</small>
                </div>
            </div>
        </div>

        <!-- Total Mahasiswa -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="icon-people text-warning display-5"></i>
                    <h3>{{ $totalMahasiswa }} </h3>
                    <small>Total Mahasiswa</small>
                </div>
            </div>
        </div>

        <!-- Total Mata Kuliah -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="icon-book-open text-danger display-5"></i>
                    <h3>{{ $totalMatkul }}</h3>
                    <small>Mata Kuliah Yang Diampu</small>
                </div>
            </div>
        </div>
    </div>


    <!-- Notifikasi -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Notifikasi Terbaru</h4>
                    <ul class="list-group">
                        @forelse ($notifications as $notif)
                            <li class="list-group-item">
                                <strong>{{ $notif->judul }}</strong>
                                <br>
                                <small class="text-muted">{{ $notif->created_at->format('d M Y') }}</small>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">Tidak ada notifikasi</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
