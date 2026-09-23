@extends('layouts.admin')

@section('content-header')
  <h1>Data Kelas Mata Kuliah</h1><hr>
@endsection

@section('content')
  <form action="{{ route('admin.kelas_makul') }}" method="GET">
    <div class="row">
      <div class="col-2">
        <div class="form-group">
          <select name="semester" class="form-control">
            <option value="">-- Pilih Periode --</option>

            @foreach ($listAkademik as $akd)
              <option value="{{ $akd->kode_akd }}" {{ ($selected_periode == $akd->kode_akd) ? 'selected' : '' }}>
                {{ $akd->tahun }} - {{ ($akd->semester == 'GL') ? 'Ganjil' : 'Genap' }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-3">
        <button type="submit" name="btn_filter" class="btn btn-primary mb-2">
          <i class="fas fa-search"></i>
          Tampilkan Data
        </button>
      </div>
    </div>
  </form>

  <div class="card card-primary card-outline">
    <div class="card-body">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah-dosen">
        <i class="fas fa-plus"></i>
        Tambah Data
      </button>

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th>No</th>
            <th>Kelas</th>
            <th>Periode</th>
            <th>Mata Kuliah</th>
            <th>Jurusan</th>
            <th>Dosen</th>
            <th>Aksi</th>
            <th>Download</th>
          </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        <tbody>
          @foreach ($kelas_mk as $km)
            <tr class="text-center">
              <td>{{ $no++ }}</td>
              <td>{{ $km->nama_kelas }}</td>
              <td>{{ $km->akademik->tahun }} - {{ ($km->akademik->semester == 'GL') ? 'Ganjil' : 'Genap' }}</td>
              <td class="text-left">{{ $km->makul->nama_makul }}</td>
              <td class="text-left">{{ $km->jurusan->nama_jurusan }}</td>
              <td class="text-left">{{ $km->dosen->nama }}</td>
              <td>
                <a href="" class="btn btn-success btn-sm">
                  <i class="fas fa-qrcode"></i>
                </a>
                <a href="" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye"></i>
                </a>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit">
                  <i class="fas fa-pen"></i>
                </button>
                <a href="" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ga bang?')">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
              <td>
                <a href="" class="btn btn-danger btn-sm">
                  <i class="fas fa-file-pdf"></i>
                  Hasil Rekapitulasi
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection