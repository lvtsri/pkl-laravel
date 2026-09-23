@extends('layouts.admin')

@section('content-header')
  <h1>Data Dosen</h1><hr>
@endsection

@section('content')
  <div class="card">
    <div class="card-body">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah-dosen">
        <i class="fas fa-plus"></i>
        Tambah Data
      </button>

      <table id="example1" class="table table-bordered table-striped text-center">
        <thead>
          <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Kontak</th>
            <th>Email</th>
            <th>Jenis Kelamin</th>
            <th>Foto</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        <tbody>
          @foreach ($dosen as $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->nik }}</td>
              <td class="text-left">{{ $d->nama }}</td>
              <td>{{ $d->kontak }}</td>
              <td class="text-left">{{ $d->email }}</td>
              <td class="text-left">
                @if ($d->kelamin == 'P')
                  Perempuan
                @else
                  Laki-laki
                @endif
              </td>
              <td>{{ $d->img }}</td>
              <td class="text-center">
                <a href="" class="btn btn-warning btn-sm">
                  <i class="fas fa-pen"></i>
                </a>
                <a href="" class="btn btn-danger btn-sm" onclick="return confirm('Data dosen yang dipilih akan dihapus. Lanjutkan?')">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection