@extends('layouts.main')

@section('title', 'Dashboard Akademik')

@section('content')
    @php
        $segments = request()->segments();
        // Treat 'akademik' as the dashboard root and remove it from segments to avoid duplication
        if (!empty($segments) && $segments[0] === 'akademik') {
            array_shift($segments);
        }
        $mapping = [
            'semester' => 'Semester',
            'jadwal-kuliah' => 'Jadwal Kuliah',
            'monitoring-nilai' => 'Monitoring Nilai',
        ];
        $base = url('akademik');
        $cumulative = $base;
    @endphp

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('akademik/dashboard') }}">Dashboard</a></li>

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
    <div class="container-fluid mt-3">
        <div class="row">
    <!-- Mahasiswa -->
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <span class="display-5"><i class="icon-user gradient-3-text"></i></span>
                    <h2 class="mt-3">200 Mahasiswa</h2>
                    <p>Total mahasiswa terdaftar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dosen -->
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <span class="display-5"><i class="icon-briefcase gradient-4-text"></i></span>
                    <h2 class="mt-3">80 Dosen</h2>
                    <p>Total dosen aktif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mata Kuliah -->
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <span class="display-5"><i class="icon-book-open gradient-5-text"></i></span>
                    <h2 class="mt-3">45 Mata Kuliah</h2>
                    <p>Mata kuliah semester ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Semester -->
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <span class="display-5"><i class="fa fa-calendar gradient-9-text"></i></span>
                    <h2 class="mt-3">Semester Ganjil 2025/2026</h2>
                    <p>Semester Berjalan</p>
                </div>
            </div>
        </div>
    </div>
</div>


        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Single Bar Chart</h4>
                        <div style="position:relative;height:320px;">
                            <canvas id="singleBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function() {
                var ctx = document.getElementById('singleBarChart').getContext('2d');

                var gradient = ctx.createLinearGradient(0, 0, 0, 320);
                gradient.addColorStop(0, 'rgba(54,162,235,0.9)');
                gradient.addColorStop(1, 'rgba(54,162,235,0.2)');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Sales',
                            data: [65, 59, 80, 81, 56, 55],
                            backgroundColor: gradient,
                            borderColor: 'rgba(54,162,235,1)',
                            borderWidth: 1,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    }
                });
            })();
        </script>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Aktivitas Hari Ini</h4>
                        <p class="text-muted mb-3">Tanggal: {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:40px">#</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Pengguna</th>
                                        <th>Aktivitas</th>
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
    </div>


@endsection
