<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasMakul;
use App\Models\DetailKelasMakul;
use App\Models\Mahasiswa;

class DetailKelasController extends Controller
{
    public function index($kode_kelas){
        $info = KelasMakul::with(['akademik', 'makul', 'jurusan', 'dosen'])->where('kode_kelas', $kode_kelas)->first();

        $detail_kelas = DetailKelasMakul::with(['mahasiswa'])->where('kode_kelas', $kode_kelas)->get();

        $list_mhs = Mahasiswa::all();

        return view('dosen.detail_kelas.index', [
            'hal' => 'data_kelas_makul',
            'info' => $info,
            'detail_kelas' => $detail_kelas,
            'list_mhs' => $list_mhs,
        ]);
    }
}
