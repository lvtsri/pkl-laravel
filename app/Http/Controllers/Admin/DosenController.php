<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class DosenController extends Controller
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

        $dosen = Dosen::all();
        return view('admin.dosen.index', compact('dosen') + ['hal' => 'data_dosen']);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'kelamin' => 'required',
        ]);

        $exists = Dosen::where('nik', $request->nik)->exists();

        if ($exists) {
            return redirect()->route('admin.dosen')->with('error', 'NIK sudah terdaftar!');
        }

        Dosen::create([
            'nik' => trim($request->nik),
            'nama' => trim($request->nama),
            'kontak' => trim($request->kontak),
            'email' => trim($request->email),
            'kelamin' => trim($request->kelamin),
        ]);

        Pengguna::create([
            'username' => trim($request->nik),
            'sandi' => sha1(trim($request->nik)),
            'peran' => 'D',
            'pin' => '654321',
            'nama' => trim($request->nama),
        ]);

        return redirect()->route('admin.dosen')->with('success', 'Data dosen telah berhasil ditammbahkan!');
    }

    public function update(Request $request, $nik){
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'kontak' => 'required',
            'email' => 'required',
            'kelamin' => 'required',
        ]);

        $dosen = Dosen::where('nik', $nik)->first();

        if (!$dosen) {
            return redirect()->route('admin.dosen')->with('error', 'Data dosen tidak valid!');
        }

        $dosen->update([
            'nama' => trim ($request->nama),
            'kontak' => trim ($request->kontak),
            'email' => trim ($request->email),
            'kelamin' => trim ($request->kelamin),
        ]);

        return redirect()->route('admin.dosen')->with('success', 'Data dosen telah berhasil diubah!');
    }

    public function destroy($nik){
        $dosen = Dosen::where('nik', $nik)->first();

        if (!$dosen) {
            return redirect()->route('admin.dosen')->with('error', 'Data dosen tidak valid!');
        }

        try {
            $dosen->delete();
            return redirect()->route('admin.dosen')->with('success', 'Data dosen telah dihapus!');
        } catch (\Throwable $th) {
            return redirect()->route('admin.dosen')->with('error', 'Gagal menghapus data dosen');
        }
    }
}
