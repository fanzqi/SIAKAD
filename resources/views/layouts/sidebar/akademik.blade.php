<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">

            <!-- DASHBOARD -->
            <li class="nav-label">Dashboard</li>
            <li>
                <a href="{{ url('akademik/dashboard') }}">
                    <i class="icon-speedometer menu-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- MENU AKADEMIK -->
            <li class="nav-label">Menu Akademik</li>
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="icon-grid menu-icon"></i>
                    <span class="nav-text">Pengelolaan Akademik</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ url('akademik/semester') }}">
                            <i class="fa fa-book"></i> Semester
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('akademik/input-nilai') }}">
                            <i class="fa fa-pencil"></i> Input Nilai
                        </a>
                    </li>
                </ul>
            </li>

            <!-- JADWAL -->
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="icon-grid menu-icon"></i>
                    <span class="nav-text">Pengelolaan Jadwal</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ url('akademik/ruang') }}">
                            <i class="fa fa-clock-o"></i> Ruang & Jam
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('akademik/matakuliah') }}">
                            <i class="fa fa-book"></i> Mata Kuliah
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('akademik/jadwalkuliah') }}">
                            <i class="fa fa-calendar"></i> Jadwal Kuliah
                        </a>
                    </li>
                </ul>
            </li>

            <!-- MONITORING -->
            <li class="nav-label">Monitoring</li>
            <li>
                <a href="{{ url('akademik/classes') }}">
                    <i class="icon-chart menu-icon"></i>
                    <span class="nav-text">Monitoring Nilai</span>
                </a>
            </li>

        </ul>
    </div>
</div>
