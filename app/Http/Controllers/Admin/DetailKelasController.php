<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasMakul;
use App\Models\Akademik;
use App\Models\DetailKelasMakul;
use App\Models\Makul;
use App\Models\Jurusan;
use App\Models\Dosen;
use Illuminate\Http\Request;

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
        
        $presensi = DetailKelasMakul::where('kode_kelas', $kode_kelas)->get();

        return view('admin.kelas_makul.presensi', [
            'hal' => 'data_kelas_makul',
            'info' => $info,
            'presensi' => $presensi,
        ]);
    }
}
