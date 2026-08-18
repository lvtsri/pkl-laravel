<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah PIN</title>

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
            <p><b>Ubah</b> PIN</p>
        </div>
        
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silakan masukkan PIN baru</p>

                <form action="{{ route('pin.update') }}" method="post">
                    @csrf
                    <!-- PIN lama -->
                    <div class="input-group mb-3">
                        <input type="password" name="pin_lama" class="form-control" placeholder="Masukkan PIN lama" maxlength="6" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- PIN baru -->
                    <div class="input-group mb-3">
                        <input type="password" name="pin_baru" class="form-control" placeholder="Masukkan PIN baru" maxlength="6" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Konfirmasi PIN baru -->
                    <div class="input-group mb-3">
                        <input type="password" name="konfirmasi_pin" class="form-control" placeholder="Konfirmasi PIN baru" maxlength="6" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Button -->
                    <div class="social-auth-links text-center mb-3">
                        <button type="submit" class="btn btn-block btn-primary">
                            Simpan PIN Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS AdminLTE App -->
    <script src="{{ asset('asset_web/dist/js/adminlte.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            @if(session('pin_error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: @json(session('pin_error')),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if(session('pin_success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: @json(session('pin_success')),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

        });
    </script>
</body>
</html>