@extends('layouts.admin')

@section('content-header')
  <h1>Data Mahasiswa</h1><hr>
@endsection

@section('content')
  <div class="card">
    <div class="card-body">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
        <i class="fas fa-plus"></i>
        Tambah Data
      </button>

      <table id="example1" class="table table-bordered table-striped text-center">
        <thead>
          <tr>
            <th>No</th>
            <th>NIM</th>
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
          @forelse ($mahasiswa as $m)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $m->nim }}</td>
              <td class="text-left">{{ $m->nama }}</td>
              <td>{{ $m->kontak }}</td>
              <td class="text-left">{{ $m->email }}</td>
              <td class="text-left">
                @if ($m->kelamin == 'P')
                  Perempuan
                @else
                  Laki-laki
                @endif
              </td>
              <td>
                @if ($m->kelamin == 'P')
                  <img src="{{ !empty($img) ? $img : asset('asset_web/img/mhs-woman.jpg') }}" style="width: 60px; height: 60px; object-fit: cover;">
                @else
                  <img src="{{ !empty($img) ? $img : asset('asset_web/img/mhs-man.jpg') }}" style="width: 60px; height: 60px; object-fit: cover;">
                @endif
              </td>
              <td class="text-center">
                <div style="display: flex; gap: 5px; justify-content: center;">
                  <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit"
                    data-nim = "{{ $m->nim }}"
                    data-nama = "{{ $m->nama }}"
                    data-kontak = "{{ $m->kontak }}"
                    data-email = "{{ $m->email }}"
                    data-kelamin = "{{ $m->kelamin }}"
                  >
                    <i class="fas fa-pen"></i>
                  </button>

                  <form action="{{ route('admin.mahasiswa.destroy', $m->nim) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Data mahasiswa yang dipilih akan dihapus. Lanjutkan?')">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center">Data mahasiswa tidak ditemukan</td>
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
          <h4 class="modal-title">Tambah Data Mahasiswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.mahasiswa.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="">NIM</label>
              <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM" required>
            </div>

            <div class="form-group">
              <label for="">Nama</label>
              <input type="text" class="form-control" name="nama" placeholder="Masukkan nama mahasiswa" required>
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
          <h4 class="modal-title">Edit Informasi Mahasiswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form-edit" method="post">
          @csrf
          @method('PUT')

          <div class="modal-body">
            <div class="form-group">
              <label for="">NIM</label>
              <input type="text" class="form-control" name="nim" readonly required>
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
@endsection

@push('scripts')
<script>
  $('#modal-edit').on('show.bs.modal', function(e){
    var button = $(e.relatedTarget);
    var nim = button.data('nim');
    var nama = button.data('nama');
    var kontak = button.data('kontak');
    var email = button.data('email');
    var kelamin = button.data('kelamin');

    var modal = $(this);
    modal.find('input[name="nim"]').val(nim);
    modal.find('input[name="nama"]').val(nama);
    modal.find('input[name="kontak"]').val(kontak);
    modal.find('input[name="email"]').val(email);
    modal.find('select[name="kelamin"]').val(kelamin);

    var updateUrl = "{{ url('admin/mahasiswa') }}/" + encodeURIComponent(nim);
    modal.find('#form-edit').attr('action', updateUrl);
  });
</script>  
@endpush