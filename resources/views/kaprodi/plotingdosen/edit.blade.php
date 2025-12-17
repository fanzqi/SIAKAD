@extends('layouts.main')

@section('title', 'Edit Ploting Dosen')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('kaprodi/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('plotingdosen.index') }}">Ploting Dosen Mata Kuliah</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Ploting Dosen Mata Kuliah</a></li>
        </ol>
    </div>
</div>

<div class="container mt-4">
    <h2>Edit Plotting Dosen Mata Kuliah</h2>
    <form action="{{ route('plotingdosen.update', $data->id) }}" method="POST">
        @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_mata_kuliah_id" class="form-label">Nama Mata Kuliah</label>
                        <input type="string" name="nama_mata_kuliah_id" id="nama_mata_kuliah_id"
                            class="form-control @error('nama_mata_kuliah_id') is-invalid @enderror"
                            value="{{ old('nama_mata_kuliah_id', $data->mata_kuliah->nama_mata_kuliah_id) }}" required>
                        @error('nama_mk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sks" class="form-label">Dosen</label>
                        <input type="text" name="dosen" id="dosen"
                            class="form-control @error('dosen') is-invalid @enderror"
                            value="{{ old('dosen', $ploting_dosen->dosen) }}" required>
                        @error('sks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="wajib_pilihan" class="form-label">Wajib/Pilihan</label>
                        <select class="form-control" name="wajib_pilihan" id="wajib_pilihan"
                            class="form-select @error('wajib_pilihan') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="Wajib" {{ old('wajib_pilihan', $kurikulum->wajib_pilihan) == 'Wajib' ? 'selected' : '' }}>Wajib</option>
                            <option value="Pilihan" {{ old('wajib_pilihan', $kurikulum->wajib_pilihan) == 'Pilihan' ? 'selected' : '' }}>Pilihan</option>
                        </select>
                        @error('wajib_pilihan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="prasyarat" class="form-label">Mata Kuliah Prasyarat</label>
                        <select class="form-control" name="prasyarat" id="prasyarat">
                            <option value="">Tidak Ada</option>
                            @if (!empty($kurikulums))
                                @foreach ($kurikulums as $mk)
                                    <option value="{{ $mk->kode_mk }}"
                                        {{ $kurikulum->prasyarat == $mk->kode_mk ? 'selected' : '' }}>
                                        {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="status"
                            class="form-select @error('status') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="Aktif" {{ old('status', $kurikulum->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status', $kurikulum->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tahun_akademik_id" class="form-label">Tahun Akademik</label>
                        <select class="form-control" name="tahun_akademik_id" id="tahun_akademik_id"
                            class="form-select @error('tahun_akademik_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Tahun Akademik --</option>
                            @if (!empty($tahunAkademikList) && count($tahunAkademikList))
                                @foreach ($tahunAkademikList as $tahun)
                                    <option value="{{ $tahun->id }}"
                                        {{ $kurikulum->tahun_akademik_id == $tahun->id ? 'selected' : '' }}>
                                        {{ $tahun->semester }}
                                        {{ substr($tahun->tahun_akademik, 0, 4) }}{{ strtolower($tahun->semester) == 'ganjil' ? 1 : 2 }}
                                        ({{ $tahun->tahun_akademik }})
                                    </option>
                                @endforeach
                            @else
                                <option value="">Tidak ada data tahun akademik</option>
                            @endif
                        </select>
                        @error('tahun_akademik_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    </form>
</div>

@endsection</div>
