@extends('layouts.admin')

@section('content-header')
  <h1>Data Mata Kuliah</h1><hr>
@endsection

@section('content')
  <div class="card">
    <div class="card-body">
      <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah">
        <i class="fas fa-plus"></i>
        Tambah Data
      </button>
      <a href="{{ route('admin.makul.pdf') }}" class="btn btn-danger mb-2" target="_blank">
        <i class="fas fa-file-pdf"></i>
        Ekspor Data
      </a>

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th width="5%">No</th>
            <th>Kode</th>
            <th>Nama Mata Kuliah</th>
            <th>Jumlah SKS</th>
            <th>Jumlah CPMK</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <?php
        $no = 1;
        ?>
        <tbody>
          @forelse ($makul as $m)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $m->kode_makul }}</td>
              <td>{{ $m->nama_makul }}</td>
              <td class="text-center">{{ $m->jml_sks }}</td>
              <td class="text-center">{{ $m->jml_cpmk }}</td>
              <td class="text-center">
                <div style="display: flex; gap: 5px; justify-content: center;">
                  <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit"
                    data-kode_makul = "{{ $m->kode_makul }}"
                    data-nama_makul = "{{ $m->nama_makul }}"
                    data-jml_sks = "{{ $m->jml_sks }}"
                    data-jml_cpmk = "{{ $m->jml_cpmk }}"
                  >
                    <i class="fas fa-pen"></i>
                  </button>

                  <form action="{{ route('admin.makul.destroy', $m->kode_makul) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Data mata kuliah yang dipilih akan dihapus. Lanjutkan?')">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center">Data mata kuliah tidak ditemukan</td>
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
          <h4 class="modal-title">Tambah Data Mata Kuliah</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.makul.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="kode_makul">Kode Mata Kuliah</label>
              <input type="text" class="form-control" name="kode_makul" placeholder="Masukkan kode mata kuliah" required>
            </div>
            
            <div class="form-group">
              <label for="nama_makul">Nama Mata Kuliah</label>
              <input type="text" class="form-control" name="nama_makul" placeholder="Masukkan nama mata kuliah" required>
            </div>

            <div class="form-group">
              <label for="">Jumlah SKS</label>
              <input type="number" class="form-control" name="jml_sks" placeholder="Masukkan jumlah sks" required>
            </div>

            <div class="form-group">
              <label for="">Jumlah CPMK</label>
              <input type="number" class="form-control" name="jml_cpmk" placeholder="Masukkan jumlah cpmk" required>
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
          <h4 class="modal-title">Edit Data Mata Kuliah</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form-edit" action="" method="post">
          @csrf
          @method('PUT')

          <div class="modal-body">
            <div class="form-group">
              <label for="kode_makul">Kode Mata Kuliah</label>
              <input type="text" class="form-control" name="kode_makul" readonly>
            </div>
            
            <div class="form-group">
              <label for="nama_makul">Nama Mata Kuliah</label>
              <input type="text" class="form-control" name="nama_makul" required>
            </div>

            <div class="form-group">
              <label for="">Jumlah SKS</label>
              <input type="number" class="form-control" name="jml_sks" required>
            </div>

            <div class="form-group">
              <label for="">Jumlah CPMK</label>
              <input type="number" class="form-control" name="jml_cpmk" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_edit" class="btn btn-primary">
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
    var kode_makul = button.data('kode_makul');
    var nama_makul = button.data('nama_makul');
    var jml_sks = button.data('jml_sks');
    var jml_cpmk = button.data('jml_cpmk');

    var modal = $(this);
    modal.find('input[name="kode_makul"]').val(kode_makul);
    modal.find('input[name="nama_makul"]').val(nama_makul);
    modal.find('input[name="jml_sks"]').val(jml_sks);
    modal.find('input[name="jml_cpmk"]').val(jml_cpmk);

    var updateUrl = "{{ url('admin/makul') }}/" + encodeURIComponent(kode_makul);
    modal.find('#form-edit').attr('action', updateUrl);
  });
</script>  
@endpush