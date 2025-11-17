<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SIAKAD || Login</title>
    <link rel="icon" type="{{ asset('image/png') }}" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body class="h-100">

    <div class="login-form-bg h-100">

        <div class="container-fluid h-100">
            <div class="row h-100">

                <!-- LEFT IMAGE -->
                <div class="col-xl-6 p-0">
                    <img src="{{ asset('images/campus.jpg') }}" style="width:100%;height:100%;object-fit:cover;">
                </div>

                <!-- RIGHT FORM -->
                <div class="col-xl-6 d-flex justify-content-center align-items-center">
                    <div class="card p-4" style="width: 75%; border:none; box-shadow:none;">

                        <!-- LOGO BAR -->
                        <div class="text-center mb-3">
                            <img src="{{ asset('images/logo-campus.png') }}" style="height:45px;">
                        </div>

                        <h2 class="text-center" style="color:#3d19ff;font-weight:700;">SIAKAD</h2>
                        <p class="text-center mb-4">Sistem Informasi Akademik</p>
                        @if ($errors->any())
                            <div style="color:red;">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login.process') }}">
                            @csrf

                            <div class="form-group d-flex align-items-center bg-light rounded-pill px-3"
                                style="height:55px;">
                                <span class="mr-3">&#128100;</span>
                                <input type="text" class="form-control border-0 bg-light" name="username"
                                    placeholder="Username" required>
                            </div>

                            <div class="form-group d-flex align-items-center bg-light rounded-pill px-3"
                                style="height:55px;">
                                <span class="mr-3">&#128274;</span>
                                <input type="password" class="form-control border-0 bg-light" name="password"
                                    placeholder="Password" required>
                            </div>

                            <button type="submit" class="btn w-100 rounded-pill"
                                style="height:55px;background:#4b13ff;color:white;font-size:18px;">
                                Masuk
                            </button>
                        </form>



                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/gleek.js') }}"></script>
    <script src="{{ asset('js/styleSwitcher.js') }}"></script>

</body>

</html>
