<!DOCTYPE html>
<html lang="en">

@include('partials.head')

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div id="main-wrapper">

        @include('partials.header')
        @include('partials.sidebar')

        <!-- Content -->
        <div class="content-body">
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

                        @foreach($segments as $i => $seg)
                            @php
                                $cumulative .= '/' . $seg;
                                $isLast = $i === array_key_last($segments);
                                $label = $mapping[$seg] ?? ucwords(str_replace(['-','_'], ' ', $seg));
                            @endphp

                            <li class="breadcrumb-item {{ $isLast ? 'active' : '' }}">
                                @if($isLast)
                                    <a href="javascript:void(0)">{{ $label }}</a>
                                @else
                                    <a href="{{ $cumulative }}">{{ $label }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
            @yield('content')
        </div>

        @include('partials.footer')

    </div>

    <!-- Scripts -->
    <script src="{{ asset('plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/gleek.js') }}"></script>
    <script src="{{ asset('js/styleSwitcher.js') }}"></script>

    <script src="{{ asset('/plugins/tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/plugins/tables/js/datatable-init/datatable-basic.min.js') }}"></script>
</body>
</html>
