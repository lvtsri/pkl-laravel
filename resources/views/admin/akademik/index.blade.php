@extends('layouts.admin')

@section('content-header')
  <h1>Data Periode Akademik</h1><hr>
@endsection

@section('content')
  <div class="card">
    <div class="card-body">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
        <i class="fas fa-plus"></i>
        Tambah Data
      </button>
      <a href="{{ route('admin.akademik.pdf') }}" class="btn btn-danger mb-2" target="_blank">
        <i class="fas fa-file-pdf"></i>
        Ekspor Data
      </a>
      <a href="{{ route('admin.akademik.export_excel') }}" class="btn btn-success mb-2" target="_blank">
        <i class="fas fa-file-excel"></i>
        Ekspor Data
      </a>

      <table id="example1" class="table table-bordered table-striped text-center">
        <thead>
          <tr class="text-center">
            <th width="5%">No</th>
            <th width="15%">Kode Akademik</th>
            <th>Semester</th>
            <th>Tahun</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        <tbody>
          @forelse ($akademik as $a)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $a->kode_akd }}</td>
              <td>
                @if ($a->semester == 'GL')
                  Ganjil
                @else
                  Genap
                @endif
              </td>
              <td>{{ $a->tahun }}</td>
              <td>
                @if ($a->is_active == '1')
                  Aktif
                @else
                  Tidak Aktif
                @endif
              </td>
              <td>
                <div style="display: flex; gap: 3px; justify-content: center;">
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit"
                    data-kode_akd = "{{ $a->kode_akd }}"
                    data-semester = "{{ $a->semester }}"
                    data-tahun = "{{ $a->tahun }}"
                    data-is_active = "{{ $a->is_active }}"
                  >
                    <i class="fas fa-pen"></i>
                  </button>
                  <form action="{{ route('admin.akademik.destroy', $a->kode_akd) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Data periode yang dipilih akan dihapus. Lanjutkan?')">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center">Data periode akademik tidak ditemukan</td>
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
          <h4 class="modal-title">Tambah Periode Akademik</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.akademik.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="kode_akd">Kode Akademik</label>
              <input type="text" class="form-control" name="kode_akd" placeholder="Masukkan kode akademik" required>
            </div>

            <div class="form-group">
              <label>Semester</label>
              <select class="form-control" name="semester" required>
                <option value="">-- Pilih Semester --</option>
                <option value="GL">Ganjil</option>
                <option value="GN">Genap</option>
              </select>
            </div>

            <div class="form-group">
              <label for="tahun">Tahun</label>
              <input type="number" class="form-control" name="tahun" placeholder="Masukkan tahun" required>
            </div>

            <div class="form-group">
              <label>Status Aktif</label>
              <select class="form-control" name="is_active" required>
                <option value="">-- Pilih Status Aktif --</option>
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
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
          <h4 class="modal-title">Edit Data Periode Akademik</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form-edit" action="" method="post">
          @csrf
          @method('PUT')

          <div class="modal-body">
            <div class="form-group">
              <label for="kode_akd">Kode Akademik</label>
              <input type="text" class="form-control" name="kode_akd" readonly>
            </div>

            <div class="form-group">
              <label>Semester</label>
              <select class="form-control" name="semester" required>
                <option value="">-- Pilih Semester --</option>
                <option value="GL">Ganjil</option>
                <option value="GN">Genap</option>
              </select>
            </div>

            <div class="form-group">
              <label for="tahun">Tahun</label>
              <input type="number" class="form-control" name="tahun" required maxlength="4">
            </div>

            <div class="form-group">
              <label>Status Aktif</label>
              <select class="form-control" name="is_active" required>
                <option value="">-- Pilih Status Aktif --</option>
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
            </div>

          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_edit" class="btn btn-primary">
              <i class="fas fa-plus"></i>
              Simpan Perubahan
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
    var kode_akd = button.data('kode_akd');
    var semester = button.data('semester');
    var tahun = button.data('tahun');
    var is_active = button.data('is_active');

    var modal = $(this);
    modal.find('input[name="kode_akd"]').val(kode_akd);
    modal.find('select[name="semester"]').val(semester);
    modal.find('input[name="tahun"]').val(tahun);
    modal.find('select[name="is_active"]').val(is_active);

    var updateUrl = "{{ url('admin/akademik') }}/" + encodeURIComponent(kode_akd);
    modal.find('#form-edit').attr('action', updateUrl);
  });
</script>  
@endpush