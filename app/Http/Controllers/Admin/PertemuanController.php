<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PertemuanExport;
use App\Http\Controllers\Controller;
use App\Models\KelasMakul;
use App\Models\Akademik;
use App\Models\DetailKelasMakul;
use App\Models\Makul;
use App\Models\Jurusan;
use App\Models\Dosen;
use App\Models\Pertemuan;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 
use Maatwebsite\Excel\Facades\Excel;

class PertemuanController extends Controller
{
    public function index($kode_kelas){
        $info = KelasMakul::with(['akademik', 'makul', 'jurusan', 'dosen'])->where('kode_kelas', $kode_kelas)->first();
        
        $pertemuan = Pertemuan::where('kode_kelas', $kode_kelas)->get();

        return view('admin.kelas_makul.pertemuan', [
            'hal' => 'data_kelas_makul',
            'info' => $info,
            'pertemuan' => $pertemuan,
        ]);
    }

    public function store(Request $request, $kode_kelas){
        $validated = $request->validate([
            'judul_pertemuan' => 'required',
            'tanggal' => 'required',
        ]);

        $pertemuan_terakhir = Pertemuan::where('kode_kelas', $kode_kelas)->max('pertemuan_ke') ?? 0;
        $pertemuan_ke = $pertemuan_terakhir + 1;

        $pertemuan = Pertemuan::create([
            'kode_kelas' => $kode_kelas,
            'tanggal' => trim($request->tanggal),
            'judul_pertemuan' => trim($request->judul_pertemuan),
            'status_pertemuan' => '1',
            'pertemuan_ke' => $pertemuan_ke,
        ]);

        $query_mhs = DetailKelasMakul::where('kode_kelas', $kode_kelas)->get();

        foreach ($query_mhs as $mhs) {
            Presensi::create([
                'id_pertemuan' => $pertemuan->id,
                'nim' => $mhs->nim,
                'status_kehadiran' => 'alpha',
            ]);
        }

        // return redirect()->back()->with('success', 'Pertemuan telah berhasil ditambahkan!');
        return redirect()->route('admin.kelas_makul.presensi', ['id_pertemuan' => $pertemuan->id])->with('success', 'Data pertemuan telah berhasil ditambahkan!');
    }

    public function update(Request $request){
        $request->validate([
            'id' => 'required',
            'judul_pertemuan' => 'required',
            'tanggal' => 'required',
        ]);

        $pertemuan = Pertemuan::where('id', $request->id)->first();

        if (!$pertemuan) {
            return redirect()->back()->with('error', 'Data pertemuan tidak valid atau tidak ditemukan!');
        }

        $pertemuan->update([
            'judul_pertemuan' => trim($request->judul_pertemuan),
        ]);

        return redirect()->back()->with('success', 'Data pertemuan telah berhasil diubah!');
    }

    public function destroy($id){
        $pertemuan = Pertemuan::where('id', $id)->first();

        if (!$pertemuan) {
            return redirect()->back()->with('error', 'Data pertemuan tidak valid!');
        }

        try {
            $pertemuan->delete();
            return redirect()->back()->with('success', 'Pertemuan telah dihapus!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus pertemuan');
        }
    }

    // PDF
    public function exportPdf($kode_kelas){
        $pertemuan = Pertemuan::where('kode_kelas', $kode_kelas)->get();

        $data = [
            'title' => 'Data Pertemuan',
            'pertemuan' => $pertemuan,
        ];

        $pdf = Pdf::loadView('admin.kelas_makul.pdf_pertemuan', $data);

        return $pdf->stream('data_pertemuan.pdf');
    }

    // EXCEL
    public function exportExcel($kode_kelas){
        return Excel::download(new PertemuanExport($kode_kelas), 'Data_Pertemuan.xlsx');
    }
}
