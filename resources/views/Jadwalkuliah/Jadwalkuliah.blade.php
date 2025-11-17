@extends('layouts.main')

@section('title', 'Jadwal Kuliah')

@section('content')
<div class="row">
    <!-- SLOT WAKTU KULIAH -->
    <div class="col-lg-6 col-12">
        <div class="card shadow-sm">
            <div class="card-body ">
                <h4 class="card-title mb-3">Slot Waktu Kuliah</h4>

                <button id="addSlotBtn" class="btn btn-success mb-3">Tambah Slot</button>

                <!-- Form Tambah Slot -->
                <div id="slotCreatePanel" class="mb-4 d-none">
                    <form id="slotCreateForm" method="POST" action="#">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="slot_start_new" class="form-label">Waktu Mulai</label>
                                <input id="slot_start_new" name="start_time" type="time" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="slot_end_new" class="form-label">Waktu Selesai</label>
                                <input id="slot_end_new" name="end_time" type="time" class="form-control" required>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <button type="button" id="cancelSlotCreate" class="btn btn-secondary">Batal</button>
                        </div>
                    </form>
                </div>

                <!-- Daftar Slot -->
                <div id="slotList">
                    <form class="slotItemForm" method="POST" action="#" data-id="1">
                        @csrf
                        <div class="row align-items-center g-2">
                            <div class="col-md-5">
                                <input type="time" name="start_time" class="form-control" value="07:00" disabled>
                            </div>
                            <div class="col-md-5">
                                <input type="time" name="end_time" class="form-control" value="08:30" disabled>
                            </div>
                            <div class="col-md-2 text-end">
                                <button type="button" class="btn btn-outline-primary btn-sm editSlotBtn">Edit</button>
                                <button type="submit" class="btn btn-primary btn-sm saveSlotBtn d-none">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    
    <!-- DAFTAR RUANGAN -->
    <div class="col-lg-6 col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-3">Daftar Ruangan</h4>

                <button id="addRoomBtn" class="btn btn-success mb-3">Tambah Ruangan</button>

                <!-- Form Tambah Ruangan -->
                <div id="roomCreatePanel" class="mb-4 d-none">
                    <form id="roomCreateForm" method="POST" action="#">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label for="room_name_new" class="form-label">Nama Ruangan</label>
                                <input id="room_name_new" name="room_name" type="text" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label for="room_capacity_new" class="form-label">Kapasitas</label>
                                <input id="room_capacity_new" name="capacity" type="number" min="1" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="room_type_new" class="form-label">Tipe Ruangan</label>
                                <select id="room_type_new" name="type" class="form-control" required>
                                    <option value="">Pilih tipe</option>
                                    <option value="Lab">Laboratorium</option>
                                    <option value="Kelas">Kelas</option>
                                    <option value="Ruang Dosen">Ruang Dosen</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <button type="button" id="cancelRoomCreate" class="btn btn-secondary">Batal</button>
                        </div>
                    </form>
                </div>

                <!-- Daftar Ruangan -->
                <div id="roomList">
                    <form class="roomItemForm" method="POST" action="#" data-id="1">
                        @csrf
                        <div class="row g-2 align-items-center">
                            <div class="col-md-3">
                                <input type="text" name="room_name" class="form-control" value="Lab-202" disabled>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="capacity" class="form-control" value="24" disabled>
                            </div>
                            <div class="col-md-4">
                                <select name="type" class="form-control" disabled>
                                    <option value="Lab" selected>Laboratorium</option>
                                    <option value="Kelas">Kelas</option>
                                    <option value="Ruang Dosen">Ruang Dosen</option>
                                </select>
                            </div>
                            <div class="col-md-3 text-end">
                                <button type="button" class="btn btn-outline-primary btn-sm editRoomBtn">Edit</button>
                                <button type="submit" class="btn btn-primary btn-sm saveRoomBtn d-none">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const show = el => el.classList.remove('d-none');
        const hide = el => el.classList.add('d-none');

        // === SLOT ===
        const addSlotBtn = document.getElementById('addSlotBtn');
        const slotCreatePanel = document.getElementById('slotCreatePanel');
        const cancelSlotCreate = document.getElementById('cancelSlotCreate');

        addSlotBtn.addEventListener('click', () => {
            show(slotCreatePanel);
            addSlotBtn.disabled = true;
        });
        cancelSlotCreate.addEventListener('click', () => {
            hide(slotCreatePanel);
            addSlotBtn.disabled = false;
            document.getElementById('slotCreateForm').reset();
        });

        // === RUANGAN ===
        const addRoomBtn = document.getElementById('addRoomBtn');
        const roomCreatePanel = document.getElementById('roomCreatePanel');
        const cancelRoomCreate = document.getElementById('cancelRoomCreate');

        addRoomBtn.addEventListener('click', () => {
            show(roomCreatePanel);
            addRoomBtn.disabled = true;
        });
        cancelRoomCreate.addEventListener('click', () => {
            hide(roomCreatePanel);
            addRoomBtn.disabled = false;
            document.getElementById('roomCreateForm').reset();
        });

        // === FORM SUBMIT SIMULASI ===
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.matches('#slotCreateForm, .slotItemForm, #roomCreateForm, .roomItemForm')) {
                e.preventDefault();
                console.log('Simulated submit for', form);

                if (form.id === 'slotCreateForm') {
                    hide(slotCreatePanel);
                    addSlotBtn.disabled = false;
                    form.reset();
                }
                if (form.id === 'roomCreateForm') {
                    hide(roomCreatePanel);
                    addRoomBtn.disabled = false;
                    form.reset();
                }

                if (form.classList.contains('slotItemForm') || form.classList.contains('roomItemForm')) {
                    form.querySelectorAll('input, select').forEach(i => i.disabled = true);
                    form.querySelector('.saveSlotBtn')?.classList.add('d-none');
                    form.querySelector('.saveRoomBtn')?.classList.add('d-none');
                    form.querySelector('.editSlotBtn')?.classList.remove('d-none');
                    form.querySelector('.editRoomBtn')?.classList.remove('d-none');
                }
            }
        });

        // === EDIT TOGGLE ===
        document.getElementById('slotList').addEventListener('click', function (e) {
            if (e.target.matches('.editSlotBtn')) {
                const form = e.target.closest('.slotItemForm');
                form.querySelectorAll('input[type="time"]').forEach(i => i.disabled = false);
                e.target.classList.add('d-none');
                form.querySelector('.saveSlotBtn').classList.remove('d-none');
            }
        });

        document.getElementById('roomList').addEventListener('click', function (e) {
            if (e.target.matches('.editRoomBtn')) {
                const form = e.target.closest('.roomItemForm');
                form.querySelectorAll('input, select').forEach(i => i.disabled = false);
                e.target.classList.add('d-none');
                form.querySelector('.saveRoomBtn').classList.remove('d-none');
            }
        });
    })();
</script>
@endpush

@endsection
