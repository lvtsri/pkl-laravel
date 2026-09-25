@extends('layouts.admin')

@section('content-header')
<h3>Detail Kelas Mata Kuliah</h3><hr>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-success card-outline">
            <div class="card-body">
                <div style="display: flex; gap: 50px;">
                    <table class="table table-borderless">
                    <tr>
                        <th style="padding: 4px 8px; width: 150px;">Nama Kelas</th>
                        <td style="padding: 4px 8px;">:</td>
                    </tr>
                    <tr>
                        <th style="padding: 4px 8px;">Periode</th>
                        <td style="padding: 4px 8px;">:  </td>
                    </tr>
                    <tr>
                        <th style="padding: 4px 8px;">Mata Kuliah</th>
                        <td style="padding: 4px 8px;">: </td>
                    </tr>
                    </table>
                    <table class="table table-borderless">
                    <tr>
                        <th style="padding: 4px 8px; width: 150px;">Jurusan</th>
                        <td style="padding: 4px 8px;">: </td>
                    </tr>
                    <tr>
                        <th style="padding: 4px 8px;">Dosen</th>
                        <td style="padding: 4px 8px;">: </td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="card card-success card-outline">
            <div class="card-body">
                <a href="" class="btn btn-default mb-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Tambah Pertemuan
                </button>
                <a href="" type="button" class="btn btn-danger mb-2" target="_blank">
                    <i class="fas fa-file-pdf"></i>
                    Ekspor Data Presensi
                </a>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th>Pertemuan ke-</th>
                            <th>Judul Pertemuan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection