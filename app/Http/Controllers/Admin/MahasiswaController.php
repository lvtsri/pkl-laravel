<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    private function ensureAdmin()
    {
        if (session('peran') != 'A') {
            return redirect('/logout')->with('error', 'Anda bukan admin! Akan segera di logout-kan');
        }
        return null;
    }

    public function index() {
        if ($res = $this->ensureAdmin()) return $res;

        $mahasiswa = Mahasiswa::all();
        return view('admin.mahasiswa.index', compact('mahasiswa') + ['hal' => 'data_mahasiswa']);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kelamin' => 'required',
        ]);

        $exists = Mahasiswa::where('nim', $request->nim)->exists();

        if ($exists) {
            return redirect()->route('admin.mahasiswa')->with('error', 'nim sudah terdaftar!');
        }

        Mahasiswa::create([
            'nim' => trim($request->nim),
            'nama' => trim($request->nama),
            'kontak' => trim($request->kontak),
            'email' => trim($request->email),
            'kelamin' => trim($request->kelamin),
        ]);

        Pengguna::create([
            'username' => trim($request->nim),
            'sandi' => sha1(trim($request->nim)),
            'peran' => 'M',
            'pin' => '111111',
            'nama' => trim($request->nama),
        ]);

        return redirect()->route('admin.mahasiswa')->with('success', 'Data mahasiswa telah berhasil ditammbahkan!');
    }

    public function update(Request $request, $nim){
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kontak' => 'required',
            'email' => 'required',
            'kelamin' => 'required',
        ]);

        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return redirect()->route('admin.mahasiswa')->with('error', 'Data mahasiswa tidak valid!');
        }

        $mahasiswa->update([
            'nama' => trim ($request->nama),
            'kontak' => trim ($request->kontak),
            'email' => trim ($request->email),
            'kelamin' => trim ($request->kelamin),
        ]);

        return redirect()->route('admin.mahasiswa')->with('success', 'Data mahasiswa telah berhasil diubah!');
    }

    public function destroy($nim){
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return redirect()->route('admin.mahasiswa')->with('error', 'Data mahasiswa tidak valid!');
        }

        try {
            $mahasiswa->delete();
            return redirect()->route('admin.mahasiswa')->with('success', 'Data mahasiswa telah dihapus!');
        } catch (\Throwable $th) {
            return redirect()->route('admin.mahasiswa')->with('error', 'Gagal menghapus data mahasiswa');
        }
    }
}
