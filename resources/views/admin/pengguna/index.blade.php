@extends('layouts.admin')

@section('content-header')
  <h1>Data Pengguna</h1><hr>
@endsection

@section('content')
  <div class="card">
    <div class="card-body">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah-user">
        <i class="fas fa-plus"></i> 
        Tambah Data
      </button>

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th width="5%">No</th>
            <th>Username</th>
            <th>Nama Pengguna</th>
            <th>Peran</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <?php
          $no = 1;
        ?>
        <tbody>
          @forelse ($pengguna as $item)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $item->username }}</td>
              <td>{{ $item->nama }}</td>
              <td>
                @if ($item->peran == 'M')
                    Mahasiswa
                @elseif ($item->peran == 'D')
                    Dosen
                @else
                    Admin
                @endif
              </td>
              <td class="text-center">
                <a href="" class="btn btn-warning btn-sm">
                  <i class="fas fa-pen"></i>
                </a>
                <a href="" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ga bang?')">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">Data pengguna tidak ditemukan</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
@endsection