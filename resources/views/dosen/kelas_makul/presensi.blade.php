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
                            @if ($info->dosen->kelamin == 'P')
                                <img src="{{ !empty($info->dosen->img) ? asset('storage/' . $info->dosen->img) : asset('asset_web/img/dosen-woman.jpg') }}" style="width: 210px; object-fit: cover;">
                            @else
                                <img src="{{ !empty($info->dosen->img) ? asset('storage/' . $info->dosen->img) : asset('asset_web/img/dosen-man.jpg') }}" style="width: 210px; object-fit: cover;">
                            @endif
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
                            <td>: {{ date('l', strtotime($pertemuan->tanggal)) }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>: {{ date('d F Y', strtotime($pertemuan->tanggal)) }}</td>
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

<!-- MODAL EDIT DATA-->
<div class="modal fade" id="modal-edit-mhs">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Kehadiran Mahasiswa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-kehadiran" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" name="id" hidden required>
                        <input type="text" name="id_pertemuan" value="{{ $id_pertemuan }}" hidden>
                        
                        <select class="form-control" name="status_kehadiran" required>
                            <option value="">-- Pilih Kehadiran --</option>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="btn_edit_mhs" class="btn btn-primary">
                        <i class="fas fa-pen"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection

@push('scripts')
<script>
    $('#modal-edit-mhs').on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var id = button.data('id');
        var status_kehadiran = button.data('status_kehadiran');

        var modal = $(this);
        modal.find('input[name="id"]').val(id);
        modal.find('select[name="status_kehadiran"]').val(status_kehadiran);

        var actionUrl = "{{ url('/admin/kelas-makul/presensi/kehadiran') }}/" + id;
        modal.find('#form-edit-kehadiran').attr('action', actionUrl);
    })
</script>

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