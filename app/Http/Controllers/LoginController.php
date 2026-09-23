<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    // LOGIN
    public function login(Request $request)
    {
        $username = trim($request->username);
        $sandi = trim($request->sandi);

        // Cari username lewat model Pengguna
        $pengguna = Pengguna::where('username', $username)->first();

        // Username/password salah
        if (!$pengguna || sha1($sandi) !== $pengguna->sandi) {
            return back()->with(
                'login_error',
                'Username atau Password salah!'
            );
        }

        // Password benar, simpan ID untuk lanjut ke verifikasi PIN (2FA)
        session([
            'pin_user_id' => $pengguna->id
        ]);

        return back()->with('show_pin_modal', true);
    }


    // VERIFIKASI PIN (2FA)
    public function verifyPin(Request $request)
    {
        $pin = trim($request->pin);

        // Ambil ID user yang sedang menjalani proses PIN dari session login
        $userId = session('pin_user_id');

        if (!$userId) {
            return redirect()->route('login')
                ->with('pin_error', 'Sesi verifikasi sudah berakhir. Silakan login kembali.');
        }

        $pengguna = Pengguna::find($userId);

        if (!$pengguna) {
            return redirect()->route('login')
                ->with('pin_error', 'Pengguna tidak ditemukan.');
        }

        // Cek PIN
        if ((string) $pin !== (string) $pengguna->pin) {
            return back()->with('pin_error', 'PIN yang Anda masukkan salah.');
        }

        // PIN benar, langsung login user sepenuhnya & bersihkan session PIN sementara
        session([
            'user_id' => $pengguna->id,
            'username' => $pengguna->username,
            'peran' => $pengguna->peran,
            'nama' => $pengguna->nama
        ]);

        session()->forget('pin_user_id');

        return $this->redirectByRole($pengguna);
    }

    // REDIRECT BERDASARKAN PERAN
    private function redirectByRole(Pengguna $pengguna)
    {
        if ($pengguna->peran === 'M') {
            return redirect()->route('mahasiswa');
        } elseif ($pengguna->peran === 'A') {
            return redirect()->route('admin');
        } else {
            return redirect()->route('dosen');
        }
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}