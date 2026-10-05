@extends('layouts.dosen')

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
                <a href="{{ route('dosen.kelas_makul') }}" class="btn btn-default mb-2">
                    <i class="fas fa-arrow-left"></i> Kembali
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detail_kelas as $dk)
                        <tr class="text-center">
                            <td>{{ $no++ }}</td>
                            <td>{{ $dk->nim }}</td>
                            <td class="text-left">{{ $dk->mahasiswa->nama }}</td>
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

@endsection