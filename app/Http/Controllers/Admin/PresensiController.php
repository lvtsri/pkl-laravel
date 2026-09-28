<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasMakul;
use App\Models\Presensi;
use App\Models\Pertemuan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    private function ensureAdmin()
    {
        if (session('peran') != 'A') {
            return redirect('/logout')->with('error', 'Anda bukan admin! Akan segera di logout-kan');
        }
        return null;
    }

    public function index($id_pertemuan){
        if ($res = $this->ensureAdmin()) return $res;
        
        $pertemuan = Pertemuan::where('id', $id_pertemuan)->first();
        $kode_kelas = $pertemuan->kode_kelas;

        $info = KelasMakul::with(['dosen', 'jurusan', 'makul'])->where('kode_kelas', $kode_kelas)->first();

        $presensi = Presensi::with('mahasiswa')->where('id_pertemuan', $id_pertemuan)->get();
        $status_pertemuan = Pertemuan::where('id', $id_pertemuan)->value('status_pertemuan');
        
        return view('admin.kelas_makul.presensi', [
            'hal' => 'data_kelas_makul',
            'status_pertemuan' => $status_pertemuan,
            'presensi' => $presensi,
            'id_pertemuan' => $id_pertemuan,
            'info' => $info,
            'pertemuan' => $pertemuan,
        ]);
    }

    public function toggleStatus($id)
    {
        $pertemuan = Pertemuan::findOrFail($id);

        $pertemuan->status_pertemuan = ($pertemuan->status_pertemuan == '0') ? '1' : '0';
        $pertemuan->save();

        return redirect()->back()->with('success', 'Status pertemuan berhasil diubah!');
    }

    public function ubahKehadiran(Request $request, $id){
        $request->validate([
            'status_kehadiran' => 'required',
        ]);

        $presensi = Presensi::findOrFail($id);

        $presensi->update([
            'status_kehadiran' => trim($request->status_kehadiran),
        ]);

        return redirect()->back()->with('success', 'Status kehadiran mahasiswa berhasil diperbarui!');
    }
}
