<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('asset_web/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('asset_web/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('asset_web/dist/css/adminlte.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('asset_web/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    {{-- JS --}}
    <script src="{{ asset('asset_web/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('asset_web/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset_web/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <p><b>Welcome</b> Back!</p>
        </div>
        
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silakan login</p>

                <form action="{{ route('login.process') }}" method="post">
                    @csrf
                    <!-- Usn -->
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="input-group mb-3">
                        <input type="password" name="sandi" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Button -->
                    <div class="social-auth-links text-center mb-3">
                        <button type="submit" class="btn btn-block btn-primary">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 1: VERIFIKASI PIN 2FA -->
    <div class="modal fade" id="modal-default" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pin.verify') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Verifikasi Keamanan PIN</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-info">Silakan masukkan PIN keamanan Anda:</p>
                        <div class="form-group">
                            <input type="password" name="pin" class="form-control" placeholder="Masukkan PIN" maxlength="6" required autofocus>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="{{ route('logout') }}" class="btn btn-default" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Batal</a>
                        <button type="submit" class="btn btn-primary">Verifikasi</button>
                    </div>
                </form>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- JS AdminLTE App -->
    <script src="{{ asset('asset_web/dist/js/adminlte.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Munculin modal PIN 2FA
            @if(session('show_pin_modal'))
                $('#modal-default').modal('show');
            @endif

            // Error login biasa di pojok kanan atas
            @if(session('login_error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: @json(session('login_error')),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            // PIN salah, munculin pop up error PIN
            @if(session('pin_error'))
                Swal.fire({
                    icon: 'error',
                    title: @json(session('pin_error')),
                    showConfirmButton: true,
                    timer: 8000,
                    timerProgressBar: true
                });
                // Munculkan kembali modal jika PIN salah
                $('#modal-default').modal('show');
            @endif
        });
    </script>
</body>
</html>