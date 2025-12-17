@extends('layouts.main')

@section('title', 'kurikulum')

@section('content')

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Manajemen Kurikulum</h5>
        </div>

        <div class="card-body">

            @php
                $tahunKurikulums = [
                    ['id'=>1,'nama'=>'2021/2022'],
                    ['id'=>2,'nama'=>'2022/2023'],
                    ['id'=>3,'nama'=>'2023/2024'],
                ];

                // Hardcode data mata kuliah awal
                if(!session()->has('kurikulums')){
                    session(['kurikulums'=>[
                        ['tahun_id'=>1,'semester'=>1,'kode_mk'=>'MK101','nama_mk'=>'Matematika Dasar','sks'=>3,'prasyarat'=>null],
                        ['tahun_id'=>1,'semester'=>1,'kode_mk'=>'MK102','nama_mk'=>'Fisika Dasar','sks'=>4,'prasyarat'=>null],
                        ['tahun_id'=>1,'semester'=>2,'kode_mk'=>'MK201','nama_mk'=>'Algoritma','sks'=>3,'prasyarat'=>'MK101'],
                        ['tahun_id'=>2,'semester'=>1,'kode_mk'=>'MK101','nama_mk'=>'Matematika Dasar','sks'=>3,'prasyarat'=>null],
                        ['tahun_id'=>2,'semester'=>1,'kode_mk'=>'MK103','nama_mk'=>'Kimia Dasar','sks'=>3,'prasyarat'=>null],
                    ]]);
                }

                $kurikulums = session('kurikulums');
                $selectedTahun = request('tahun') ?? 1;

                // Filter data sesuai tahun
                $items = array_filter($kurikulums, fn($mk) => $mk['tahun_id'] == $selectedTahun);

                // Kelompokkan per semester
                $semesterGroups = [];
                foreach($items as $mk){
                    $semesterGroups[$mk['semester']][] = $mk;
                }
            @endphp

            <!-- Dropdown Tahun Kurikulum -->
            <div class="mb-3">
                <label for="tahunSelect" class="form-label">Pilih Tahun Kurikulum:</label>
                <select id="tahunSelect" class="form-select" onchange="updateTable()">
                    @foreach($tahunKurikulums as $tahun)
                        <option value="{{ $tahun['id'] }}" {{ $selectedTahun==$tahun['id'] ? 'selected':'' }}>
                            {{ $tahun['nama'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Form Batch Input Mata Kuliah -->
            <form id="formBatchMK" class="mb-4">
                <div class="row g-3 mb-2">
                    <div class="col-md-2">
                        <label class="form-label">Semester</label>
                        <select id="semesterInput" class="form-select">
                            @for($s=1;$s<=8;$s++)
                                <option value="{{ $s }}">Semester {{ $s }}</option>
                            @endfor
                        </select>
                    </div>
<<<<<<< HEAD
                    <div class="col-md-2">
                        <input type="text" id="kodeMKInput" class="form-control" placeholder="Kode MK">
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="namaMKInput" class="form-control" placeholder="Nama Mata Kuliah">
                    </div>
                    <div class="col-md-1">
                        <input type="number" id="sksInput" class="form-control" placeholder="SKS" value="3">
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="prasyaratInput" class="form-control" placeholder="Prasyarat">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success btn-sm w-100">Tambah</button>
=======
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Semester</th>
                                        <th>Kode MK</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>Wajib/Pilihan</th>
                                        <th>Prasyarat</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kurikulums as $index => $kurikulum)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $kurikulum->tahunAkademik->semester ?? '-'}}
                                                {{ $kurikulum->tahunAkademik->tahun_akademik ?? '-' }}</td>
                                            <td>{{ $kurikulum->kode_mk }}</td>
                                            <td>{{ $kurikulum->nama_mk }}</td>
                                            <td>{{ $kurikulum->sks }}</td>
                                            <td>{{ $kurikulum->wajib_pilihan }}</td>
                                            <td>{{ $kurikulum->prasyarat ?? '-' }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $kurikulum->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $kurikulum->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('kurikulum.edit', $kurikulum->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('kurikulum.destroy', $kurikulum->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Belum ada data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
>>>>>>> 46828818255cff07ca543d82d18744dfa457ce7b
                    </div>
                </div>
            </form>

            <!-- Tabel Mata Kuliah per Semester -->
            <div id="tabelMK">
                @foreach($semesterGroups as $sem=>$mks)
                    <div class="bg-light p-2 fw-bold mt-3">SEMESTER {{ $sem }}</div>
                    <div class="table-responsive mb-2">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light text-center">
                                <tr>
                                    <th style="width:5%">NO</th>
                                    <th style="width:15%">Kode MK</th>
                                    <th>MATA KULIAH</th>
                                    <th style="width:10%">SKS</th>
                                    <th style="width:20%">Prasyarat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalSks=0; @endphp
                                @foreach($mks as $i=>$mk)
                                    <tr>
                                        <td class="text-center">{{ $i+1 }}</td>
                                        <td class="text-center">{{ $mk['kode_mk'] }}</td>
                                        <td>{{ strtoupper($mk['nama_mk']) }}</td>
                                        <td class="text-center">{{ $mk['sks'] }}</td>
                                        <td class="text-center">{{ $mk['prasyarat'] ?? '' }}</td>
                                    </tr>
                                    @php $totalSks += $mk['sks']; @endphp
                                @endforeach
                                <tr class="fw-bold">
                                    <td colspan="3" class="text-end">TOTAL SKS</td>
                                    <td class="text-center">{{ $totalSks }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

<script>
    let kurikulums = @json(session('kurikulums'));

    function updateTable() {
        const tahun = parseInt(document.getElementById('tahunSelect').value);
        const tabelContainer = document.getElementById('tabelMK');
        tabelContainer.innerHTML = '';

        const items = kurikulums.filter(mk=>mk.tahun_id===tahun);
        const semesters = [...new Set(items.map(mk=>mk.semester))].sort((a,b)=>a-b);

        semesters.forEach(sem=>{
            const mks = items.filter(mk=>mk.semester===sem);
            let html = `<div class="bg-light p-2 fw-bold mt-3">SEMESTER ${sem}</div>
                        <div class="table-responsive mb-2">
                        <table class="table table-bordered table-sm">
                        <thead class="table-light text-center">
                        <tr><th>NO</th><th>Kode MK</th><th>MATA KULIAH</th><th>SKS</th><th>Prasyarat</th></tr>
                        </thead><tbody>`;
            let totalSks=0;
            mks.forEach((mk,i)=>{
                html+=`<tr>
                    <td class="text-center">${i+1}</td>
                    <td class="text-center">${mk.kode_mk}</td>
                    <td>${mk.nama_mk.toUpperCase()}</td>
                    <td class="text-center">${mk.sks}</td>
                    <td class="text-center">${mk.prasyarat??''}</td>
                </tr>`;
                totalSks+=mk.sks;
            });
            html+=`<tr class="fw-bold">
                <td colspan="3" class="text-end">TOTAL SKS</td>
                <td class="text-center">${totalSks}</td>
                <td></td>
            </tr></tbody></table></div>`;
            tabelContainer.innerHTML+=html;
        });
    }

    document.getElementById('formBatchMK').addEventListener('submit', function(e){
        e.preventDefault();
        const tahun_id = parseInt(document.getElementById('tahunSelect').value);
        const semester = parseInt(document.getElementById('semesterInput').value);
        const kode_mk = document.getElementById('kodeMKInput').value;
        const nama_mk = document.getElementById('namaMKInput').value;
        const sks = parseInt(document.getElementById('sksInput').value);
        const prasyarat = document.getElementById('prasyaratInput').value || null;

        if(kode_mk && nama_mk){
            kurikulums.push({tahun_id, semester, kode_mk, nama_mk, sks, prasyarat});
            updateTable();
            this.reset();
        }
    });

    updateTable();
</script>

@endsection
