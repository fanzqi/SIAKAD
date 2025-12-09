@extends('layouts.main')

@section('title', 'Dashboard Kaprodi')

@section('content')

@php
        $segments = request()->segments();
        // Treat 'akademik' as the dashboard root and remove it from segments to avoid duplication
        if (!empty($segments) && $segments[0] === 'kaprodi') {
            array_shift($segments);
        }
        $mapping = [
            'semester' => 'Semester',
            'jadwal-kuliah' => 'Jadwal Kuliah',
            'monitoring-nilai' => 'Monitoring Nilai',
        ];
        $base = url('kaprodi');
        $cumulative = $base;
    @endphp

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('kaprodi/dashboard') }}">Dashboard</a></li>

                @foreach ($segments as $i => $seg)
                    @php
                        $cumulative .= '/' . $seg;
                        $isLast = $i === array_key_last($segments);
                        $label = $mapping[$seg] ?? ucwords(str_replace(['-', '_'], ' ', $seg));
                    @endphp

                    <li class="breadcrumb-item {{ $isLast ? 'active' : '' }}">
                        @if ($isLast)
                            <a href="javascript:void(0)">{{ $label }}</a>
                        @else
                            <a href="{{ $cumulative }}">{{ $label }}</a>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
    </div>

    <!-- Card -->
    <div class="container">
    <div class="row g-4">

        <div class="col-12 col-sm-6 col-lg-3" style="margin-top: 20px; margin-bottom: 20px;">
            <div class="card h-100 text-center p-3">
                <div class="card-body">
                    <span class="display-5"><i class="icon-user gradient-3-text"></i></span>
                    <h5 class="card-title">128 Mahasiswa</h5>
                    <p class="card-text">Total mahasiswa terdaftar</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3" style="margin-top: 20px; margin-bottom: 20px;">
            <div class="card h-100 text-center p-3">
                <div class="card-body">
                    <span class="display-5"><i class="icon-briefcase gradient-4-text"></i></span>
                    <h5 class="card-title">7 Dosen</h5>
                    <p class="card-text">Total dosen aktif</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3" style="margin-top: 20px; margin-bottom: 20px;">
            <div class="card h-100 text-center p-3">
                <div class="card-body">
                    <span class="display-5"><i class="icon-book-open gradient-5-text"></i></span>
                    <h5 class="card-title">31 Mata Kuliah</h5>
                    <p class="card-text">Mata kuliah semester ini</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3" style="margin-top: 20px; margin-bottom: 20px;">
            <div class="card h-100 text-center p-3">
                <div class="card-body">
                    <span class="display-5"><i class="fa fa-calendar gradient-9-text"></i></span>
                    <h5 class="card-title">Semester Ganjil</h5>
                    <p class="card-text">2025/2026</p>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End Card -->

<!-- Tabel Activity -->
    
    <div class="row mt-4" style="margin-left: 10px; margin-right: 10px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Aktivitas Terkini Program Studi</h4>
                        <p class="text-muted mb-3">Tanggal: {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:40px">#</th>
                                        <th>Aktivitas</th>
                                        <th style="width:100px">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activities ?? [] as $activity)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ optional($activity)->created_at ? \Carbon\Carbon::parse(optional($activity)->created_at)->format('d M Y') : '—' }}
                                            </td>
                                            <td>{{ optional($activity)->created_at ? \Carbon\Carbon::parse(optional($activity)->created_at)->format('H:i:s') : '—' }}
                                            </td>
                                            <td>{{ optional(optional($activity)->user)->name ?? (optional($activity)->user_name ?? '—') }}
                                            </td>
                                            <td>{{ optional($activity)->description ?? (optional($activity)->activity ?? (optional($activity)->action ?? '—')) }}
                                            </td>
                                        </tr>
                                    @empty

                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada aktivitas hari ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
<!-- End Table Activity -->
@endsection
