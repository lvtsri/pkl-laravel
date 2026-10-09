@extends('layouts.admin')

@section('content-header')
  <h1>Data Jurusan</h1><hr>
@endsection

@section('content')
  <div class="card">
    <div class="card-body">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
        <i class="fas fa-plus"></i>
        Tambah Data
      </button>
      <a href="{{ route('admin.jurusan.pdf') }}" class="btn btn-danger mb-2" target="_blank">
        <i class="fas fa-file-pdf"></i>
        Ekspor Data
      </a>
      <a href="{{ route('admin.jurusan.export_excel') }}" class="btn btn-success mb-2" target="_blank">
        <i class="fas fa-file-excel"></i>
        Ekspor Data
      </a>
      </a>
      <button class="btn btn-warning mb-2" data-toggle="modal" data-target="#modal-impor">
        <i class="fas fa-file-excel"></i>
        Impor Data
      </button>

      <table id="jurusan-table" class="table table-bordered table-striped text-center">
        <thead>
          <tr class="text-center">
            <th width="5%">No</th>
            <th>Kode</th>
            <th>Nama Jurusan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          {{--  --}}
        </tbody>
      </table>
    </div>
  </div>

  <!-- MODAL TAMBAH -->
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Jurusan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.jurusan.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="kode_jurusan">Kode Jurusan</label>
              <input type="text" class="form-control" name="kode_jurusan" placeholder="Masukkan kode akademik" required>
            </div>

            <div class="form-group">
              <label for="nama_jurusan">Nama Jurusan</label>
              <input type="text" class="form-control" name="nama_jurusan" placeholder="Masukkan kode akademik" required>
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
          <h4 class="modal-title">Edit Data Jurusan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form-edit" action="" method="post">
          @csrf
          @method('PUT')

          <div class="modal-body">
            <div class="form-group">
              <label for="kode_jurusan">Kode Jurusan</label>
              <input type="text" class="form-control" name="kode_jurusan" readonly required>
            </div>

            <div class="form-group">
              <label for="nama_jurusan">Nama Jurusan</label>
              <input type="text" class="form-control" name="nama_jurusan" required>
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
  
  <!-- MODAL IMPOR -->
  <div class="modal fade" id="modal-impor">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Impor Data Jurusan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.jurusan.import_excel') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="file">Upload File</label>
              <input type="file" class="form-control" name="file_excel" required>
            </div>
            <div class="form-group">
              <label for="">Install Template Excel</label><br>
              <a href="{{ route('admin.jurusan.template') }}" class="btn btn-success mb-2">
                <i class="fas fa-file-download"></i>
                Jurusan.xlsx
              </a>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_impor" class="btn btn-success">
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
  $(function(){
    $('#jurusan-table').DataTable({
      processing: true,   //nampilin loading
      serverSide: true,   //pemrosesan data dilakuin di server/database, bukan di browser user
      ajax: "{{ route('admin.jurusan') }}",
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'kode_jurusan', name: 'kode_jurusan' },
        { data: 'nama_jurusan', name: 'nama_jurusan' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
      ]
    });
  });

  $('#modal-edit').on('show.bs.modal', function(e){
    var button = $(e.relatedTarget);
    var kode_jurusan = button.data('kode_jurusan');
    var nama_jurusan = button.data('nama_jurusan');

    var modal = $(this);
    modal.find('input[name="kode_jurusan"]').val(kode_jurusan);
    modal.find('input[name="nama_jurusan"]').val(nama_jurusan);

    var updateUrl = "{{ url('admin/jurusan') }}/" + encodeURIComponent(kode_jurusan);
    modal.find('#form-edit').attr('action', updateUrl);
  });
</script>  
@endpush