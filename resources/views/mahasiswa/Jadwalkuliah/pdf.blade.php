<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 11px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 4px;
            text-align: center;
        }

        .ttd {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>

<body>

    @foreach ($jadwal as $prodi => $perSemester)
        @foreach ($perSemester as $semester => $jadwals)
            <div class="title">
                <div>JADWAL KULIAH</div>
                <div>PROGRAM STUDI {{ strtoupper($prodi) }}</div>
                <div>SEMESTER {{ $semester }}</div>
                <div>INSTITUT TEKNOLOGI DAN SAINS MANDALA</div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Group</th>
                        <th>Jam</th>
                        <th>Ruangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwals as $i => $j)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $j->hari }}</td>
                            <td>{{ $j->mata_kuliah->nama_mata_kuliah }}</td>
                            <td>{{ $j->mata_kuliah->dosen }}</td>
                            <td>{{ $j->mata_kuliah->group ?? '' }}</td>
                            <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                            <td>{{ $j->ruang->nama_ruang }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="ttd">
                Jember, {{ date('d F Y') }}<br>
                Bagian Akademik<br><br><br>
                <b>( ____________________ )</b>
            </div>

            {{-- GANTI HALAMAN --}}
            <div style="page-break-after: always;"></div>
        @endforeach
    @endforeach

</body>

</html>
