<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KelasMakulExport;
use App\Models\KelasMakul;
use App\Models\Akademik;
use App\Models\Makul;
use App\Models\Jurusan;
use App\Models\Dosen;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class KelasMakulController extends Controller
{
    public function index(Request $request)
    {
        $listAkademik = Akademik::all();
        $selectedPeriode = $request->input('semester', '');

        $query = KelasMakul::with(['akademik', 'makul', 'jurusan', 'dosen']);

        if (!empty($selectedPeriode)) {
            $query->where('kode_akd', $selectedPeriode);
        }

        $kelas_mk = $query->get();

        return view('admin.kelas_makul.index', [
            'hal' => 'data_kelas_makul',
            'kelas_mk' => $kelas_mk,
            'listAkademik' => $listAkademik,
            'selected_periode' => $selectedPeriode,
            'listAkademikAktif' => Akademik::where('is_active', '1')->get(),
            'listMakul' => Makul::all(),
            'listJurusan' => Jurusan::all(),
            'listDosen' => Dosen::all(),
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'kode_akd' => 'required',
            'kode_makul' => 'required',
            'kode_jurusan' => 'required',
            'nik' => 'required',
            'nama_kelas' => 'required',
        ]);

        KelasMakul::create([
            'kode_akd' => trim($request->kode_akd),
            'kode_makul' => trim($request->kode_makul),
            'kode_jurusan' => trim($request->kode_jurusan),
            'nik' => trim($request->nik),
            'nama_kelas' => trim($request->nama_kelas),
        ]);

        return redirect()->route('admin.kelas_makul')->with('success', 'Data kelas mata kuliah telah berhasil ditambahkan!');
    }

    public function update(Request $request, $kode_kelas){
        $request->validate([
            'kode_kelas' => 'required',
            'kode_akd' => 'required',
            'kode_makul' => 'required',
            'kode_jurusan' => 'required',
            'nik' => 'required',
            'nama_kelas' => 'required',
        ]);

        $kelas = KelasMakul::where('kode_kelas', $kode_kelas)->first();

        if (!$kelas) {
            return redirect()->route('admin.kelas')->with('error', 'Data kelas tidak valid atau tidak ditemukan!');
        }

        $kelas->update([
            'kode_akd' => trim($request->kode_akd),
            'kode_makul' => trim($request->kode_makul),
            'kode_jurusan' => trim($request->kode_jurusan),
            'nik' => trim($request->nik),
            'nama_kelas' => trim($request->nama_kelas),
        ]);

        return redirect()->route('admin.kelas_makul')->with('success', 'Data kelas telah berhasil diubah!');
    }

    public function destroy($kode_kelas){
        $kelas_makul = KelasMakul::where('kode_kelas', $kode_kelas)->first();

        if (!$kelas_makul) {
            return redirect()->route('admin.kelas_makul')->with('error', 'Data kelas tidak valid!');
        }

        try {
            $kelas_makul->delete();
            return redirect()->route('admin.kelas_makul')->with('success', 'Data kelas mata kuliah telah dihapus!');
        } catch (\Throwable $th) {
            return redirect()->route('admin.kelas_makul')->with('error', 'Gagal menghapus kelas');
        }
    }

    // PDF
    public function exportPdf(){
        $kelas_mk = KelasMakul::with(['akademik', 'makul', 'jurusan', 'dosen'])->get();

        $data = [
            'title' => 'Data Seluruh Kelas Makul',
            'kelas_mk' => $kelas_mk,
        ];

        $pdf = Pdf::loadView('admin.kelas_makul.pdf', $data);
        
        return $pdf->stream('data_kelas_makul.pdf');
    }

    // EXCEL
    public function exportExcel(){
        return Excel::download(new KelasMakulExport, 'Data_Kelas_Makul.xlsx');
    }
}