@extends('layouts.dosen')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-success card-outline">
            <div class="card-body">
                @if ($info)
                <div style="display: flex; gap: 50px;">
                    <table class="table table-borderless">
                        <tr>
                            <th style="padding: 4px 8px; width: 150px;">Nama Kelas</th>
                            <td style="padding: 4px 8px;">: {{ $info->nama_kelas }}</td>
                        </tr>
                        <tr>
                            <th style="padding: 4px 8px;">Periode</th>
                            <td style="padding: 4px 8px;">: {{ $info->akademik->tahun }} - {{ ($info->akademik->semester == 'GL') ? 'Ganjil' : 'Genap' }}</td>
                        </tr>
                        <tr>
                            <th style="padding: 4px 8px;">Mata Kuliah</th>
                            <td style="padding: 4px 8px;">: {{ $info->makul->nama_makul ?? '-' }}</td>
                        </tr>
                    </table>
                    <table class="table table-borderless">
                        <tr>
                            <th style="padding: 4px 8px; width: 150px;">Jurusan</th>
                            <td style="padding: 4px 8px;">: {{ $info->jurusan->nama_jurusan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="padding: 4px 8px;">Dosen</th>
                            <td style="padding: 4px 8px;">: {{ $info->dosen->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                @endif
            </div>
        </div>

        <div class="card card-success card-outline">
            <div class="card-body">
                <a href="{{ route('dosen.kelas_makul') }}" class="btn btn-default mb-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
                    <i class="fas fa-plus"></i> Tambah Pertemuan
                </button>
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
                    <?php
                    $no = 1;
                    ?>
                    @forelse ($pertemuan as $p)
                    <tr class="text-center">
                        <td>{{ $no++ }}</td>
                        <td>{{ $p->pertemuan_ke }}</td>
                        <td class="text-left">{{ $p->judul_pertemuan }}</td>
                        <td>{{ $p->tanggal }}</td>
                        <td>
                            <a href="{{ route('dosen.kelas_makul.presensi', ['id_pertemuan' => $p->id]) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-qrcode"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Data pertemuan tidak ditemukan</td>
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
                <h4 class="modal-title">Tambah Pertemuan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('dosen.kelas_makul.pertemuan.store', ['kode_kelas' => $info->kode_kelas]) }}" method="post">
            @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Pertemuan</label>
                        <input type="text" class="form-control" name="judul_pertemuan" placeholder="Masukkan judul pertemuan" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Pertemuan</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ now()->format('Y-m-d') }}" required readonly>
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