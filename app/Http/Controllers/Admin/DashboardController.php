<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\KelasMakul;

class DashboardController extends Controller
{
    public function index()
    {
        $total_dosen = Dosen::count();
        $total_mhs = Mahasiswa::count();
        $total_kls_mk = KelasMakul::count();

        $kelas_mk = KelasMakul::with(['akademik', 'makul', 'jurusan', 'dosen'])->get();
        $dosen_terbaru = Dosen::orderBy('nik', 'desc')->take(5)->get();

        return view('admin.index', [
            'hal' => 'beranda',
            'total_dosen' => $total_dosen,
            'total_mhs' => $total_mhs,
            'total_kls_mk' => $total_kls_mk,
            'kelas_mk' => $kelas_mk,
            'dosen_terbaru' => $dosen_terbaru,
        ]);
    }    
}