@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <span class="display-5"><i class="icon-earphones gradient-3-text"></i></span>
                            <h2 class="mt-3">5K Songs</h2>
                            <p>Your playlist download complete</p><a href="javascript:void()"
                                class="btn gradient-3 btn-lg border-0 btn-rounded px-5">Download
                                now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <span class="display-5"><i class="icon-diamond gradient-4-text"></i></span>
                            <h2 class="mt-3">765 Point</h2>
                            <p>Nice, you are doing great!</p>
                            <a href="javascript:void()" class="btn gradient-4 btn-lg border-0 btn-rounded px-5">Redeem
                                now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <span class="display-5"><i class="icon-user gradient-4-text"></i></span>
                            <h2 class="mt-3">5210 Users</h2>
                            <p>Currently active</p><a href="javascript:void()"
                                class="btn gradient-4 btn-lg border-0 btn-rounded px-5">Add
                                more</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <span class="display-5"><i class="icon-grid gradient-9-text"></i></span>
                            <h2 class="mt-3">2 Grid Servers</h2>
                            <p>Currently inactive</p><a href="javascript:void()"
                                class="btn gradient-9 btn-lg border-0 btn-rounded px-5">Fix
                                now</a>
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
