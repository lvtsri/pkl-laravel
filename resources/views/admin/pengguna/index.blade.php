@extends('layouts.admin')

@section('content-header')
  <h1>Data Pengguna</h1><hr>
@endsection

@section('content')
  <div class="card">
    <div class="card-body">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
        <i class="fas fa-plus"></i> 
        Tambah Data
      </button>

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th width="5%">No</th>
            <th>Username</th>
            <th>Nama Pengguna</th>
            <th>Peran</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <?php
          $no = 1;
        ?>
        <tbody>
          @forelse ($pengguna as $item)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $item->username }}</td>
              <td>{{ $item->nama }}</td>
              <td>
                @if ($item->peran == 'M')
                    Mahasiswa
                @elseif ($item->peran == 'D')
                    Dosen
                @else
                    Admin
                @endif
              </td>
              <td class="text-center">
                <div style="display: flex; gap: 5px; justify-content: center;">
                  <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit"
                    data-username="{{ $item->username }}"
                    data-nama="{{ $item->nama }}"
                    data-peran="{{ $item->peran }}"
                  >
                    <i class="fas fa-pen"></i>
                  </button>

                  <form action="{{ route('admin.pengguna.destroy', $item->username) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Data pengguna yang dipilih akan dihapus. Lanjutkan?')">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">Data pengguna tidak ditemukan</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>

  <!-- MODAL TAMBAH -->
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambahkan Pengguna</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.pengguna.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="">Username</label>
              <input type="text" class="form-control" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
              <label for="">Nama Pengguna</label>
              <input type="text" class="form-control" name="nama" placeholder="Masukkan nama pengguna" required>
            </div>

            <div class="form-group">
              <label>Peran</label>
              <select class="form-control" name="peran" required>
                <option value="">-- Pilih Peran --</option>
                <option value="A">Admin</option>
                <option value="D">Dosen</option>
                <option value="M">Mahasiswa</option>
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
          <h4 class="modal-title">Edit Informasi Pengguna</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form-edit" method="post">
          @csrf
          @method('PUT')

          <div class="modal-body">
            <div class="form-group">
              <label for="">Username</label>
              <input type="text" class="form-control" name="username" readonly required>
            </div>

            <div class="form-group">
              <label for="">Nama Pengguna</label>
              <input type="text" class="form-control" name="nama" required>
            </div>

            <div class="form-group">
              <label>Peran</label>
              <select class="form-control" name="peran" required>
                <option value="">-- Pilih Peran --</option>
                <option value="A">Admin</option>
                <option value="D">Dosen</option>
                <option value="M">Mahasiswa</option>
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
    var username = button.data('username');
    var nama = button.data('nama');
    var peran = button.data('peran');

    var modal = $(this);
    modal.find('input[name="username"]').val(username);
    modal.find('input[name="nama"]').val(nama);
    modal.find('select[name="peran"]').val(peran);

    var updateUrl = "{{ url('admin/pengguna') }}/" + encodeURIComponent(username);
    modal.find('#form-edit').attr('action', updateUrl);
  });
</script>  
@endpush