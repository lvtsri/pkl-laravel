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
            <option value="">-- Semua Periode --</option>

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
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
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
                <a href="{{ route('admin.kelas_makul.pertemuan') }}" class="btn btn-success btn-sm">
                  <i class="fas fa-qrcode"></i>
                </a>
                <a href="{{ route('admin.detail_kelas') }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye"></i>
                </a>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit"
                  data-kode_kelas = "{{ $km->kode_kelas }}"
                  data-kode_akd = "{{ $km->kode_akd }}"
                  data-kode_makul = "{{ $km->kode_makul }}"
                  data-kode_jurusan = "{{ $km->kode_jurusan }}"
                  data-nik = "{{ $km->nik }}"
                  data-nama_kelas = "{{ $km->nama_kelas }}"
                >
                  <i class="fas fa-pen"></i>
                </button>
                <form action="{{ route('admin.kelas_makul.destroy', $km->kode_kelas) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Data kelas yang dipilih akan dihapus. Lanjutkan?')">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
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

  <!-- MODAL TAMBAH -->
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Periode Akademik</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.kelas_makul.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>Kelas</label>
              <input type="text" class="form-control" name="nama_kelas" placeholder="Masukkan nama kelas (Contoh: TI 2C)" required>
            </div>

            <div class="form-group">
              <label>Periode Akademik</label>
              <select class="form-control" name="kode_akd" required>
                <option value="">-- Pilih Periode --</option>
                @foreach ($listAkademikAktif as $akd)
                  <option value="{{ $akd->kode_akd }}">
                    [{{ $akd->kode_akd }}] - {{ $akd->tahun }} {{ $akd->semester == 'GN' ? 'Genap' : 'Ganjil' }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Mata Kuliah</label>
              <select class="form-control" name="kode_makul" required>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach ($listMakul as $m)
                  <option value="{{ $m->kode_makul }}">
                    [{{ $m->kode_makul }}] - {{ $m->nama_makul }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Jurusan</label>
              <select class="form-control" name="kode_jurusan" required>
                <option value="">-- Pilih Jurusan --</option>
                @foreach ($listJurusan as $j)
                  <option value="{{ $j->kode_jurusan }}">
                    [{{ $j->kode_jurusan }}] - {{ $j->nama_jurusan }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Dosen Pengampu</label>
              <select class="form-control" name="nik" required>
                <option value="">-- Pilih Dosen --</option>
                @foreach ($listDosen as $d)
                  <option value="{{ $d->nik }}">
                    [{{ $d->nik }}] - {{ $d->nama }}
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

  <!-- MODAL EDIT -->
  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Periode Akademik</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form-edit" action="" method="post">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="kode_kelas" required>
              <label>Kelas</label>
              <input type="text" class="form-control" name="nama_kelas" placeholder="Masukkan nama kelas (Contoh: TI 2C)" required>
            </div>

            <div class="form-group">
              <label>Periode Akademik</label>
              <select class="form-control" name="kode_akd" required>
                <option value="">-- Pilih Periode --</option>
                @foreach ($listAkademikAktif as $akd)
                  <option value="{{ $akd->kode_akd }}">
                    [{{ $akd->kode_akd }}] - {{ $akd->tahun }} {{ $akd->semester == 'GN' ? 'Genap' : 'Ganjil' }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Mata Kuliah</label>
              <select class="form-control" name="kode_makul" required>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach ($listMakul as $m)
                  <option value="{{ $m->kode_makul }}">
                    [{{ $m->kode_makul }}] - {{ $m->nama_makul }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Jurusan</label>
              <select class="form-control" name="kode_jurusan" required>
                <option value="">-- Pilih Jurusan --</option>
                @foreach ($listJurusan as $j)
                  <option value="{{ $j->kode_jurusan }}">
                    [{{ $j->kode_jurusan }}] - {{ $j->nama_jurusan }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Dosen Pengampu</label>
              <select class="form-control" name="nik" required>
                <option value="">-- Pilih Dosen --</option>
                @foreach ($listDosen as $d)
                  <option value="{{ $d->nik }}">
                    [{{ $d->nik }}] - {{ $d->nama }}
                  </option>
                @endforeach
              </select>
            </div>

          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-warning">
              <i class="fas fa-pen"></i>
              Simpan Perubahan
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
  $('#modal-edit').on('show.bs.modal', function(e){
    var button = $(e.relatedTarget);
    var kode_kelas = button.data('kode_kelas');
    var kode_akd = button.data('kode_akd');
    var kode_makul = button.data('kode_makul');
    var kode_jurusan = button.data('kode_jurusan');
    var nik = button.data('nik');
    var nama_kelas = button.data('nama_kelas');

    var modal = $(this);
    modal.find('input[name="kode_kelas"]').val(kode_kelas);
    modal.find('select[name="kode_akd"]').val(kode_akd);
    modal.find('select[name="kode_makul"]').val(kode_makul);
    modal.find('select[name="kode_jurusan"]').val(kode_jurusan);
    modal.find('select[name="nik"]').val(nik);
    modal.find('input[name="nama_kelas"]').val(nama_kelas);

    var updateUrl = "{{ url('admin/kelas-makul') }}/" + encodeURIComponent(kode_kelas);
    modal.find('#form-edit').attr('action', updateUrl);
  });
</script>  
@endpush