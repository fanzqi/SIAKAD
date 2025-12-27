@extends('layouts.main')

@section('title', 'Persetujuan Jadwal Kuliah')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('warek1.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Persetujuan Jadwal Kuliah</li>
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
                        @if (session('info'))
                            <div class="alert alert-info alert-dismissible fade show">
                                <strong>Info!</strong> {{ session('info') }}
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('warek1.jadwal.setujuiBulk') }}" method="POST" id="formSetujuiDipilih">
                        @csrf
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-striped zero-configuration">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="40"><input type="checkbox" id="checkAll"></th>
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
                                                <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="checkItem">
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->mata_kuliah->nama_mata_kuliah }}</td>
                                            <td>{{ $item->mata_kuliah->dosen->nama ?? '-' }}</td>
                                            <td>{{ $item->mata_kuliah->program_studi->nama ?? '-' }}</td>
                                            <td>{{ $item->semester }}</td>
                                            <td>{{ $item->hari }}</td>
                                            <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                                            <td>{{ $item->ruang->nama_ruang }}</td>
                                            <td><span class="badge badge-info">Diajukan</span></td>
                                            <td>
                                                {{-- Setujui Satu --}}
                                                <form action="{{ route('warek1.jadwal.setujui', $item->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="button"
                                                        class="btn btn-success btn-sm btn-konfirmasi-single"
                                                        data-url="{{ route('warek1.jadwal.setujui', $item->id) }}"
                                                        data-message="Apakah Anda yakin ingin menyetujui jadwal {{ $item->mata_kuliah->nama_mata_kuliah }}?">
                                                        <i class="bi bi-check-circle"></i> Setujui
                                                    </button>
                                                </form>

                                                {{-- Revisi --}}
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#modalRevisi{{ $item->id }}">
                                                    <i class="bi bi-arrow-repeat"></i> Revisi
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center">Tidak ada jadwal menunggu persetujuan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-body d-flex justify-content-end gap-2" style="gap: 0.5rem;">
                            {{-- Button Setujui Pilihan --}}
                            <button type="button" class="btn btn-success btn-sm btn-konfirmasi"
                                data-url="{{ route('warek1.jadwal.setujuiBulk') }}"
                                data-message="Apakah Anda yakin ingin menyetujui jadwal terpilih?" data-action="bulk">
                                <i class="bi bi-check-circle"></i> Setujui Pilihan
                            </button>
                            <button type="button" class="btn btn-primary btn-sm btn-konfirmasi"
                                data-url="{{ route('warek1.jadwal.setujuiSemua') }}"
                                data-message="Apakah Anda yakin ingin menyetujui semua jadwal?" data-action="semua">
                                <i class="bi bi-check-circle"></i> Setujui Semua
                            </button>
                        </div>

                        {{-- Modal Revisi --}}
                        @foreach ($jadwal as $item)
                            <div class="modal fade" id="modalRevisi{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered justify-content-center"
                                    style="max-width:700px; display:flex;">
                                    <form method="POST" action="{{ route('warek1.jadwal.revisi', $item->id) }}"
                                        style="width:100%;">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title mx-auto"><i class="bi bi-arrow-repeat"></i> Catatan
                                                    Revisi Warek 1</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea name="catatan_warek" class="form-control" rows="6" placeholder="Tuliskan catatan revisi" required></textarea>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning">Kirim Revisi</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi (singular, jangan duplikat) --}}
    <div class="modal fade" id="modalKonfirmasi" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill"></i> Konfirmasi Aksi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="modalKonfirmasiBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" id="btnLanjutModal" class="btn btn-info">Ya, Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = $('#modalKonfirmasi');
            const modalBody = document.getElementById('modalKonfirmasiBody');
            let actionUrl = null;
            let actionType = null;

            document.querySelectorAll('.btn-konfirmasi').forEach(button => {
                button.addEventListener('click', function() {
                    actionUrl = this.getAttribute('data-url');
                    actionType = this.getAttribute('data-action'); // 'bulk' atau 'semua'
                    modalBody.textContent = this.getAttribute('data-message');
                    modal.modal('show');
                });
            });

            document.querySelectorAll('.btn-konfirmasi-single').forEach(button => {
                button.addEventListener('click', function() {
                    actionUrl = this.getAttribute('data-url');
                    actionType = 'single';
                    modalBody.textContent = this.getAttribute('data-message');
                    modal.modal('show');
                });
            });

            document.getElementById('btnLanjutModal').addEventListener('click', function() {
                if (actionType === 'semua') {
                    // Centang semua checkbox sebelum submit!
                    document.querySelectorAll('.checkItem').forEach(cb => cb.checked = true);

                    // Ubah form action ke 'setujuiSemua'
                    const form = document.getElementById('formSetujuiDipilih');
                    form.action = actionUrl;
                    form.submit();

                } else if (actionType === 'bulk') {
                    const form = document.getElementById('formSetujuiDipilih');
                    form.action = actionUrl;
                    form.submit();
                } else if (actionType === 'single') {
                    // Untuk setujui satu record
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = actionUrl;
                    form.style.display = 'none';
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    document.body.appendChild(form);
                    form.submit();
                }
            });

            // ...checkAll script tetap boleh ada...
            document.getElementById('checkAll').addEventListener('change', function() {
                document.querySelectorAll('.checkItem').forEach(cb => cb.checked = this.checked);
            });
        });
    </script>
@endpush
