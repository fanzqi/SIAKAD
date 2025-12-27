<div class="nav-header">
    <div class="brand-logo">
        <a href="{{ url('#') }}">
            <div class="d-flex align-items-center" style="transform: translate(-10px, -10px);">
                <img src="{{ url('images/logo-itsm.png') }}" alt="Logo SIAKAD ITSM" height="48" class="mr-1">
                <span class="brand-text text-white font-weight-bold" style="line-height:1; color:#fff;">
                    SIAKAD ITSM
                </span>
            </div>
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
                        <a href="#" class="text-dark">
                            <span class="text-capitalize">
                                {{ Auth::user()->dosen?->nama ?? (Auth::user()->mahasiswa?->nama ?? Auth::user()->name) }}
                            </span>
                        </a>
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
                                        <button type="submit" class="btn btn-link p-0">
                                            <i class="icon-key"></i> <span>Logout</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                @php
                    $notifications = Auth::user()
                        ->notifications()
                        ->wherePivot('is_read', 0)
                        ->orderByPivot('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp

                <li class="icons dropdown">
                    <div class="notify-badge" data-toggle="dropdown">
                        <span class="badge badge-pill badge-danger">{{ $count }}</span>
                        <i class="icon-bell"></i>
                    </div>

                    <div class="drop-down dropdown-menu dropdown-notfication">
                        <div class="dropdown-content-heading d-flex justify-content-between align-items-center">
                            <span class="mb-0 font-weight-medium">Notifikasi</span>
                            <span class="badge badge-pill badge-danger">{{ $count }}</span>
                        </div>

                        <div class="dropdown-content-body">
                            <ul class="list-unstyled m-0">
                                @forelse ($notifications as $notif)
                                    @php
                                        $alertClass = match ($notif->type) {
                                            'add' => 'alert-primary',
                                            'edit' => 'alert-warning',
                                            'delete' => 'alert-danger',
                                            'revisi' => 'alert-warning',
                                            'disetujui' => 'alert-success',
                                            'jadwal_published' => 'alert-info',
                                            default => 'alert-secondary',
                                        };
                                    @endphp

                                    <li class="mb-3" id="notification-{{ $notif->id }}">
                                        <div class="alert {{ $alertClass }} alert-dismissible fade show position-relative"
                                            role="alert">
                                            <strong>{{ $notif->author_name }}</strong><br>
                                            <span>{{ $notif->message }}</span>
                                            <div class="mt-2 text-muted" style="font-size: 0.85rem;">
                                                {{-- Ambil waktu attach ke user --}}
                                                {{ \Carbon\Carbon::parse($notif->pivot->created_at ?? $notif->created_at)->isoFormat('dddd, D MMMM YYYY HH:mm') }}
                                            </div>
                                            <button type="button" class="close" aria-label="Close"
                                                onclick="deleteNotification({{ $notif->id }}, this)">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
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
    function deleteNotification(id, btn) {
        const li = btn.closest('li');
        li.remove();
        let badge = document.querySelector('.notify-badge .badge');
        badge.textContent = parseInt(badge.textContent) - 1;
        fetch("{{ url('/akademik/notification') }}/" + id, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        }).then(res => res.json()).catch(err => console.error(err));
    }
</script>
