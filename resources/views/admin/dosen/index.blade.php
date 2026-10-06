@extends('layouts.admin')

@section('content-header')
  <h1>Data Dosen</h1><hr>
@endsection

@section('content')
  <div class="card">
    <div class="card-body">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
        <i class="fas fa-plus"></i>
        Tambah Data
      </button>
      <a href="{{ route('admin.dosen.pdf') }}" class="btn btn-danger mb-2" target="_blank">
        <i class="fas fa-file-pdf"></i>
        Ekspor Data
      </a>
      <a href="{{ route('admin.dosen.export_excel') }}" class="btn btn-success mb-2" target="_blank">
        <i class="fas fa-file-excel"></i>
        Ekspor Data
      </a>
      <button class="btn btn-warning mb-2" data-toggle="modal" data-target="#modal-impor">
        <i class="fas fa-file-excel"></i>
        Impor Data
      </button>

      <table id="example1" class="table table-bordered table-striped text-center">
        <thead>
          <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Kontak</th>
            <th>Email</th>
            <th>Jenis Kelamin</th>
            <th>Foto</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        <tbody>
          @forelse ($dosen as $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->nik }}</td>
              <td class="text-left">{{ $d->nama }}</td>
              <td>{{ $d->kontak }}</td>
              <td class="text-left">{{ $d->email }}</td>
              <td class="text-left">
                @if ($d->kelamin == 'P')
                  Perempuan
                @else
                  Laki-laki
                @endif
              </td>
              <td>
                <button type="button" class="btn" data-toggle="modal" data-target="#modal-ubah-foto" data-nik="{{ $d->nik }}">
                @if ($d->kelamin == 'P')
                  <img src="{{ !empty($d->img) ? asset('storage/' . $d->img) : asset('asset_web/img/dosen-woman.jpg') }}" style="width: 60px; height: 60px; object-fit: cover;">
                @else
                  <img src="{{ !empty($d->img) ? asset('storage/' . $d->img) : asset('asset_web/img/dosen-man.jpg') }}" style="width: 60px; height: 60px; object-fit: cover;">
                @endif
                </button>
              </td>
              <td class="text-center">
                <div style="display: flex; gap: 5px; justify-content: center;">
                  <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit"
                    data-nik = "{{ $d->nik }}"
                    data-nama = "{{ $d->nama }}"
                    data-kontak = "{{ $d->kontak }}"
                    data-email = "{{ $d->email }}"
                    data-kelamin = "{{ $d->kelamin }}"
                  >
                    <i class="fas fa-pen"></i>
                  </button>

                  <form action="{{ route('admin.dosen.destroy', $d->nik) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Data dosen yang dipilih akan dihapus. Lanjutkan?')">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>          
          @empty
            <tr>
              <td colspan="6" class="text-center">Data dosen tidak ditemukan</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- MODAL TAMBAH -->
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Dosen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.dosen.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="">NIK</label>
              <input type="text" class="form-control" name="nik" placeholder="Masukkan NIK" required>
            </div>

            <div class="form-group">
              <label for="">Nama</label>
              <input type="text" class="form-control" name="nama" placeholder="Masukkan nama dosen" required>
            </div>

            <div class="form-group">
              <label for="">Kontak</label>
              <input type="number" class="form-control" name="kontak" placeholder="Masukkan nomor kontak" required>
            </div>

            <div class="form-group">
              <label for="">Email</label>
              <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
            </div>

            <div class="form-group">
              <label>Jenis Kelamin</label>
              <select class="form-control" name="kelamin" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="P">Perempuan</option>
                <option value="L">Laki-laki</option>
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
          <h4 class="modal-title">Edit Informasi Dosen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form-edit" method="post">
          @csrf
          @method('PUT')

          <div class="modal-body">
            <div class="form-group">
              <label for="">NIK</label>
              <input type="text" class="form-control" name="nik" readonly required>
            </div>

            <div class="form-group">
              <label for="">Nama</label>
              <input type="text" class="form-control" name="nama" required>
            </div>

            <div class="form-group">
              <label for="">Kontak</label>
              <input type="number" class="form-control" name="kontak" placeholder="Masukkan nomor kontak" required>
            </div>

            <div class="form-group">
              <label for="">Email</label>
              <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
            </div>

            <div class="form-group">
              <label>Jenis Kelamin</label>
              <select class="form-control" name="kelamin" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="P">Perempuan</option>
                <option value="L">Laki-laki</option>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_edit" class="btn btn-warning">
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

  <!-- MODAL UBAH FOTO -->
  <div class="modal fade" id="modal-ubah-foto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ubah Foto Dosen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form-ubah-foto" method="post" enctype="multipart/form-data">
          @csrf

          <div class="modal-body">
            <div class="form-group">
              NIK : 
              <input type="text" name="nik" readonly>
            </div>
            <div class="form-group">
              <label for="foto_dosen">Upload File</label>
              <input type="file" class="form-control" name="foto_dosen" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_ubah_foto" class="btn btn-success">
              Ubah Foto
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- MODAL IMPOR -->
  <div class="modal fade" id="modal-impor">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Impor Data Dosen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.dosen.import_excel') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="file">Upload File</label>
              <input type="file" class="form-control" name="file_excel" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_impor" class="btn btn-success">
              <!-- <i class="fas fa-plus"></i> -->
              Impor Data
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
@endsection

@push('scripts')
<script>
  $('#modal-edit').on('show.bs.modal', function(e){
    var button = $(e.relatedTarget);
    var nik = button.data('nik');
    var nama = button.data('nama');
    var kontak = button.data('kontak');
    var email = button.data('email');
    var kelamin = button.data('kelamin');

    var modal = $(this);
    modal.find('input[name="nik"]').val(nik);
    modal.find('input[name="nama"]').val(nama);
    modal.find('input[name="kontak"]').val(kontak);
    modal.find('input[name="email"]').val(email);
    modal.find('select[name="kelamin"]').val(kelamin);

    var updateUrl = "{{ url('admin/dosen') }}/" + encodeURIComponent(nik);
    modal.find('#form-edit').attr('action', updateUrl);
  });

  $('#modal-ubah-foto').on('show.bs.modal', function(e){
    var nik = $(e.relatedTarget).data('nik');

    var modal = $(this);
    modal.find('input[name="nik"]').val(nik);

    var updateUrl = "{{ url('admin/dosen/ubah-foto') }}/" + encodeURIComponent(nik);
    modal.find('#form-ubah-foto').attr('action', updateUrl);
  });
</script>  
@endpush