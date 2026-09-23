@extends('layouts.admin')

@section('content-header')
  <h1>Data Jurusan</h1><hr>
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
          <tr class="text-center">
            <th width="5%">No</th>
            <th>Kode</th>
            <th>Nama Jurusan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        <tbody>
          @foreach ($jurusan as $j)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $j->kode_jurusan }}</td>
              <td class="text-left">{{ $j->nama_jurusan }}</td>
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