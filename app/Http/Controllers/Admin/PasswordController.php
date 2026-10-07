<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;

class PasswordController extends Controller
{
    public function index(){
        $username = session('username');

        return view('admin.password.index', [
            'hal' => 'password',
            'username' => $username,
        ]);
    }

    public function update(Request $request, $username){
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required',
            'pin' => 'required',
        ]);

        $password_lama = sha1(trim($request->input('password_lama')));
        $password_baru = sha1(trim($request->input('password_baru')));
        $pin = trim($request->input('pin'));

        $pengguna = Pengguna::where('username', $username)->first();

        if ($pengguna && $password_lama === $pengguna->sandi && $pin === $pengguna->pin) {
            $pengguna->update([
                'sandi' => $password_baru,
            ]);
            return redirect()->back()->with('success', 'Password telah berhasil diubah!');
        } else {
            return redirect()->back()->with('error', 'Password lama atau PIN salah!');
        }
    }
}
