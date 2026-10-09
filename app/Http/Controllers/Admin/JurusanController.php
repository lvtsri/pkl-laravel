<?php

namespace App\Http\Controllers\Admin;

use App\Exports\JurusanExport;
use App\Exports\Jurusan\JurusanTemplateExport;
use App\Models\Jurusan;
use App\Http\Controllers\Controller;
use App\Imports\JurusanImport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $data = Jurusan::query();
                return DataTables::of($data)->addIndexColumn()->addColumn('action', function($row){
                    $editUrl = url('admin/jurusan/' . $row->kode_jurusan);
                    $destroyUrl = route('admin.jurusan.destroy', $row->kode_jurusan);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                    <div style="display: flex; gap: 5px; justify-content: center;">
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit"
                            data-kode_jurusan="' . $row->kode_jurusan . '"
                            data-nama_jurusan="' . $row->nama_jurusan . '"
                        >
                            <i class="fas fa-pen"></i>
                        </button>
                        <form action="' . $destroyUrl . '" method="POST">
                            ' . $csrf . '
                            ' . $method . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Data jurusan yang dipilih akan dihapus. Lanjutkan?\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>';
                })
                ->rawColumns(['action']) //biar tag HTML di kolom action bisa dirender
                ->make(true);
        }
        return view('admin.jurusan.index', [
            'hal' => 'data_jurusan',
        ]);
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

    public function importExcel(Request $request){
        $request->validate([
            'file_excel' => 'required',
        ]);

        Excel::import(new JurusanImport, $request->file('file_excel'));
        
        return back()->with('success', 'Data jurusan telah berhasil diimpor');
    }

    public function downloadTemplate(){
        return Excel::download(new JurusanTemplateExport, 'template-jurusan.xlsx');
    }
}
