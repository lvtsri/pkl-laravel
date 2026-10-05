<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function ensureMhs()
    {
        if (session('peran') != 'M') {
            return redirect('/logout')->with('error', 'Anda bukan mahasiswa! Akan segera di logout-kan');
        }
        return null;
    }

    public function index()
    {
        if ($res = $this->ensureMhs()) return $res;
        return view('mahasiswa.index', ['hal' => 'beranda']);
    }    
}