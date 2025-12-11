<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Dashboard</li>
            <li>
                <a href="{{ url('akademik/dashboard') }}">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Home</span>
                </a>
            </li>
            <li class="nav-label">Menu</li>
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="icon-grid menu-icon"></i><span class="nav-text">Pengelolaan Akademik</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ url('akademik/semester') }}">
                            <i class="fa fa-book"></i><span class="nav-text">Semester</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('akademik/input-nilai') }}">
                            <i class="fa fa-book"></i><span class="nav-text">Input Nilai</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="icon-grid menu-icon"></i><span class="nav-text">Pengelolaan Jadwal</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ url('akademik/ruang') }}">
                            <i class="fa-solid fa-suitcase"></i><span class="nav-text">Ruang dan Jam</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('akademik/matakuliah') }}">
                            <i class="fa fa-calendar"></i><span class="nav-text">Mata Kuliah</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('akademik/jadwalkuliah') }}">
                            <i class="fa fa-calendar"></i><span class="nav-text">Jadwal Kuliah</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ url('akademik/classes') }}">
                    <i class="icon-chart menu-icon"></i><span class="nav-text">Monitoring Nilai</span>
                </a>
            </li>
        </ul>
    </div>
</div>
