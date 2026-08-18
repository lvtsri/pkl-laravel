<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home | Mahasiswa</title>
</head>
<body>
    <h2>Home Mahasiswa</h2>
    <a href="{{ route('ubah.pin') }}" class="btn btn-warning">
        <i class="fas fa-key mr-1"></i>
        Ubah PIN
    </a>

    {{-- Logout --}}
    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i>
            Logout👋
        </button>
    </form>
</body>
</html>