@extends('layouts.admin')

@section('content-header')
  <h1>Data Mata Kuliah</h1><hr>
@endsection

@section('content')
  <div class="card">
    <div class="card-body">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah-dosen">
        <i class="fas fa-plus"></i>
        Tambah Data
      </button>

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th width="5%">No</th>
            <th>Kode</th>
            <th>Nama Mata Kuliah</th>
            <th>Jumlah SKS</th>
            <th>Jumlah CPMK</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        <tbody>
          @foreach ($makul as $m)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $m->kode_makul }}</td>
              <td>{{ $m->nama_makul }}</td>
              <td class="text-center">{{ $m->jml_sks }}</td>
              <td class="text-center">{{ $m->jml_cpmk }}</td>
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