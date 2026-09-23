<?php

namespace App\Http\Controllers\Admin;

use App\Models\Akademik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AkademikController extends Controller
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

        $akademik = Akademik::all();
        return view('admin.akademik.index', compact('akademik') + ['hal' => 'data_akademik']);
    }

    // Tambah
    public function store(Request $request){
        $validated = $request->validate([
            'kode_akd' => 'required|max:10',
            'semester' => 'required',
            'tahun' => 'required|max:4',
            'is_active' => 'required',
        ]);

        $exists = Akademik::where('kode_akd', $request->kode_akd)->exists();

        if ($exists) {
            return redirect()->route('admin.akademik')->with('error', 'Kode Akademik sudah Terdaftar!');
        }

        Akademik::create([
            'kode_akd' => trim($request->kode_akd),
            'semester' => trim($request->semester),
            'tahun' => trim($request->tahun),
            'is_active' => trim($request->is_active),
        ]);

        return redirect()->route('admin.akademik')->with('success', 'Data periode Akademik berhasil disimpan!');
    }

    // Update
    public function update(Request $request, $kode_akd){
        $request->validate([
            'semester'  => 'required',
            'tahun'     => 'required|max:4',
            'is_active' => 'required',
        ]);

        $akademik = Akademik::where('kode_akd', $kode_akd)->first();

        if (!$akademik) {
            return redirect()->route('admin.akademik')->with('error', 'Data periode akademik tidak valid atau tidak ditemukan!');
        }

        $akademik->update([
            'semester' => trim($request->semester),
            'tahun' => trim($request->tahun),
            'is_active' => trim($request->is_active),
        ]);

        return redirect()->route('admin.akademik')->with('success', 'Data periode akademik berhasil diubah!');
    }

    // Hapus
    public function destroy($kode_akd){
        $akademik = Akademik::where('kode_akd', $kode_akd)->first();

        if(!$akademik){
            return redirect()->route('admin.akademik')->with('error', 'Data periode akademik tidak valid atau tidak ditemukan!');
        }

        try {
            $akademik->delete();
            return redirect()->route('admin.akademik')->with('success', "Data periode akademik (Kode: {$kode_akd}) telah berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect()->route('admin.akademik')->with('error', "Gagal menghapus data periode akademik");
        }
    }
}
