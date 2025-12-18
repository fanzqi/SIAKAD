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
                            <div class="alert alert-danger text-center">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif


                        <form method="POST" action="{{ route('login.process') }}">
                            @csrf

                            <div class="form-group d-flex align-items-center bg-light rounded-pill px-3 mb-3"
                                style="height:55px;">
                                <span class="mr-3">&#128100;</span>
                                <input type="text" class="form-control border-0 bg-light" name="username"
                                    placeholder="Username / NIDN / NIM" required autofocus>
                            </div>

                            <div class="form-group d-flex align-items-center bg-light rounded-pill px-3 mb-4 position-relative"
                                style="height:55px;">
                                <span class="mr-3">&#128274;</span>
                                <input type="password" class="form-control border-0 bg-light" name="password"
                                    placeholder="Password" required id="password-input">
                                <span class="position-absolute" style="right:20px; cursor:pointer;"
                                    onclick="togglePassword()">
                                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path id="eye-open" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path id="eye-open2" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </span>
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

    //-- Eye toggle password visibility script -->
    <script>
        function togglePassword() {
            const input = document.getElementById('password-input');
            const icon = document.getElementById('eye-icon');
            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.873 6.876A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.293 5.07M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                `;
            } else {
                input.type = "password";
                icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>


</body>

</html>
