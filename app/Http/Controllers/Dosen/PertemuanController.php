<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasMakul;
use App\Models\Pertemuan;
use App\Models\DetailKelasMakul;
use App\Models\Presensi;

class PertemuanController extends Controller
{
    public function index($kode_kelas){
        $info = KelasMakul::with(['akademik', 'makul', 'jurusan', 'dosen'])->where('kode_kelas', $kode_kelas)->first();
        
        $pertemuan = Pertemuan::where('kode_kelas', $kode_kelas)->get();

        return view('dosen.kelas_makul.pertemuan', [
            'hal' => 'data_kelas_makul',
            'info' => $info,
            'pertemuan' => $pertemuan,
        ]);
    }

    public function store(Request $request, $kode_kelas){
        $validated = $request->validate([
            'judul_pertemuan' => 'required',
            'tanggal' => 'required',
        ]);

        $pertemuan_terakhir = Pertemuan::where('kode_kelas', $kode_kelas)->max('pertemuan_ke') ?? 0;
        $pertemuan_ke = $pertemuan_terakhir + 1;

        $pertemuan = Pertemuan::create([
            'kode_kelas' => $kode_kelas,
            'tanggal' => trim($request->tanggal),
            'judul_pertemuan' => trim($request->judul_pertemuan),
            'status_pertemuan' => '1',
            'pertemuan_ke' => $pertemuan_ke,
        ]);

        $query_mhs = DetailKelasMakul::where('kode_kelas', $kode_kelas)->get();

        foreach ($query_mhs as $mhs) {
            Presensi::create([
                'id_pertemuan' => $pertemuan->id,
                'nim' => $mhs->nim,
                'status_kehadiran' => 'alpha',
            ]);
        }

        // return redirect()->back()->with('success', 'Pertemuan telah berhasil ditambahkan!');
        return redirect()->route('dosen.kelas_makul.presensi', ['id_pertemuan' => $pertemuan->id])->with('success', 'Data pertemuan telah berhasil ditambahkan!');
    }
}
