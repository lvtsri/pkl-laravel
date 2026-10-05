@extends('layouts.dosen')

@section('content-header')
    <h1>Presensi</h1><hr>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">[{{ $id_pertemuan }}]</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; gap: 50px; align-items: flex-start;">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <div>
                            <img src="{{ asset('asset_web/img/mhs-woman.jpg') }}" style="width: 200px;">
                        </div>
                        @if ($status_pertemuan == '0')
                            <form action="{{ route('dosen.kelas_makul.presensi.toggle', $id_pertemuan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success w-100" onclick="return confirm('Apakah anda yakin ingin membuka presensi ini?')">
                                    Buka Presensi
                                </button>
                            </form>
                        @else
                            <form action="{{ route('dosen.kelas_makul.presensi.toggle', $id_pertemuan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Apakah anda yakin ingin menutup presensi ini?')">
                                    Tutup Presensi
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($info)
                    <table class="table table-sm">
                        <tr>
                            <th style="width: 150px;">NIK</th>
                            <td>: {{ $info->dosen->nik }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>: {{ $info->dosen->nama }}</td>
                        </tr>
                        <tr>
                            <th>Mata Kuliah</th>
                            <td>: {{ $info->makul->nama_makul }}</td>
                        </tr>
                        <tr>
                            <th>Judul Pertemuan</th>
                            <td>: {{ $pertemuan->judul_pertemuan }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>: {{ $info->nama_kelas }}</td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td>: {{ $info->jurusan->nama_jurusan }}</td>
                        </tr>
                        <tr>
                            <th>Hari</th>
                            <td>: </td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>: {{ $pertemuan->tanggal }}</td>
                        </tr>
                        <tr>
                            <th>Pertemuan ke</th>
                            <td>: {{ $pertemuan->pertemuan_ke }}</td>
                        </tr>
                    </table>
                    @endif

                    <div class="text-center">
                        <div>
                            {{ QrCode::size(180)->generate($id_pertemuan) }}
                        </div>
                        <div class="mt-2">
                            Scan QR untuk melakukan presensi
                        </div><br>
                        <p id="countdown_timer" class="text-bold text-red">Presensi telah ditutup</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card card-success card-outline">
            <div class="card-body">
                <a href="{{ route('dosen.kelas_makul.pertemuan', ['kode_kelas' => $info->kode_kelas]) }}" class="btn btn-default mb-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th>Mahasiswa</th>
                            <th width="15%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    ?>
                    @forelse ($presensi as $p)
                    <tr class="text-center">
                        <td>{{ $no++ }}</td>
                        <td class="text-left">[{{ $p->nim }}] - {{ $p->mahasiswa->nama }}</td>
                        <td>{{ $p->status_kehadiran }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-mhs"
                                data-id = "{{ $p->id }}"
                                data-status = "{{ $p->status_kehadiran }}"
                            >
                                <i class="fas fa-pen"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">Data mahasiswa pada presensi ini tidak ditemukan</td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- TIMER --}}
@if ($status_pertemuan == '1')
    <script>
    var countDownDate = new Date().getTime() + (1 * 60 * 1000);

    var x = setInterval(function() {
        // Tanggal dan waktu hari ini
        var now = new Date().getTime();

        // Jarak / hasil waktunya? Misal sisa 5 detik
        var distance = countDownDate - now;

        // Hitung menit n detiknya
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Tampilin hasilnya di elemen (kalo aku pke <p>) yang pake id countdown_timer
        document.getElementById("countdown_timer").innerHTML = minutes + "menit " + seconds + "detik";

        // Kalo timer udah habis (dibawh 0)
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown_timer").innerHTML = "Waktu Habis!";

            window.location.href = "{{ route('dosen.presensi.ubah_status', $id_pertemuan) }}";
        }
    }, 1000);
    </script>
@endif

@endpush