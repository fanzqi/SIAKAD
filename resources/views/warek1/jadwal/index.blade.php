@extends('layouts.main')

@section('title', 'Persetujuan Jadwal Kuliah')

@section('content')

{{-- BREADCRUMB --}}
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('warek1.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                Persetujuan Jadwal Kuliah
            </li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm">

                {{-- HEADER --}}
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Daftar Jadwal Menunggu Persetujuan</h4>

                </div>

                {{-- ALERT --}}
                <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 330px;">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <strong>Berhasil!</strong> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                </div>

                {{-- FORM BULK --}}
                <form action="{{ route('warek1.jadwal.setujui.bulk') }}" method="POST"
                      onsubmit="return confirm('Setujui jadwal yang dipilih?')">
                    @csrf

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped zero-configuration">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" id="checkAll">
                                    </th>
                                    <th>No</th>
                                    <th>Mata Kuliah</th>
                                    <th>Dosen</th>
                                    <th>Program Studi</th>
                                    <th>Smt</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Ruangan</th>
                                    <th>Status</th>
                                    <th width="180">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($jadwal as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="jadwal_ids[]"
                                                   value="{{ $item->id }}" class="checkItem">
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->mata_kuliah->nama_mata_kuliah }}</td>
                                        <td>{{ $item->mata_kuliah->dosen->nama ?? '-' }}</td>
                                        <td>{{ $item->mata_kuliah->program_studi->nama ?? '-' }}</td>
                                        <td>{{ $item->semester }}</td>
                                        <td>{{ $item->hari }}</td>
                                        <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                                        <td>{{ $item->ruang->nama_ruang }}</td>
                                        <td>
                                            <span class="badge badge-info">Diajukan</span>
                                        </td>
                                        <td>

                                            {{-- SETUJUI SATU --}}
                                            <form action="{{ route('warek1.jadwal.setujui', $item->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-success btn-sm"
                                                    onclick="return confirm('Setujui jadwal ini?')">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>

                                            {{-- REVISI --}}
                                            <button type="button"
                                                    class="btn btn-warning btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#modalRevisi{{ $item->id }}">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">
                                            Tidak ada jadwal menunggu persetujuan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- BUTTON SETUJUI PILIHAN --}}
                    @if($jadwal->count() > 0)
                        <div class="text-right p-3">
                            <button class="btn btn-primary">
                                <i class="bi bi-check2-square"></i> Setujui yang Dipilih
                            </button>
                        </div>
                    @endif

                </form>
            </div>
        </div>
    </div>
</div>

{{-- MODAL REVISI --}}
@foreach ($jadwal as $item)
<div class="modal fade" id="modalRevisi{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:700px;">
        <form method="POST" action="{{ route('warek1.jadwal.revisi', $item->id) }}">
            @csrf
            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="bi bi-arrow-repeat"></i> Catatan Revisi Warek 1
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <textarea name="catatan_warek"
                              class="form-control"
                              rows="6"
                              placeholder="Tuliskan catatan revisi"
                              required></textarea>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        Kirim Revisi
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endforeach

{{-- SCRIPT CHECKBOX --}}
@push('scripts')
<script>
    document.getElementById('checkAll').addEventListener('change', function () {
        document.querySelectorAll('.checkItem').forEach(cb => {
            cb.checked = this.checked;
        });
    });
</script>
@endpush

@endsection
