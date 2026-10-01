<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasMakul;
use App\Models\Akademik;
use App\Models\DetailKelasMakul;
use App\Models\Makul;
use App\Models\Jurusan;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DetailKelasController extends Controller
{
    private function ensureAdmin()
    {
        if (session('peran') != 'A') {
            return redirect('/logout')->with('error', 'Anda bukan admin! Akan segera di logout-kan');
        }
        return null;
    }

    public function index($kode_kelas){
        if ($res = $this->ensureAdmin()) return $res;
        
        $info = KelasMakul::with(['akademik', 'makul', 'jurusan', 'dosen'])->where('kode_kelas', $kode_kelas)->first();

        $detail_kelas = DetailKelasMakul::with(['mahasiswa'])->where('kode_kelas', $kode_kelas)->get();

        $list_mhs = Mahasiswa::all();

        return view('admin.detail_kelas.index', [
            'hal' => 'data_kelas_makul',
            'info' => $info,
            'detail_kelas' => $detail_kelas,
            'list_mhs' => $list_mhs,
        ]);
    }

    public function store(Request $request, $kode_kelas){
        $validated = $request->validate([
            'nim' => 'required',
        ]);

        DetailKelasMakul::create([
            'kode_kelas' => $kode_kelas,
            'nim' => trim($request->nim),
        ]);

        return redirect()->back()->with('success', 'Mahasiswa telah berhasil ditambahkan ke detail kelas!');
    }

    public function destroy($id){
        $mahasiswa = DetailKelasMakul::where('id', $id)->first();

        if (!$mahasiswa) {
        return redirect()->back()->with('error', 'Data mahasiswa tidak valid!');
        }

        try {
            $mahasiswa->delete();
            return redirect()->back()->with('success', 'Data mahasiswa telah berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus data mahasiswa');
        }
    }
}
