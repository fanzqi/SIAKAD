<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Kuliah</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 5px; text-align: center; }
        h2, h3, h4 { margin: 0; padding: 0; text-align: center; }
    </style>
</head>
<body>
    <h2>JADWAL KULIAH</h2>
    <h3>INSTITUT TEKNOLOGI DAN SAINS MANDALA</h3>
    <br>

    @foreach($jadwal as $prodi => $semesterGroup)
        <h3>Program Studi: {{ $prodi }}</h3>
        @foreach($semesterGroup as $semester => $jadwals)
            <h4>Semester: {{ $semester }}</h4>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Program Studi</th>
                        <th>Semester</th>
                        <th>Group</th>
                        <th>Ruangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwals as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->hari }}</td>
                            <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                            <td>{{ $item->mata_kuliah?->nama_mata_kuliah ?? '-' }}</td>
                            <td>{{ $item->mata_kuliah?->dosen?->nama ?? '-' }}</td>
                            <td>{{ $item->mata_kuliah?->program_studi?->nama ?? '-' }}</td>
                            <td>{{ $item->semester }}</td>
                            <td>{{ $item->mata_kuliah?->group ?? '-' }}</td>
                            <td>{{ $item->ruang?->nama_ruang ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endforeach

    <br><br>
    <table style="width: 100%; border: none;">
        <tr>
            <td></td>
            <td style="text-align: center;">
                Jember, {{ date('d F Y') }}<br>
                Wakil Rektor I<br><br><br><br>
                ________________________
            </td>
        </tr>
    </table>
</body>
</html>
