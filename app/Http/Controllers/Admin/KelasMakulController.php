<?php

namespace App\Http\Controllers\Admin;

use App\Models\KelasMakul;
use App\Models\Akademik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KelasMakulController extends Controller
{
    private function ensureAdmin()
    {
        if (session('peran') != 'A') {
            return redirect('/logout')->with('error', 'Anda bukan admin! Akan segera di logout-kan');
        }
        return null;
    }

    public function index(Request $request)
    {
        if ($res = $this->ensureAdmin()) return $res;

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
        ]);
    }
}
