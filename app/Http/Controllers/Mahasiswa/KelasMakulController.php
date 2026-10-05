<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pertemuan;
use App\Models\Presensi;

class KelasMakulController extends Controller
{
    public function index(){
        $user = Auth::user();

        return view('mahasiswa.kelas_makul.index', [
            'hal' => 'data_kelas_makul',
            'user' => $user,
        ]);
    }

    public function scan(Request $request){
        $id_pertemuan = $request->id_pertemuan;
        $nim = session('username');

        $pertemuan = Pertemuan::where('id', $id_pertemuan)->first();

        if (!$pertemuan) {
            return back()->with('error', 'Kode QR tidak valid!');
        }

        if ($pertemuan->status_pertemuan == 0) {
            return back()->with('error', 'Presensi telah ditutup!');
        } else {
            $presensi = Presensi::where('id_pertemuan', $id_pertemuan)->where('nim', $nim)->first();

            if (!$presensi) {
                return back()->with('error', 'Mahasiswa tidak terdaftar pada pertemuan ini');
            }

            if ($presensi->status_kehadiran === 'hadir') {
                return back()->with('error', 'Anda sudah melakukan presensi di pertemuan ini');
            }

            $presensi->update([
                'status_kehadiran' => 'hadir'
            ]);

            return back()->with('success', 'Anda (NIM: '. $nim .') telah berhasil melakukan presensi');
        }
    }
}
