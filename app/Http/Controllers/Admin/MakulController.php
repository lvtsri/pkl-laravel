<?php

namespace App\Http\Controllers\Admin;

use App\Models\Makul;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MakulController extends Controller
{
    private function ensureAdmin()
    {
        if (session('peran') != 'A') {
            return redirect('/logout')->with('error', 'Anda bukan admin! Akan segera di logout-kan');
        }
        return null;
    }

    public function index()
    {
        if ($res = $this->ensureAdmin()) return $res;

        $makul = Makul::all();
        return view('admin.makul.index', compact('makul') + ['hal' => 'data_makul']);
    }

    // Tambah
    public function store(Request $request){
        $validated = $request->validate([
            'kode_makul' => 'required',
            'nama_makul' => 'required',
            'jml_sks' => 'required',
            'jml_cpmk' => 'required',
        ]);

        $exists = Makul::where('kode_makul', $request->kode_makul)->exists();

        if($exists){
            return redirect()->route('admin.makul')->with('error', 'Kode mata kuliah sudah terdaftar!');
        }

        Makul::create([
            'kode_makul' => trim($request->kode_makul),
            'nama_makul' => trim($request->nama_makul),
            'jml_sks' => trim($request->jml_sks),
            'jml_cpmk' => trim($request->jml_cpmk),
        ]);

        return redirect()->route('admin.makul')->with('success', 'Data mata kuliah telah berhasil ditambahkan!');
    }
    
    // Update
    public function update(Request $request, $kode_makul){
        $request->validate([
            'nama_makul' => 'required',
            'jml_sks' => 'required',
            'jml_cpmk' => 'required',
        ]);

        $makul = Makul::where('kode_makul', $kode_makul)->first();

        if (!$makul) {
            return redirect()->route('admin.makul')->with('error', 'Data mata kuliah tidak valid atau tidak ditemukan!');
        }

        $makul->update([
            'nama_makul' => trim($request->nama_makul),
            'jml_sks' => trim($request->jml_sks),
            'jml_cpmk' => trim($request->jml_cpmk),
        ]);

        return redirect()->route('admin.makul')->with('success', 'Data mata kuliah berhasil diubah!');
    }

    // Hapus
    public function destroy($kode_makul){
        $makul = Makul::where('kode_makul', $kode_makul)->first();

        if(!$makul){
            return redirect()->route('admin.makul')->with('error', 'Data periode akademik tidak valid atau tidak ditemukan!');
        }

        $nama_makul = $makul->nama_makul;

        try {
            $makul->delete();
            return redirect()->route('admin.makul')->with('success', "Mata kuliah {$nama_makul} telah berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect()->route('admin.makul')->with('error', "Gagal menghapus data makul");
        }
    }

    public function exportPdf(){
        $makul = Makul::all();

        $data = [
            'title' => 'Data Mata Kuliah',
            'makul' => $makul,
        ];

        $pdf = Pdf::loadView('admin.makul.pdf', $data);
        
        return $pdf->stream('data_jurusan.pdf');
    }
}
