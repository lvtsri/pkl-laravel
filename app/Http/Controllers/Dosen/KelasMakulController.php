<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Akademik;
use App\Models\KelasMakul;
use App\Models\Makul;
use App\Models\Jurusan;
use App\Models\Dosen;

class KelasMakulController extends Controller
{
    public function index(Request $request){
        $listAkademik = Akademik::all();
        $selectedPeriode = $request->input('semester', '');

        $query = KelasMakul::with(['akademik', 'makul', 'jurusan', 'dosen'])->where('nik', session('username'));

        if (!empty($selectedPeriode)) {
            $query->where('kode_akd', $selectedPeriode)->where('nik', session('username'));
        }

        $kelas_mk = $query->get();

        return view('dosen.kelas_makul.index', [
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
}
