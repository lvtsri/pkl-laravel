<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    private function ensureAdmin()
    {
        if (session('peran') != 'A') {
            return redirect('/logout')->with('error', 'Anda bukan admin! Akan segera di logout-kan');
        }
        return null;
    }
    
    public function index(){
        if ($res = $this->ensureAdmin()) return $res;

        $pengguna = Pengguna::all();
        return view('admin.pengguna.index', compact('pengguna') + ['hal' => 'data_pengguna']);
    }
}
