@extends('layouts.admin')

@section('content-header')
  <h1>Beranda</h1><hr>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ $total_dosen }}</h3>
        <p>Total Dosen</p>
      </div>
      <div class="icon">
        <i class="fas fa-chalkboard-teacher"></i>
      </div>
      <a href="{{ route('admin.dosen') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $total_mhs }}</h3>
        <p>Total Mahasiswa</p>
      </div>
      <div class="icon">
        <i class="fas fa-user-graduate"></i>
      </div>
      <a href="{{ route('admin.mahasiswa') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $total_kls_mk }}</h3>
        <p>Total Kelas Mata Kuliah</p>
      </div>
      <div class="icon">
        <i class="fas fa-book-open"></i>
      </div>
      <a href="{{ route('admin.kelas_makul') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>

{{-- Welcome sign --}}
<div class="row">
  <div class="col-12">
    <div class="callout callout-success">
      Selamat datang, <b>{{ session('nama') }}</b> !
    </div>
  </div>
</div>

<div class="row">
  {{-- List Kls MK --}}
  <div class="col-lg-6">
    <div class="card card-success card-outline">
      <div class="card-header">
        <h3 class="card-title">Daftar Kelas Mata Kuliah</h3>
      </div>
      <div class="card-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th>No</th>
            <th>Kelas</th>
            <th>Mata Kuliah</th>
          </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        <tbody>
          @foreach ($kelas_mk as $km)
            <tr class="text-center">
              <td width="5%">{{ $no++ }}</td>
              <td>{{ $km->nama_kelas }}</td>
              <td class="text-left">{{ $km->makul->nama_makul }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      </div>
    </div>
  </div>

  {{-- List Dosen 5 terbaru --}}
  <div class="col-lg-6">
    <div class="card card-success card-outline">
      <div class="card-header">
        <h3 class="card-title">Daftar Data Dosen Terbaru</h3>
      </div>
      <div class="card-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th>No</th>
            <th>Nama</th>
          </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        <tbody>
          @foreach ($dosen_terbaru as $d)
            <tr class="text-center">
              <td width="5%">{{ $no++ }}</td>
              <td class="text-left">{{ $d->nama }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
@endsection