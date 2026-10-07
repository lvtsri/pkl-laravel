<?php

namespace App\Http\Controllers\Admin;

use App\Exports\JurusanExport;
use App\Models\Jurusan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('admin.jurusan.index', compact('jurusan') + ['hal' => 'data_jurusan']);
    }

    // Tambah
    public function store(Request $request){
        $validated = $request->validate([
            'kode_jurusan' => 'required',
            'nama_jurusan' => 'required',
        ]);

        $exists = Jurusan::where('kode_jurusan', $request->kode_jurusan)->exists();

        if($exists){
            return redirect()->route('admin.jurusan')->with('error', 'Kode jurusan sudah terdaftar!');
        }

        Jurusan::create([
            'kode_jurusan' => trim($request->kode_jurusan),
            'nama_jurusan' => trim($request->nama_jurusan),
        ]);

        return redirect()->route('admin.jurusan')->with('success', 'Data jurusan telah berhasil ditambahkan!');
    }

    // Update
    public function update(Request $request, $kode_jurusan){
        $request->validate([
            'nama_jurusan' => 'required',
        ]);

        $jurusan = Jurusan::where('kode_jurusan', $kode_jurusan)->first();

        if (!$jurusan) {
            return redirect()->route('admin.jurusan')->with('error', 'Data jurusan tidak valid atau tidak ditemukan!');
        }

        $jurusan->update([
            'nama_jurusan' => trim($request->nama_jurusan),
        ]);

        return redirect()->route('admin.jurusan')->with('success', 'Data jurusan berhasil diubah!');
    }

    // Hapus
    public function destroy($kode_jurusan){
        $jurusan = Jurusan::where('kode_jurusan', $kode_jurusan)->first();

        if(!$jurusan){
            return redirect()->route('admin.jurusan')->with('error', 'Data jurusan tidak valid atau tidak ditemukan!');
        }

        try {
            $jurusan->delete();
            return redirect()->route('admin.jurusan')->with('success', 'Data jurusan telah dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.jurusan')->with('error', 'Gagal menghapus data jurusan');
        }
    }

    // PDF
    public function exportPdf(){
        $jurusan = Jurusan::all();

        $data = [
            'title' => 'Data Jurusan',
            'jurusan' => $jurusan,
        ];

        $pdf = Pdf::loadView('admin.jurusan.pdf', $data);

        return $pdf->stream('data_jurusan.pdf');
    }

    // EXCEL
    public function exportExcel(){
        return Excel::download(new JurusanExport, 'Data_Jurusan.xlsx');
    }
}
