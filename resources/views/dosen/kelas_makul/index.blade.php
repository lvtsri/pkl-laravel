@extends('layouts.dosen')

@section('content-header')
  <h1>Kelas Mata Kuliah</h1><hr>
@endsection

@section('content')
  <form action="{{ route('dosen.kelas_makul') }}" method="GET">
    <div class="row">
      <div class="col-2">
        <div class="form-group">
          <select name="semester" class="form-control">
            <option value="">-- Semua Periode --</option>

            @foreach ($listAkademik as $akd)
              <option value="{{ $akd->kode_akd }}" {{ ($selected_periode == $akd->kode_akd) ? 'selected' : '' }}>
                {{ $akd->tahun }} - {{ ($akd->semester == 'GL') ? 'Ganjil' : 'Genap' }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-5">
        <button type="submit" name="btn_filter" class="btn btn-primary mb-2">
          <i class="fas fa-search"></i>
          Tampilkan Data
        </button>
      </div>
    </div>
  </form>

  <div class="card card-primary card-outline">
    <div class="card-body">
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
                <a href="{{ route('dosen.kelas_makul.pertemuan', ['kode_kelas' => $km->kode_kelas]) }}" class="btn btn-success btn-sm">
                  <i class="fas fa-qrcode"></i>
                </a>
                <a href="{{ route('dosen.detail_kelas', ['kode_kelas' => $km->kode_kelas]) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye"></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection