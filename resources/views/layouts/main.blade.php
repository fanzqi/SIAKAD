<!DOCTYPE html>
<html lang="en">

@include('layouts.head')

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

        {{-- Header --}}
        @include('layouts.header')

        {{-- Sidebar sesuai role yang login --}}
        @php
            $role = strtolower(Auth::user()->role);
        @endphp

        @switch($role)
            @case('akademik')
                @include('layouts.sidebar.akademik')
                @break

            @case('warek1')
                @include('layouts.sidebar.warek1')
                @break

            @case('dekan')
                @include('layouts.sidebar.dekan')
                @break

            @case('kaprodi')
                @include('layouts.sidebar.kaprodi')
                @break

            @case('dosen')
                @include('layouts.sidebar.dosen')
                @break

            @case('mahasiswa')
                @include('layouts.sidebar.mahasiswa')
                @break
        @endswitch

        <!-- Content -->
        <div class="content-body">
            @yield('content')
        </div>

        {{-- Footer --}}
        @include('layouts.footer')

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

    <!-- CSS -->


<!-- JS -->
<script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>


</body>
</html>
