@extends('layouts.mahasiswa')

@section('content-header')
  <h1>Ganti Password</h1><hr>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-4">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-lock"></i> Ganti Password
        </h3>
      </div>
      <div class="card-body">
        <form action="{{ route('mahasiswa.password.update', ['username' => $username]) }}" method="post">
          @csrf
          <div class="form-group">
            <label for="password_lama">Password Lama</label>
            <input type="text" name="pengguna" value="{{ $username }}" class="form-control" hidden>
            <input type="password" name="password_lama" class="form-control" placeholder="Masukkan password lama" required>
          </div>
          <div class="form-group">
            <label for="password_baru">Password Baru</label>
            <input type="password" name="password_baru" class="form-control" maxlength="10" placeholder="Masukkan password baru max. 10 char" required>
          </div>
          <div class="form-group">
            <label for="pin2fa">PIN</label>
            <input type="number" name="pin" class="form-control" maxlength="6" placeholder="Masukkan PIN anda" required>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" name="btn_edit"><i class="fas fa-edit"></i> Ubah Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection