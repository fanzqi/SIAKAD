<div class="nav-header">
    <div class="brand-logo">
        <a href="index.html">
            <b class="logo-abbr"><img src="{{ asset('images/logo.png') }}" alt=""> </b>
            <span class="logo-compact"><img src="{{ asset('images/logo-compact.png') }}" alt=""></span>
            <span class="brand-title">
                <img src="{{ asset('images/logo-text.png') }}" alt="">
            </span>
        </a>
    </div>
</div>
<div class="header">
    <div class="header-content clearfix">
        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
        </div>
        <div class="header-right">
            <ul class="clearfix">
                <li class="icons dropdown">
                    <div class="user-name d-inline-block mr-3">
                        <a href="#" class="text-dark">{{ Auth::user()->name }}</a>
                    </div>
                    <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                        <span class="activity active"></span>
                        <img src="{{ asset('images/user/1.png') }}" height="40" width="40" alt="">
                    </div>
                    <div class="drop-down dropdown-profile dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li><a href="#"><i class="icon-user"></i> <span>Profile</span></a></li>

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0"><i class="icon-key"></i>
                                            <span>Logout</span></button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
<li class="icons dropdown">

    {{-- Badge icon --}}
    <div class="notify-badge" data-toggle="dropdown">
        <span class="badge badge-pill badge-danger">{{ \App\Models\Notification::count() }}</span>
        <i class="icon-bell"></i>
    </div>

    {{-- Dropdown --}}
    <div class="drop-down dropdown-menu dropdown-notfication">

        <div class="dropdown-content-heading d-flex justify-content-between align-items-center">
            <span class="mb-0 font-weight-medium">Notifikasi</span>
            <span class="badge badge-pill badge-danger">{{ \App\Models\Notification::count() }}</span>
        </div>

        @php
            use App\Models\Notification;
            $notifications = Notification::latest()->limit(5)->get();
        @endphp

        <div class="dropdown-content-body">
            <ul class="list-unstyled m-0">

                @forelse ($notifications as $n)

                    @php
                        $bg = match($n->type) {
                            'add' => '#DDF1FF',      // Biru muda – tambah
                            'edit' => '#FFF4CC',     // Kuning – edit
                            'delete' => '#FFD6D6',   // Merah – hapus
                            default => '#DDF1FF',
                        };

                        $btn = match($n->type) {
                            'add' => 'primary',
                            'edit' => 'warning',
                            'delete' => 'danger',
                            default => 'primary',
                        };
                    @endphp

                    <li class="mb-3">
                        <div class="p-3 rounded position-relative" style="background: {{ $bg }};">

                            {{-- TOMBOL X (hapus notifikasi) --}}
                            <button
                                class="btn btn-sm btn-light position-absolute"
                                style="top: 5px; right: 5px; padding: 0 6px;"
                                onclick="deleteNotification({{ $n->id }}, event)">
                                ×
                            </button>

                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Notifikasi</strong><br>
                                    <span>{{ $n->message }}</span>
                                </div>
                                <small class="text-muted">
                                    {{ $n->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>

                            <div class="mt-2">
                                <button class="btn btn-{{ $btn }} btn-sm px-3">Info</button>
                            </div>
                        </div>
                    </li>

                @empty
                    <li class="text-center p-3">Tidak ada notifikasi</li>
                @endforelse

            </ul>
        </div>
    </div>
</li>




            </ul>
        </div>
    </div>
</div>

<script>
function deleteNotification(id, event) {

    fetch("{{ url('/notification') }}/" + id, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {

            // Hilangkan elemen notifikasi dari tampilan
            const li = event.target.closest("li");
            li.remove();

            // Update badge counter
            let badge = document.querySelector('.notify-badge .badge');
            let current = parseInt(badge.textContent);
            badge.textContent = current - 1;
        }
    })
    .catch(err => console.error(err));
}
</script>

