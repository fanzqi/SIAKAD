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

                {{-- User info --}}
                <li class="icons dropdown">
                    <div class="user-name d-inline-block mr-3">
                        <a href="#" class="text-dark">
                            {{ Auth::user()->name }}
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

                {{-- Notifikasi --}}
                <li class="icons dropdown">
                    @php
                        use App\Models\Notification;

                        $notifications = Notification::where(function ($q) {
                            $q->whereNull('user_id')->orWhere('user_id', Auth::id());
                        })
                            ->whereDoesntHave('users', function ($q) {
                                $q->where('user_id', Auth::id())->where('is_read', 1);
                            })
                            ->latest()
                            ->limit(5)
                            ->get();

                        $count = $notifications->count();
                    @endphp

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
                                @forelse ($notifications as $n)
                                    @php
                                        $alertClass = match ($n->type) {
                                            'add' => 'alert-primary',
                                            'edit' => 'alert-warning',
                                            'delete' => 'alert-danger',
                                            default => 'alert-secondary',
                                        };
                                    @endphp

                                    <li class="mb-3" id="notification-{{ $n->id }}">
                                        <div class="alert {{ $alertClass }} alert-dismissible fade show position-relative"
                                            role="alert">
                                            <strong>{{ $n->author_name }}</strong><br>
                                            <span>{{ $n->message }}</span>

                                            {{-- Tombol hapus / tandai dibaca --}}
                                            <button type="button" class="close" aria-label="Close"
                                                onclick="deleteNotification({{ $n->id }}, this)">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                            <div class="mt-2">
                                                <button class="btn btn-sm btn-info px-3">Info</button>
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
    function deleteNotification(id, btn) {
        // Hapus notifikasi langsung dari DOM
        const li = btn.closest('li');
        li.remove();

        // Update badge
        let badge = document.querySelector('.notify-badge .badge');
        badge.textContent = parseInt(badge.textContent) - 1;

        // Tandai sebagai dibaca di database per user
        fetch("{{ url('/akademik/notification') }}/" + id, {
                method: "PATCH",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    is_read: 1
                })
            })
            .then(res => res.json())
            .catch(err => console.error(err));
    }
</script>
