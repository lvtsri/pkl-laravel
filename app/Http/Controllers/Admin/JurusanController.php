<?php

namespace App\Http\Controllers\Admin;

use App\Models\Jurusan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JurusanController extends Controller
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

        $jurusan = Jurusan::all();
        return view('admin.jurusan.index', compact('jurusan') + ['hal' => 'data_jurusan']);
    }
}
