<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index(){
        $pengguna = Pengguna::all();
        return view('admin.pengguna.index', compact('pengguna') + ['hal' => 'data_pengguna']);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'username' => 'required',
            'peran' => 'required',
            'nama' => 'required',
        ]);

        $exists = Pengguna::where('username', $request->username)->exists();

        if ($exists) {
            return redirect()->route('admin.pengguna')->with('error', 'Username sudah terdaftar!');
        }

        $peran = trim($request->peran);

        if ($peran === 'A') {
            $pinDefault = '123456';
        } elseif ($peran === 'D') {
            $pinDefault = '654321';
        } else {
            $pinDefault = '111111';
        }

        Pengguna::create([
            'username' => trim($request->username),
            'sandi' => sha1(trim($request->username)),
            'peran' => $peran,
            'pin' => $pinDefault,
            'nama' => trim($request->nama),
        ]);

        return redirect()->route('admin.pengguna')->with('success', 'Data pengguna telah berhasil ditambahkan!');
    }

    public function update(Request $request, $username){
        $request->validate([
            'username' => 'required',
            'peran' => 'required',
            'nama' => 'required',
        ]);

        $pengguna = Pengguna::where('username', $username)->first();

        if (!$pengguna) {
            return redirect()->route('admin.pengguna')->with('error', 'Data pengguna tidak valid atau tidak ditemukan!');
        }

        $pengguna->update([
            'peran' => trim($request->peran),
            'nama' => trim($request->nama),
        ]);

        return redirect()->route('admin.pengguna')->with('success', 'Data pengguna telah berhasil diubah!');
    }

    public function destroy($username){
        $pengguna = Pengguna::where('username', $username)->first();
        $pengguna_login = session('username');

        if(!$pengguna){
            return redirect()->route('admin.pengguna')->with('error', 'Data pengguna tidak valid!');
        }

        if ($pengguna_login == $pengguna->username) {
            return redirect()->route('admin.pengguna')->with('error', 'Anda tidak bisa menghapus akun milik anda sendiri!');
        }

        try {
            $pengguna->delete();
            return redirect()->route('admin.pengguna')->with('success', 'Data pengguna telah dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.pengguna')->with('error', 'Gagal menghapus data pengguna');
        }
    }
}
