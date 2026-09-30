@extends('layouts.admin')

@section('content-header')
<h3>Detail Kelas Mata Kuliah</h3><hr>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div style="display: flex; gap: 50px;">
                    @if ($info)
                    <table class="table table-borderless">
                        <tr>
                            <th style="padding: 4px 8px; width: 150px;">Nama Kelas</th>
                            <td style="padding: 4px 8px;">: {{ $info->nama_kelas }}</td>
                        </tr>
                        <tr>
                            <th style="padding: 4px 8px;">Periode</th>
                            <td style="padding: 4px 8px;">: {{ $info->akademik->tahun }} - {{ ($info->akademik->semester) == 'GL' ? 'Ganjil' : 'Genap' }} </td>
                        </tr>
                        <tr>
                            <th style="padding: 4px 8px;">Mata Kuliah</th>
                            <td style="padding: 4px 8px;">: {{ $info->makul->nama_makul }}</td>
                        </tr>
                    </table>
                    <table class="table table-borderless">
                        <tr>
                            <th style="padding: 4px 8px; width: 150px;">Jurusan</th>
                            <td style="padding: 4px 8px;">: {{ $info->jurusan->nama_jurusan }}</td>
                        </tr>
                        <tr>
                            <th style="padding: 4px 8px;">Dosen</th>
                            <td style="padding: 4px 8px;">: {{ $info->dosen->nama }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline">
            <div class="card-body">
                <a href="{{ route('admin.kelas_makul') }}" class="btn btn-default mb-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Tambah Mahasiswa
                </button>
                <a href="" type="button" class="btn btn-danger mb-2" target="_blank">
                    <i class="fas fa-file-pdf"></i>
                    Ekspor Data
                </a>
                <?php
                    $no = 1;
                ?>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detail_kelas as $dk)
                        <tr class="text-center">
                            <td>{{ $no++ }}</td>
                            <td>{{ $dk->nim }}</td>
                            <td class="text-left">{{ $dk->mahasiswa->nama }}</td>
                            <td>
                                <form action="{{ route('admin.detail_kelas.destroy', ['id' => $dk->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Mahasiswa yang dipilih akan dihapus dari kelas ini. Lanjutkan?')">
                                    <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="4">Data mahasiswa tidak ditemukan!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Mahasiswa {{ $info->nama_kelas }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.detail_kelas.store', ['kode_kelas' => $info->kode_kelas]) }}" method="post">
            @csrf
                <div class="modal-body">
                    <div class="form-group">
                        {{-- <input type="text" name="kode_kelas" value="{{ $info->kode_kelas }}"> --}}
                        <label>Mahasiswa</label>
                        <select class="form-control" name="nim" required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            @foreach ($list_mhs as $mhs)
                            <option value="{{ $mhs->nim }}">
                                [{{ $mhs->nim }}] - {{ $mhs->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="btn_tambah" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection