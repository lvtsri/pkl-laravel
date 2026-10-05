@extends('layouts.mahasiswa')

@section('content-header')
  <h1>Kelas Mata Kuliah</h1><hr>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Scan QR Code Presensi</h3>
            </div>
            <div class="card-body">
                <!-- Kotak Kamera Scanner Langsung di Card -->
                <div id="reader" style="width: 100%;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Informasi</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('mahasiswa.kelas_makul.scan') }}" method="POST" id="formScan" class="mt-3">
                    @csrf
                    <div class="form-group">
                        <label for="nim">NIM: </label>
                        <input type="text" name="nim" value="{{ session('username') }}" class="form-control" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="nim">Nama: </label>
                        <input type="text" name="nama" value="{{ session('nama') }}" class="form-control" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="id_pertemuan">Hasil QR: </label>
                        <input type="text" name="id_pertemuan" id="id_pertemuan" class="form-control" readonly required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="btn_simpan">Simpan Presensi</button>
                </form>
            </div>
        </div>
    </div>        
</div>        
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Handle on success condition with the decoded text or result.
        console.log("=== Berhasil^^ ===");
        console.log(`Hasil QR Code: ${decodedText}`, decodedResult);
        console.log("=========================");

        document.getElementById('id_pertemuan').value = decodedText;

        html5QrcodeScanner.clear();    
        // ^ this will stop the scanner (video feed) and clear the scan area.
    }
    
    function onScanError(errorMessage) {
        console.warn(`Scan error: ${errorMessage}`);
        // handle on error condition, with error message
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 250 });

    html5QrcodeScanner.render(onScanSuccess);
    
</script>
@endpush